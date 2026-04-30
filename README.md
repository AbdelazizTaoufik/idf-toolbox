# IDF Toolbox

Die **IDF Toolbox** ist eine zentrale Verwaltungs- und Organisationsplattform für die Islamische Denkfabrik e.V. Das Projekt verfolgt das Ziel, die Ansammlung von Wissen und die Stärkung der Gemeinschaft durch digitale Werkzeuge zu fördern.

**Website:** [https://islamischedenkfabrik.de/](https://islamischedenkfabrik.de/)

---

## 🎯 Übersicht

Die IDF Toolbox befindet sich noch im Aufbau. Der digitale **anonyme Kummerkasten** ist bereits einsatzbereit und wird kontinuierlich um weitere Funktionen erweitert.

### ✨ Aktuelle Features

#### 🎁 Anonymer Kummerkasten

Ein offenes Forum für die Mitgliederund Besucher der Islamischen Denkfabrik e.V., um:

- **Konstruktive Kritik** zu äußern
- **Verbesserungsvorschläge** zu machen
- **Persönliche Anliegen** zu teilen, die persönlich schwer zu äußern sind

Der Kummerkasten ermöglicht es schüchternen oder zurückhaltenden Personen, ihre Gedanken anonym einzubringen und trägt so zu einer besseren Gemeinschaftserfahrung bei.

**Optionale Zuordnung zu Sitzungsgruppen:**
Beiträge können einer Sitzungsgruppe zugeordnet werden, damit relevante Gruppenleiter sich diesem Anliegen verstärkt widmen können.

#### 🔐 Admin-Bereich

Der Vorstand hat Zugriff auf:

- **Kummerkasten-Einträge** einsehen und verwalten
- **Sitzungsgruppen** erstellen, bearbeiten und verwalten
- Zusätzliche Verwaltungsfunktionen

---

## 🛠️ Technologie-Stack

- **Backend:** Laravel 9.x
- **Frontend:** Blade Templates, Alpine.js, Tailwind CSS
- **Datenbank:** MySQL / MariaDB
- **Build Tool:** Vite
- **Frontend UI:** Flowbite
- **Authentication:** Laravel Sanctum (optional für API)

---

## 📋 Anforderungen

- PHP >= 8.0.2
- Composer
- Node.js & npm
- MySQL oder MariaDB
- Git

---

## 🚀 Installation

### 1. Repository klonen

```bash
git clone <repository-url>
cd idf-whisper-box
```

### 2. Abhängigkeiten installieren

```bash
composer install
npm install
```

### 3. Umgebungsvariablen konfigurieren

```bash
cp .env.example .env
```

Bearbeite die `.env`-Datei und konfiguriere deine Datenbankverbindung:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=idf_toolbox
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Application Key generieren

```bash
php artisan key:generate
```

### 5. Datenbank-Migration ausführen

```bash
php artisan migrate
```

### 6. Frontend bauen

```bash
npm run build
```

Für Entwicklung:

```bash
npm run dev
```

### 7. Server starten

```bash
php artisan serve
```

Die Anwendung ist nun unter `http://localhost:8000` erreichbar.

---

## 📁 Projektstruktur

```
idf-whisper-box/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── SubmissionController.php
│   │   │   ├── MeetingGroupController.php
│   │   │   └── ProfileController.php
│   │   └── Requests/
│   └── Models/
│       ├── Submission.php
│       ├── MeetingGroup.php
│       └── User.php
├── resources/
│   ├── views/
│   │   ├── create-submission.blade.php
│   │   ├── admin/
│   │   └── components/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── auth.php
├── database/
│   ├── migrations/
│   └── seeders/
└── config/
```

---

## 🔗 API-Routen

### Öffentliche Routen

- `GET /` – Willkommensseite
- `GET /create-submission` – Kummerkasten-Formular
- `POST /store-submission` – Kummerkasten-Eintrag einreichen
- `GET /submission-response` – Bestätigungsseite nach Einreichung

### Admin-Routen (erfordert Admin-Authentifizierung)

- `GET /admin` – Admin-Dashboard
- `GET /admin/submissions` – Alle Kummerkasten-Einträge (mit Suche & Filterung)
- `GET /admin/meeting-groups` – Sitzungsgruppen-Verwaltung
- `POST /admin/meeting-groups` – Neue Sitzungsgruppe erstellen
- `PATCH /admin/meeting-groups/{id}` – Sitzungsgruppe aktualisieren
- `DELETE /admin/meeting-groups/{id}` – Sitzungsgruppe löschen

---

## 📊 Datenmodelle

### Submission (Kummerkasten-Eintrag)

```php
- id (UUID)
- title (string) – Betreff
- text (text) – Inhalt
- meeting_group_id (UUID, optional) – Zugeordnete Sitzungsgruppe
- created_at (timestamp)
- updated_at (timestamp)
```

### MeetingGroup (Sitzungsgruppe)

```php
- id (UUID)
- name (string) – Gruppenname
- description (text, optional) – Beschreibung
- weekday (string) – Wochentag (z.B. 'monday', 'tuesday', ...)
- time (time) – Uhrzeit des Treffens
- is_public (boolean) – Ist die Gruppe öffentlich sichtbar?
- created_at (timestamp)
- updated_at (timestamp)
```

---

## 🔐 Authentifizierung & Autorisierung

Die Anwendung nutzt **Laravel Breeze** für die Benutzerauthentifizierung. Der Admin-Bereich ist durch ein `admin` Middleware geschützt, das nur authentifizierten Benutzern mit Admin-Rolle Zugriff gewährt.

---

## 🧪 Testen

Tests können mit PHPUnit ausgeführt werden:

```bash
php artisan test
```

---

## 💡 Best Practices

- **Anonymität bewahren:** Der Kummerkasten speichert keine Benutzerinformationen
- **CSRF-Schutz:** Alle Formulare sind durch CSRF-Token geschützt
- **Input-Validierung:** Alle Eingaben werden validiert bevor sie gespeichert werden

---

## 📝 Lizenz

Dieses Projekt ist unter der [MIT License](LICENSE) lizenziert.

---

## 📞 Support & Kontakt

Für Fragen oder Unterstützung:

- **Website:** [https://islamischedenkfabrik.de/](https://islamischedenkfabrik.de/)
- **GitHub:** [AbdelazizTaoufik/idf-whisper-box](https://github.com/AbdelazizTaoufik/idf-toolbox)

---

**Status:** In Arbeit 🚀
