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

1. **Part 1: Oracle account, VM, Reserved IP, firewall** — ends with a VM
   you can SSH into, with Docker installed and ports 22/80/443 open.
2. **Part 2: DuckDNS hostname and Brevo transactional
   email** — ends with a resolvable `<hostname>.duckdns.org` hostname
   pointing at the Reserved Public IP, and verified Brevo SMTP credentials
   ready to drop into `.env.production`.
3. **Part 3 (this section): application deployment and HTTPS** — clone the
   repo onto the VM, configure `.env.production`, run `docker compose up`,
   and confirm the Let's Encrypt certificate, mail, and data persistence all
   actually work.
4. Part 4: backups, maintenance, and day-2 operations.

Two decisions in Part 1 below are **permanent or easy to silently get wrong**
and are called out in bold where they occur — read those callouts even if
you skim everything else:

- The Oracle **home region** (Germany Central / Frankfurt) can never be
  changed after your account is created.
- The **Reserved (static) Public IP** must be created and attached
  explicitly — if you skip this and just use the IP Oracle assigns
  automatically, it is ephemeral and can change later, which will silently
  break DNS (pointed at this IP in Part 2) and your HTTPS certificate
  (issued against it in Part 3).

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
in Part 3), this means: if Oracle ever reboots the host for maintenance,
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

Part 2 (DuckDNS and Brevo) continues from here.

## Part 2: DuckDNS hostname and Brevo transactional email

This part gets two things working before the app can be deployed in Part 3:
a hostname that resolves to the VM, and an email provider the app can
actually send through. Both are required because the app's `.env.production`
(configured in Part 3) needs a real domain for `APP_URL`/`APP_DOMAIN` and real
SMTP credentials for password-reset and notification emails to work.

One decision below is **easy to get subtly wrong** and is called out where it
occurs: the DuckDNS subdomain's IP field must be set to the **Reserved
Public IP from Part 1**, not left on auto-detect — and Brevo requires a
**separate, explicit sender-verification step** beyond just signing up, or
outbound mail will silently fail.

### Step 2.1 — Register a DuckDNS subdomain pointing at the Reserved Public IP

1. Go to <https://www.duckdns.org> and sign in using an existing Google,
   GitHub, Twitter/X, or Reddit account (DuckDNS has no separate
   email/password signup).
2. On the dashboard, in the subdomain field, type the name you want (e.g.
   `idf-whisper-box`) and click **add domain**. This becomes
   `<chosen>.duckdns.org` — call this `<hostname>` for the rest of this
   runbook.
3. **Set this subdomain's IP field to the Reserved Public IP from Part 1
   (Step 1.4), not "auto detect" and not left blank.** DuckDNS is normally
   designed around a small updater client that keeps re-pushing your
   *current* IP on a schedule, for people with a dynamic home IP address. We
   don't need that here: Oracle's Reserved Public IP from Step 1.4 never
   changes, so this is a one-time, static entry. Paste the Reserved Public
   IP directly into the IP field next to your subdomain and click
   **update ip**.
4. Wait a minute or two for DNS to propagate, then verify from your local
   machine:

   ```bash
   dig +short <chosen>.duckdns.org
   ```

   Expected: prints exactly the Reserved Public IP from Part 1 (the same
   address you noted in Step 1.4) and nothing else. If this prints nothing,
   or a different IP, go back to the DuckDNS dashboard and confirm the IP
   field for this subdomain was saved as the Reserved Public IP, not left on
   auto-detect.
5. Keep `<hostname>` (i.e. `<chosen>.duckdns.org`) noted — it becomes
   `APP_URL` (as `https://<hostname>`) and `APP_DOMAIN` in `.env.production`
   in Part 3.

### Step 2.2 — Create a Brevo account

1. Go to <https://www.brevo.com> and sign up for the free tier (email and
   password, or an existing Google account).
2. Brevo emails you a confirmation link — open it and click through to
   activate the account.
3. Complete the account setup questions (business name, use case, etc.) if
   prompted.

**Creating the account is not enough on its own — mail will not send until
you complete Step 2.3 below.** This is the single most commonly skipped step
in Brevo setup, and skipping it does not fail loudly: emails just queue or
fail silently, which looks like a bug in the app rather than an incomplete
mail setup.

### Step 2.3 — Verify a sender email address (do not skip this)

1. In the Brevo dashboard, open the left navigation menu → **Senders & IP**
   → **Senders**.
2. Click **Add a sender**. Enter the email address you want the app to send
   from (this becomes `MAIL_FROM_ADDRESS` in Step 2.4) and a display name.
