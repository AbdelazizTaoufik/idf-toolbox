# Oracle Cloud Deployment Runbook

This runbook takes the idf-whisper-box Laravel app from **nothing** — no Oracle
account, no server, no SSH key — to a production deployment running on an
Oracle Cloud Always Free Ampere A1 VM.

It is written for a human to follow step by step, by hand, with a web browser
and a terminal open side by side. Every step gives the exact console menu
path, field name, and value to enter — if a step just says "configure X"
without a value, that's a bug in this document, not a thing to improvise.

The runbook is split into four parts, each appended to this same file as it's
written:

1. **Part 1 (this section): Oracle account, VM, Reserved IP, firewall** —
   ends with a VM you can SSH into, with Docker installed and ports 22/80/443
   open.
2. Part 2: application deployment (clone repo, configure `.env`, `docker
   compose up`).
3. Part 3: domain, HTTPS/Let's Encrypt, DNS.
4. Part 4: backups, maintenance, and day-2 operations.

Two decisions in Part 1 below are **permanent or easy to silently get wrong**
and are called out in bold where they occur — read those callouts even if
you skim everything else:

- The Oracle **home region** (Germany Central / Frankfurt) can never be
  changed after your account is created.
- The **Reserved (static) Public IP** must be created and attached
  explicitly — if you skip this and just use the IP Oracle assigns
  automatically, it is ephemeral and can change later, which will silently
  break DNS and your HTTPS certificate (Part 3).

## Part 1: Oracle account, VM, Reserved IP, firewall

### Step 1.1 — Create the Oracle Cloud account

1. Go to <https://www.oracle.com/cloud/free/> and click **Start for free**.
2. Fill in the signup form (email, password, country, etc.).
3. **On the account information page, find the "Home Region" dropdown and
   select "Germany Central (Frankfurt)".**
   - **This cannot be changed after signup — it is permanent for the
     lifetime of this Oracle Cloud account.** We're using Frankfurt for
     GDPR / EU data-residency reasons.
   - Before you click the final submit/continue button, scroll back up and
     re-read the region field to confirm it still shows **Germany Central
     (Frankfurt)** — some signup flows reset or default this field if you
     navigate back and forth between pages.
4. Complete the rest of signup (card verification, phone verification, etc.)
   and wait for the "Your account is ready" confirmation email. This can take
   a few minutes.
5. Log in to the OCI Console at <https://cloud.oracle.com> using the tenancy
   name / email / password from signup.

### Step 1.2 — Generate an SSH key pair

If you don't already have an SSH key you want to dedicate to this server,
generate one on your local machine (not on the server — it doesn't exist
yet):

```bash
ssh-keygen -t ed25519 -f ~/.ssh/idf-whisper-box -C "idf-whisper-box oracle vm"
```

- Press Enter to accept no passphrase, or set one — either is fine.
- This creates two files: `~/.ssh/idf-whisper-box` (private key — never
  share this) and `~/.ssh/idf-whisper-box.pub` (public key — this is what
  you upload to Oracle in the next step).

### Step 1.3 — Create the Compute instance

1. In the OCI Console, open the navigation menu (hamburger icon, top left) →
   **Compute** → **Instances**.
2. Click **Create instance**.
3. **Name**: enter `idf-whisper-box` (or any name you prefer — it's just a
   label).
4. **Image and shape** section → click **Edit**:
   - **Image**: click **Change image**, select **Canonical Ubuntu**, and
     pick the **22.04** version. Make sure the image variant shown is the
     **aarch64 / ARM-based** build (Oracle lists it separately from the
     x86-64 build once you've selected an Ampere shape below — if you pick
     the shape first, the image list will already be filtered to ARM
     images). Click **Select image**.
   - **Shape**: click **Change shape**, select the **Ampere** series, then
     choose **VM.Standard.A1.Flex**. Set:
     - **Number of OCPUs**: `2`
     - **Amount of memory (GB)**: `12`
     - **This is the entire Always Free Ampere A1 allotment** (as of 2026,
       Oracle's Always Free tier provides 2 OCPU / 12GB total for A1
       instances — not per-instance — so there is no free headroom left to
       run a second always-on A1 instance alongside this one). Click
       **Select shape**.
