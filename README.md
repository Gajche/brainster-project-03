# Brainster Project 3

---

## Еволуција на Сонот / Evolution of the Dream

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=flat&logo=javascript&logoColor=black)
![jQuery](https://img.shields.io/badge/jQuery-4.x.x-0769AD?style=flat&logo=jquery&logoColor=white)
![Leaflet](https://img.shields.io/badge/Leaflet-1.9.4-199900?style=flat&logo=leaflet&logoColor=white)
![OpenStreetMap](https://img.shields.io/badge/OpenStreetMap-Map_Data-7EBC6F?style=flat&logo=openstreetmap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.8-7952B3?style=flat&logo=bootstrap&logoColor=white)
![Toastr](https://img.shields.io/badge/Toastr-2.1.4-F2709C?style=flat&logo=javascript&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=flat&logo=vite&logoColor=white)
![Mailpit](https://img.shields.io/badge/Mailpit-Local_Mail-00B4D8?style=flat&logo=maildotru&logoColor=white)

---

A web-based platform for the **Еволуција на Сонот** arts and culture festival held in Macedonia. The platform serves as a public information hub and an artist application management system, combining a Macedonian Cyrillic public frontend with a dedicated admin panel for festival organizers.

---

## Features

**Public**

- Home, Art City, Blog, and Work With Us pages in Macedonian Cyrillic.
- **Interactive Art City Map**: Built with Leaflet.js and OpenStreetMap, featuring custom pins and interactive venue markers.
- **Artist Application Form**: Integrated frontend (jQuery) and backend (Laravel) validation with Toastr notifications.
- Responsive - mobile-first design optimized for all screen sizes.

**Artists**

- Submit applications with personal info, collaboration areas, and PDF portfolios.
- Real-time feedback via Toastr notifications on form submission.
- Automatic confirmation emails via Mailpit integration.

**Admins**

- Secure login via Laravel Breeze
- Dashboard showing approved applications grouped by year
- Review, approve, or reject pending applications (current year only - past years are read-only)
- Send a custom message to the artist on approval/rejection
- Search applications by name, surname, email, and phone

---

## Tech Stack

| Layer         | Technology                            |
| ------------- | ------------------------------------- |
| Framework     | Laravel 12                            |
| Language      | PHP 8.2+                              |
| Database      | MySQL 8.0                             |
| Mapping       | Leaflet.js & OpenStreetMap            |
| UI Components | jQuery, Toastr.js & Alpine.js         |
| Auth          | Laravel Breeze (Blade)                |
| Public CSS    | Tailwind CSS 4 + `@tailwindcss/forms` |
| Admin CSS     | Bootstrap 5.3.8                       |
| Validation    | Javascript                            |
| Build tool    | Vite 8                                |
| Mail testing  | Mailpit                               |
| Font          | Fira Sans (Google Fonts)              |

---

## Prerequisites

Make sure you have the following installed before cloning:

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL 8.0
- [Mailpit](https://github.com/axllent/mailpit/releases) (for local email testing)

---

## Setup - Fresh Clone

### Clone the repository

```bash
git clone https://git.brainster.co/Dejan.Nikolovski-FS21/brainster-project-3.git

cd your-folder
```

## Quick Start (Recommended)

### Windows

- Double-click `setup.bat` in the project folder **or** run it from Command Prompt:

```bash
setup.bat
```

### Mac / Linux / WSL

- Run the setup script:

```bash
chmod +x setup.sh   # Only needed once

./setup.sh

```

### Both scripts will automatically:

- Install dependencies (if missing)
- Create/configure .env
- Generate app key
- Install Laravel Breeze
- Install NPM dependencies
- Build frontend assets
- Run migrations + seed initial data
- Start the server

**After setup finishes, open:**
**http://127.0.0.1:8000**

## Manual setup

### 1. Install PHP dependencies

```bash
composer install
```

### 2. Install Node dependencies

```bash
npm install
```

### 3. Create your environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure the database

Open `.env` and set your MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then create the database (OPTIONAL):

```bash
mysql -u root -p -e "CREATE DATABASE evolucija_na_sonot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. Configure Mailpit (local email testing)

Set these values in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@evolucija.com"
MAIL_FROM_NAME="Еволуција на Сонот"
```

### 6. Run migrations and seed the admin user

```bash
php artisan migrate #type yes when prompted if db is not created already
php artisan db:seed --class=AdminUserSeeder
```

This creates the default admin account:

| Field    | Value                 |
| -------- | --------------------- |
| Email    | `admin@evolucija.com` |
| Password | `password`            |

### 7. Link the storage directory

```bash
php artisan storage:link
```

### 8. Add placeholder images (only if they're missing)

Place your image assets in `storage/app/public/images/`. The following files are expected by the views:

```
nav-logo.svg          - Navbar dandelion logo
footer-logo.svg       - Footer dandelion logo
hero-face.svg         - Home page hero image
video-bg.svg          - Video section background
event-1.svg           - Previous events image
insta-1.svg           - Instagram grid image 1
insta-2.svg           - Instagram grid image 2
insta-3.svg           - Instagram grid image 3
insta-4.svg           - Instagram grid image 4
artist-1.jpg          - Artist card 1
artist-2.jpg          - Artist card 2
artist-3.jpg          - Artist card 3
artist-4.jpg          - Artist card 4
art-city-1.png        - Gallery image 1
art-city-2.png        - Gallery image 2
art-city-3.png        - Gallery image 3
art-city-4.png        - Gallery image 4
art-city-5.png        - Gallery image 5
blog-hero.jpg         - Blog page hero
edition-1.jpg         - Blog edition 1
edition-2.jpg         - Blog edition 2
edition-3.jpg         - Blog edition 3
topo-pattern.svg      - Art City hero background
...
```

### 9. Build front-end assets

For production:

```bash
npm run build
```

For local development (with hot reload):

```bash
npm run dev
```

### 10. Start the development server

```bash
php artisan serve
```

The app will be available at [http://localhost:8000](http://localhost:8000).

---

## Start Mailpit (email testing)

### Prerequisites for Windows

Install **Mailpit** for local email testing (recommended replacement for Mailtrap):

1. Download from: https://github.com/axllent/mailpit/releases/latest  
   `mailpit-windows-amd64.zip`
2. Extract `mailpit.exe` to e.g. `C:\mailpit`
3. Run in a separate terminal (keep it open):

```bash
C:\mailpit\mailpit.exe
```

- **SMTP:** `localhost:1025`
- **Web UI:** [http://localhost:8025](http://localhost:8025)

All outgoing emails (application confirmations, admin approval/rejection notifications) will appear in the Mailpit inbox.
Password reset link will appear in the Mailpit inbox as well.

---

## User Roles

| Role    | Access                                             | Auth Required |
| ------- | -------------------------------------------------- | ------------- |
| Visitor | Home, Art City, Blog, Work With Us                 | No            |
| Artist  | All public pages + submit application form         | No            |
| Admin   | Admin panel - review, approve, reject applications | Yes           |

---

## Admin Panel

The admin panel is accessible at `/admin` and is **not linked** in the public navigation.

**Admin dashboard URL:** [http://localhost:8000/admin](http://localhost:8000/admin)

**Key admin flows:**

1. Log in at `/admin/login`
2. Dashboard shows all approved applications grouped by year
3. Pending applications at `/admin/applications/pending`
4. Click **Прегледај** on any application to open the review page
5. Choose **Одобри** or **Одбиј**, write a message, and submit
6. The artist receives an email automatically
7. Only current-year applications can be actioned - past years are read-only

---

## Project Structure

```
app/
├-- Http/
│   ├-- Controllers/
│   │   ├-- Admin/
│   │   │   ├-- ApplicationController.php
│   │   │   ├-- DashboardController.php
│   │   │   └-- ProfileController.php
│   │   ├-- ApplicationController.php
│   │   ├-- ArtCityController.php
│   │   ├-- BlogController.php
│   │   ├-- HomeController.php
│   │   └-- WorkWithUsController.php
│   └-- Requests/
│       ├-- ReviewApplicationRequest.php
│       └-- StoreArtistApplicationRequest.php
├-- Mail/
│   ├-- ApplicationReceived.php
│   └-- ApplicationReviewed.php
└-- Models/
    ├-- AdminProfile.php
    ├-- ArtistApplication.php
    └-- User.php

resources/
├-- css/
│   ├-- main.css       ← Tailwind (public pages)
│   └-- admin.css      ← Bootstrap (admin panel)
├-- js/
│   ├-- navbar.js      ← Mobile/Tablet navigation menu (Hamburger menu)
│   ├-- notifications.js  ← Toastr notification alerts
│   ├-- slider.js      ← Images (Home, Blog)
│   └-- validation.js  ← Artist form frontend validation
└-- views/
    ├-- admin/
    ├-- emails/
    ├-- layouts/
    │   ├-- app.blade.php      ← Public layout
    │   └-- admin.blade.php    ← Admin layout
    ├-- partials/
    │   ├-- navbar.blade.php
    │   └-- footer.blade.php
    ├-- home.blade.php
    ├-- art-city.blade.php
    ├-- blog.blade.php
    └-- work-with-us.blade.php

database/
├-- migrations/
└-- seeders/
    ├-- AdminUserSeeder.php
    └-- DatabaseSeeder.php
```

---

## Live Test Deployment

A temporary test deployment of the application is available for demonstration purposes:

### Public page

🔗 **URL:** https://evolucija-na-sonot.up.railway.app/

### Admin panel

🔗 **URL:** https://evolucija-na-sonot.up.railway.app/admin

### Mail inbox

🔗 **URL:** https://mailpit-evolucija-na-sonot.up.railway.app/

> ⚠️ **Note:**  
> This deployment is intended **for testing and preview only**.  
> Data may be reset at any time, performance may vary, and the environment is not production-hardened.

You can use the default credentials listed to explore the admin panel.

---

---

## Security Notes

- CSRF protection on all forms
- Rate limiting on the artist application route (3 submissions per IP per hour)
- Mass assignment protection via `$fillable` on all models
- PDF-only file uploads enforced on both frontend (JS) and backend (Laravel validation + MIME check)
- Year restriction enforced server-side - admins cannot action past-year applications
- All errors handled with `try-catch` blocks and `Log::error()` logging

---

## License

This project is proprietary. All rights reserved by the Еволуција на Сонот organization.

---

## 👥 Authors

- **Nikolovski Dejan** - [@Dejan.Nikolovski-FS21](https://git.brainster.co/Dejan.Nikolovski-FS21/brainsterchallenges_nikolovskidejan_fs21)