3. Brevo sends a confirmation email to that address. Open it and click the
   verification link inside.
4. Back on the **Senders** page, confirm this sender now shows a
   verified/green status. **If it still shows "pending" or unverified, stop
   here — outbound mail will not work, and Part 3's first deploy will appear
   to work but every email the app tries to send (password resets, etc.)
   will silently fail to arrive.** Re-check the confirmation email (including
   spam folder) and re-click the verification link if needed.

### Step 2.4 — Generate SMTP credentials and map them to `.env.production`

1. In the Brevo dashboard, open the left navigation menu → **SMTP & API** →
   **SMTP** tab.
2. Note the **SMTP login** shown on this page (it looks like an email
   address ending in `@smtp-brevo.com` — this is not the same as your Brevo
   account login email).
3. Click **Generate a new SMTP key**, give it a name (e.g.
   `idf-whisper-box`), and copy the generated key immediately — Brevo only
   displays it once.
4. These three values map directly onto keys that already exist (with
   `CHANGE-ME` placeholders) in `.env.production.example`:

   | Brevo console value | `.env.production` key |
   | --- | --- |
   | SMTP login (SMTP & API → SMTP) | `MAIL_USERNAME` |
   | Generated SMTP key | `MAIL_PASSWORD` |
   | Verified sender address (Step 2.3) | `MAIL_FROM_ADDRESS` |

   The remaining mail keys already present in `.env.production.example` —
   `MAIL_HOST=smtp-relay.brevo.com`, `MAIL_PORT=587`, and
   `MAIL_ENCRYPTION=tls` — are already correct for Brevo's SMTP relay and do
   not need to change.
5. You don't need to edit `.env.production` yet — Part 3 covers cloning the
   repo and filling in the full file. For now, just keep the SMTP login, the
   generated SMTP key, and the verified sender address somewhere safe until
   then.

### End of Part 2 — what you should have now

- A DuckDNS hostname, `<hostname>` (`<chosen>.duckdns.org`), with its IP
  field statically set to the Reserved Public IP from Part 1 and confirmed
  with `dig +short <chosen>.duckdns.org`.
- A Brevo account with a sender email address that shows a
  verified/green status under **Senders & IP** → **Senders** (not pending).
- An SMTP login and a generated SMTP key from **SMTP & API** → **SMTP**,
  ready to become `MAIL_USERNAME` and `MAIL_PASSWORD` respectively, with the
  verified sender address ready to become `MAIL_FROM_ADDRESS`.

Part 3 (application deployment and HTTPS) continues from here.

## Part 3: application deployment and HTTPS

This is where everything from Parts 1-2 — the VM, Docker, the Reserved IP,
the DuckDNS hostname, the Brevo SMTP credentials — and everything already
built into this repository's `Dockerfile`, `docker/Caddyfile`,
`docker/entrypoint.sh`, and `docker-compose.yml` get wired together and
tested for real, for the first time. No part of this repo's Docker setup has
ever been run anywhere before this point — there is no Docker engine in the
development environment this app was built in — so every check in this
section is a genuine pass/fail test, not a formality.

Three things below are **easy to get wrong in ways that don't fail loudly**,
and are called out in bold where they occur:

- `APP_KEY` must be generated **before** the container's first boot, on a
  separate machine — the container deliberately refuses to start if it's
  missing, rather than silently generating one for you.
- The SQLite database file and the book-loan photo storage directory need to
  actually be writable by the user PHP runs as inside the container — the
  only way to prove this is to make the container do real writes (a
  migration, and a real photo upload), not just watch it start.
- The HTTPS certificate only comes up automatically if DNS, the Reserved IP,
  and both firewalls (Oracle's Security List from Step 1.5 and `ufw` from
  Step 1.9) were all already correct *before* the container's first boot —
  if any one of them is wrong, the symptom just looks like "it's taking a
  while," not "here is the one thing that's broken."

### Step 3.1 — Clone the repo and configure `.env.production`

1. SSH into the VM using the command from Step 1.6:

   ```bash
   ssh -i ~/.ssh/idf-whisper-box ubuntu@<reserved-ip>
   ```

2. Clone the repository onto the VM:

   ```bash
   git clone https://github.com/AbdelazizTaoufik/idf-worry-box.git idf-whisper-box
   cd idf-whisper-box
   ```

3. Copy the committed template to the real, git-ignored production env file:

   ```bash
   cp .env.production.example .env.production
   ```

   `.env.production` is listed in `.gitignore` and is never committed — it
   only ever exists on the VM (and, transiently, wherever you draft it).