5. **Networking** section: leave the defaults (Oracle creates a new VCN with
   a public subnet for you on first use). Confirm **"Assign a public IPv4
   address"** is checked — this gives the instance an ephemeral public IP for
   now; we replace it with a Reserved IP in Step 1.4.
6. **Add SSH keys** section: select **Paste public keys**, then paste the
   contents of `~/.ssh/idf-whisper-box.pub` (run `cat ~/.ssh/idf-whisper-box.pub`
   locally and copy the single line of output).
7. Leave boot volume and other sections at their defaults.
8. Click **Create**. Wait for the instance's state to turn from
   "Provisioning" to **Running** (usually 1-2 minutes).
9. On the instance's detail page, note the **Public IP Address** shown under
   "Instance access" — this is the temporary ephemeral IP. We're about to
   replace it.

### Step 1.4 — Reserve a Public IP and attach it (do not skip this)

**This step is the one people most often skip because the instance already
"works" with the ephemeral IP Oracle gave it for free. Do not skip it.** An
ephemeral public IP can change — for example if the VNIC is ever detached and
recreated, or during certain Oracle maintenance events — and if that happens
after you've pointed DNS and issued a Let's Encrypt certificate at it (Part
3), the site silently breaks until you notice and fix DNS by hand.

1. Open the navigation menu → **Networking** → **IP Management** →
   **Reserved Public IPs**.
2. Click **Create Reserved Public IP**.
3. **Name**: enter `idf-whisper-box-reserved-ip`.
4. **Compartment**: leave as your default/root compartment.
5. Click **Create Reserved Public IP**. Note the new IP address shown —
   call this `<reserved-ip>` for the rest of this runbook.
6. Attach it to the instance:
   - Go to **Compute** → **Instances** → click your instance.
   - Under **Resources** (left side of the instance page), click
     **Attached VNICs**, then click the VNIC's name.
   - Under **IP addresses**, click the existing (ephemeral) public IP
     address.
   - Click **Edit**.
   - Change the setting from **Ephemeral public IP** to **Reserved public
     IP**, and select `idf-whisper-box-reserved-ip` from the dropdown.
   - Click **Update**. The ephemeral IP is released and the reserved IP
     takes over the VNIC within a few seconds.
7. Confirm: back on the instance's detail page, **Public IP Address** should
   now show `<reserved-ip>` — the same address you created in sub-step 3,
   not the original ephemeral one from Step 1.3.

### Step 1.5 — Open ports 22, 80, 443 at the Oracle network layer