4. **Generate `APP_KEY` now, before you touch `docker compose` at all — and
   generate it on a different machine, not on the VM, and never let the
   container generate it for you.** `docker/entrypoint.sh` (already
   committed, from Task 2) checks `APP_KEY` on every container start and
   deliberately refuses to boot if it's empty:

   ```sh
   if [ -z "$APP_KEY" ]; then
     echo "FATAL: APP_KEY is not set. Generate one with 'php artisan key:generate --show' and put it in .env.production before starting this container." >&2
     exit 1
   fi
   ```

   This is intentional: an app key controls session/cookie encryption and
   must stay stable for the life of the deployment, so it must be a value
   *you* generate and record, not something regenerated on every container
   restart. Run this on any machine that already has PHP and this repo's
   Composer dependencies installed (e.g. your local development machine —
   **not** the VM, which has Docker but not a bare PHP install, and **not**
   by running it inside the container, which is exactly the failure mode
   this check exists to prevent):

   ```bash
   php artisan key:generate --show
   ```

   Expected output: a single line like `base64:AbCdEf...==` (44 base64
   characters after the `base64:` prefix). Copy that whole line.

5. On the VM, open `.env.production` in an editor (`nano .env.production`)
   and fill in every `CHANGE-ME` value:

   | `.env.production` key | Value | Source |
   | --- | --- | --- |
   | `APP_KEY` | `base64:...` from sub-step 4 | generated just now, on a machine with PHP — never left blank |
   | `APP_URL` | `https://<hostname>` | `<hostname>` from Part 2, Step 2.1 |
   | `APP_DOMAIN` | `<hostname>` (no `https://`, no trailing slash) | same `<hostname>` — this is what Caddy reads to know which domain to request a certificate for |
   | `MAIL_USERNAME` | the SMTP login | Part 2, Step 2.4 |
   | `MAIL_PASSWORD` | the generated SMTP key | Part 2, Step 2.4 |
   | `MAIL_FROM_ADDRESS` | the verified sender address | Part 2, Step 2.3 |

   Leave every other line in the file as the template already has it
   (`DB_CONNECTION=sqlite`, `MAIL_HOST=smtp-relay.brevo.com`, `MAIL_PORT=587`,
   `MAIL_ENCRYPTION=tls`, etc. — these are already correct and don't need
   changing). Save and close the file.

6. Double check there is no stray `CHANGE-ME` left anywhere in the file:

   ```bash
   grep CHANGE-ME .env.production
   ```

   Expected: no output (no matches). If this prints any line, go back and
   fill in that value before continuing.

### Step 3.2 — First boot

On the VM, from inside the `idf-whisper-box` directory:

```bash
./deploy.sh
```

This script (already committed) runs, in order: `git pull --ff-only`,
`docker compose build`, `docker compose up -d`, then
`docker compose logs --tail=50 app`.

Expected, reading through the tail of logs printed at the end:

- The image builds without error (first run only — this takes a few
  minutes on the Ampere A1's 2 OCPUs).
- `docker/entrypoint.sh` runs: it creates `/app/storage/database` and
  `/app/storage/app/book-loans` inside the container, touches the SQLite
  file, then runs `php artisan migrate --force` followed by
  `config:cache`, `route:cache`, and `view:cache` — you should see
  migration output (table names scrolling by) with **no error lines**, not
  just "Nothing to migrate."
- Caddy logs a line indicating it obtained (or is requesting) a TLS
  certificate for the `APP_DOMAIN` value you set in Step 3.1 — look for
  text referencing the ACME/Let's Encrypt process and your `<hostname>`.
  There should be no repeating "challenge failed" errors.

If you see repeated certificate-request retries instead of success, stop and
recheck, in this order, before looking anywhere else: `dig +short
<hostname>.duckdns.org` still resolves to the Reserved IP (Part 2, Step
2.1), port 80 is open in both the Oracle Security List (Step 1.5) and `ufw`
(Step 1.9), and `APP_DOMAIN` in `.env.production` exactly matches
`<hostname>` with no typo. Caddy's HTTP-01 challenge needs all three to be
correct simultaneously on the very first attempt it can reach from the
internet — a wrong value in any one of them just looks like "it's slow,"
not "here is the broken thing."

### Step 3.3 — Functional check

This is the real test of Tasks 2-6's Docker setup — not "the container
started," but "a real user can do everything the app is for, and the data
survives a restart." Do not skip any of these three checks.

1. **Prove the TLS chain end-to-end.** From your local machine (not the VM):

   ```bash
   curl -I https://<hostname>.duckdns.org
   ```

   Expected: `HTTP/2 200` (or a redirect, e.g. `HTTP/2 302` to `/login`),
   with no certificate warning or error. **Do not add `-k` (or
   `--insecure`) to this command.** The entire point of this check is that
   `curl` validates the certificate against its normal trusted CA bundle,
   the same way a real visitor's browser would — `-k` skips that
   validation, so a `-k`'d request can succeed even if DNS, the firewall, or
   Caddy's certificate issuance is subtly broken. A plain `curl -I` (no
   `-k`) succeeding is the actual proof that DNS (Part 2), both firewall
   layers (Part 1), and Caddy's Let's Encrypt issuance (Step 3.2) are all
   correctly wired together.

2. **Prove mail works end-to-end.** In a browser, go to
   `https://<hostname>.duckdns.org` and register a new test account through
   the normal registration form. Confirm the verification email actually
   arrives in that account's inbox (check spam too) and that clicking its
   link marks the account verified. This is the real, end-to-end test of
   the Brevo credentials from Part 2 — if this email never arrives, go back
   to Part 2, Step 2.3 and confirm the sender is still shown as verified.

3. **Prove the writable volumes work, and prove it with a restart.** Still
   logged in as that now-verified test account:
   - Open `/create-submission` and submit a Kummerkasten entry.
   - Open `/buecher` (book loans) and borrow a book, which includes
     uploading a book-loan photo through the UI.
   - If either of these fails with a permission or write error, **that is
     exactly the risk this check exists to catch**: Docker's named volumes
     (`sqlite-data` and `book-loan-photos` in `docker-compose.yml`) are
     created fresh and owned by root, and FrankenPHP's PHP process may not
     be able to write to them. The fix belongs in the `Dockerfile` (Task
     2's image build, e.g. its `chown`/`USER` setup), not in this runbook —
     do not try to work around it by hand-`chmod`-ing inside the running
     container.
   - Now restart the container and confirm both the submission and the
     photo are still there:

     ```bash
     docker compose restart app
     ```

     Reload `/admin/submissions` (or wherever the submission is visible) and
     the book loan's photo in the browser. **Both must still be present
     after the restart.** This is what actually proves the data lives in
     the named volumes, not in the container's writable layer — a
     container's own writable layer is discarded on certain lifecycle
     events, while named volumes are not; a restart that still shows the
     data is the concrete evidence, not an assumption.

If all three checks pass, the deployment is functionally complete: HTTPS
works end-to-end, outbound mail works end-to-end, and writes to both
persistent volumes survive a container restart.

### Step 3.4 — Redeploy procedure

For any future code change, the workflow is the same every time:

1. On your development machine: commit and push the change as normal
   (`git add`, `git commit`, `git push`).
2. On the VM, inside the `idf-whisper-box` directory:

   ```bash
   ./deploy.sh
   ```

This re-runs `git pull --ff-only`, rebuilds the image with `docker compose
build`, and restarts the container with `docker compose up -d` — then tails
the last 50 lines of the `app` service's logs so you can immediately see
whether migrations ran cleanly and the container is healthy.

**A rebuild and restart never touches the named volumes.** `sqlite-data`,
`book-loan-photos`, `caddy-data`, and `caddy-config` (declared in
`docker-compose.yml`) persist across every `./deploy.sh` run, exactly as
they persisted across the `docker compose restart app` in Step 3.3 — the
SQLite database, all uploaded book-loan photos, and the issued TLS
certificate all survive a redeploy untouched. Only the application code and
the image itself are replaced.

### End of Part 3 — what you should have now

- The repo cloned onto the VM, with `.env.production` fully filled in (no
  `CHANGE-ME` placeholders left) and `APP_KEY` set to a value generated
  outside the container, before the container's first boot.
- A running deployment reachable at `https://<hostname>.duckdns.org` with a
  valid, browser-trusted TLS certificate (confirmed with a plain `curl -I`,
  no `-k`).
- A verified test account that received a real verification email through
  Brevo.
- A Kummerkasten submission and a book-loan photo upload, both confirmed to
  still be present after a `docker compose restart app` — proving the
  named volumes, not the container's writable layer, hold the data.
- A standing redeploy procedure (`git push` from a dev machine, then
  `./deploy.sh` on the VM) that rebuilds the image and restarts the
  container without touching any of the named volumes.

Part 4 (backups, maintenance, and day-2 operations) continues from here.