By default, a freshly created VCN's **Default Security List** only allows
inbound TCP/22 (SSH). We need to also allow 80 (HTTP, used for Let's
Encrypt's certificate challenge in Part 3) and 443 (HTTPS).

1. Open the navigation menu → **Networking** → **Virtual Cloud Networks**.
2. Click the VCN that was created for your instance (its name will look
   like `vcn-<timestamp>` if you used the defaults).
3. In the left-hand resource list, click **Security Lists**.
4. Click **Default Security List for vcn-...**.
5. Under **Ingress Rules**, confirm there's already a rule for port 22
   (Source CIDR `0.0.0.0/0`, protocol TCP, destination port `22`). If your
   console put this instance's networking in a **Network Security Group
   (NSG)** instead of the Security List (check the instance's **Attached
   VNICs** page — if it lists an NSG, edit that NSG's rules instead, using
   the same values below), use whichever one the console actually shows for
   this instance.
6. Click **Add Ingress Rules** and add one rule for port 80:
   - **Source Type**: `CIDR`
   - **Source CIDR**: `0.0.0.0/0`
   - **IP Protocol**: `TCP`
   - **Destination Port Range**: `80`
   - Description (optional): `HTTP`
7. Click **Add Ingress Rules** again and add a second rule for port 443:
   - **Source Type**: `CIDR`
   - **Source CIDR**: `0.0.0.0/0`
   - **IP Protocol**: `TCP`
   - **Destination Port Range**: `443`
   - Description (optional): `HTTPS`
8. Save. You should now see three ingress rules covering ports 22, 80, and
   443, each with source `0.0.0.0/0`.

### Step 1.6 — SSH into the instance

From your local machine:

```bash
ssh -i ~/.ssh/idf-whisper-box ubuntu@<reserved-ip>
```

Replace `<reserved-ip>` with the address from Step 1.4. The default user for
the Canonical Ubuntu image on Oracle Cloud is `ubuntu`. Accept the host key
fingerprint prompt on first connect.

If this hangs instead of connecting, double check Step 1.5 (port 22 ingress
rule) and that you're using the reserved IP, not the old ephemeral one.

### Step 1.7 — Install Docker Engine and the Compose plugin

Run the following on the VM (over the SSH session from Step 1.6). This uses
Docker's official apt-repository install method for Ubuntu, current as of
late 2026:

```bash
# Prerequisites
sudo apt update
sudo apt install -y ca-certificates curl

# Add Docker's official GPG key
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# Add the Docker apt repository
sudo tee /etc/apt/sources.list.d/docker.sources > /dev/null <<EOF
Types: deb
URIs: https://download.docker.com/linux/ubuntu
Suites: $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}")
Components: stable
Architectures: $(dpkg --print-architecture)
Signed-By: /etc/apt/keyrings/docker.asc
EOF

sudo apt update

# Install Docker Engine, CLI, containerd, Buildx, and the Compose plugin
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

Verify the install:

```bash
sudo docker run hello-world
```

Expected: a "Hello from Docker!" message. If you'd rather not type `sudo`
before every `docker` command, add your user to the `docker` group and
re-login:

```bash
sudo usermod -aG docker $USER
exit
```

Then reconnect with the same `ssh` command from Step 1.6.

> Note: these exact commands were checked against Docker's official Ubuntu
> install docs (<https://docs.docker.com/engine/install/ubuntu/>) at the time
> this runbook was written. Docker's install instructions do shift over time
> — if `apt install` fails on the package list above, check that page again
> before troubleshooting further.

### Step 1.8 — Enable Docker to start at boot

```bash
sudo systemctl enable --now docker
```

This is the only step needed to make containers survive a reboot — it does
not require writing any custom systemd unit. Combined with this project's
`docker-compose.yml` using `restart: unless-stopped` on its services (set up
in Part 2), this means: if Oracle ever reboots the host for maintenance,
Docker itself comes back up automatically because it's now a boot-enabled
service, and then Docker restarts the app's containers automatically because
of their `restart: unless-stopped` policy. No manual intervention needed
after a maintenance reboot.

Verify it's enabled:

```bash
systemctl is-enabled docker
systemctl is-active docker
```

Expected: `enabled` and `active`.

### Step 1.9 — Configure the host firewall (`ufw`)

Oracle's network-level rules from Step 1.5 only control traffic at the cloud
network layer. Ubuntu's own host firewall, `ufw`, is a second, independent
layer and must also allow the same three ports — otherwise traffic reaching
the VM is still dropped before it hits Docker.

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

When prompted `Command may disrupt existing ssh connections. Proceed with
operation (y|n)?`, type `y` — this is safe because you already allowed port
22/tcp in the command right before it.

Verify all three ports are allowed:

```bash
sudo ufw status
```

Expected output includes all three of:

```
22/tcp                     ALLOW       Anywhere
80/tcp                     ALLOW       Anywhere
443/tcp                    ALLOW       Anywhere
```

(plus the IPv6 equivalents, `22/tcp (v6)`, `80/tcp (v6)`, `443/tcp (v6)`,
which `ufw` adds automatically).

### End of Part 1 — what you should have now

- An Oracle Cloud account with its home region permanently set to Germany
  Central (Frankfurt).
- A running `VM.Standard.A1.Flex` instance (2 OCPU / 12GB RAM — the full
  Always Free Ampere A1 allotment) running Canonical Ubuntu 22.04 (ARM64).
- A **Reserved** (not ephemeral) Public IP attached to that instance.
- Ports 22, 80, and 443 open both in Oracle's Security List/NSG and in the
  VM's own `ufw`.
- Docker Engine and the Compose plugin installed, with Docker enabled to
  start automatically at boot.
- An active SSH session command you can repeat any time:
  `ssh -i ~/.ssh/idf-whisper-box ubuntu@<reserved-ip>`.

Part 2 (application deployment) continues from here.
