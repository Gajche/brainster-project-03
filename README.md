# Brainster Project 3

---

## Еволуција на Сонот / Evolution of the Dream

<div align="center">

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
![Font Awesome](https://img.shields.io/badge/Font_Awesome-7.x-33B5E5?style=flat&logo=fontawesome&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=flat&logo=vite&logoColor=white)
![Mailpit](https://img.shields.io/badge/Mailpit-Local_Mail-00B4D8?style=flat&logo=maildotru&logoColor=white)
![PHPDoc](https://img.shields.io/badge/PHPDoc-Documented-777BB4?style=flat&logo=php&logoColor=white)
![Laravel Docs](https://img.shields.io/badge/Laravel-Documentation-FF2D20?style=flat&logo=laravel&logoColor=white)
![JSDoc](https://img.shields.io/badge/JSDoc-Documented-F7DF1E?style=flat&logo=javascript&logoColor=black)

</div>

---

This repository contains a student-developed project,
created as part of the Brainster curriculum under the mentorship of Danica Tundjova.
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
- **Soft Delete & Data Recovery**: Applications can be safely removed from active views without permanent deletion.
- **Database Restoration**: Supports full recovery of records by reverting the `deleted_at` timestamp to `null`.

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
| Documentation | PHPDoc, JSDoc & Laravel Docs          |
| Build tool    | Vite 8                                |
| Mail testing  | Mailpit                               |
| Icons         | Font Awesome 6 (SVG & Webfont)        |
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

## One Click Setup (Recommended)

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

### Both setup scripts automatically:

- Install Composer dependencies (if missing)
- Install NPM dependencies
- Create `.env` from `.env.example`
- Configure database credentials
- Configure Mailpit SMTP
- Generate Laravel application key
- Install Laravel Breeze (if missing)
- Build frontend assets
- Run migrations + fresh seed
- Seed default admin account
- Create storage symlink
- Clear Laravel caches
- Start development services automatically:
    - `php artisan serve`
    - `php artisan queue:work`
    - `npm run dev`
    - `Mailpit`

**After setup finishes, open:**
**http://127.0.0.1:8000**

> ⚡ The setup scripts open additional terminal windows/tabs for development services.
> Keep them running while developing/testing.

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

(OPTIONAL) Create the database:

```bash
# Redundant, create db in step 6 via migrations

mysql -u root -p -e "CREATE DATABASE db_evolucija_na_sonot_nikolovski_dejan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
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
# type yes when prompted, to create db (if db is not created already)
php artisan migrate

# admin seeder
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

<details>
<summary>Click to expand</summary>

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

</details>

### 9. Build front-end assets

For production:

```bash
npm run build
```

### 10. Start development services

Open separate terminals:

```bash
php artisan serve
```

```bash
php artisan queue:work
```

```bash
npm run dev
```

```bash
mailpit
```

> Queue worker processes outgoing emails and background jobs.
> Keep it running during development.

---

### (OPTIONAL) Add Mailpit Local Folder Support

```
project-root/mailpit/mailpit.exe
```

### Optional Local Mailpit Setup

Instead of installing Mailpit globally, you may place it inside:

```
project-root/mailpit/
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

### Local Development URLs

| Service | URL                         |
| ------- | --------------------------- |
| App     | http://127.0.0.1:8000       |
| Admin   | http://127.0.0.1:8000/admin |
| Mailpit | http://localhost:8025       |

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

1. Log in at `/admin or /login`
2. Dashboard shows all approved applications grouped by year
3. Pending applications at `/admin/applications/pending`
4. Click **Прегледај** on any application to open the review page
5. Choose **Одобри** or **Одбиј**, write a message, and submit
6. The artist receives an email automatically
7. Only current-year applications can be actioned - past years are read-only
8. **Safe Deletion**: Applications can be soft-deleted to keep the dashboard clean while preserving the data.
9. **Restoration**: To restore a deleted application, the `deleted_at` column in the database must be reset to `null`.

---

## Project Structure

<details>
<summary>Click to expand project structure</summary>

```
.
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   ├── ApplicationController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── ProfileController.php
│   │   │   ├── ApplicationController.php
│   │   │   ├── ArtCityController.php
│   │   │   ├── BlogController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProfileController.php
│   │   │   └── WorkWithUsController.php
│   │   └── Requests
│   │       ├── Auth
│   │       │   └── LoginRequest.php
│   │       ├── ProfileUpdateRequest.php
│   │       ├── ReviewApplicationRequest.php
│   │       └── StoreArtistApplicationRequest.php
│   ├── Mail
│   │   ├── ApplicationReceived.php
│   │   └── ApplicationReviewed.php
│   ├── Models
│   │   ├── AdminProfile.php
│   │   ├── ArtistApplication.php
│   │   └── User.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_04_01_133523_create_artist_applications_table.php
│   │   └── 2026_04_01_133541_create_admin_profiles_table.php
│   ├── seeders
│   │   ├── AdminUserSeeder.php
│   │   └── DatabaseSeeder.php
├── resources
│   ├── css
│   │   ├── admin.css
│   │   └── main.css
│   ├── js
│   │   ├── app.js
│   │   ├── bootstrap.js
│   │   ├── map-init.js
│   │   ├── navbar.js
│   │   ├── notifications.js
│   │   ├── slider.js
│   │   └── validation.js
│   └── views
│       ├── admin
│       │   ├── applications
│       │   │   ├── all.blade.php
│       │   │   ├── pending.blade.php
│       │   │   └── show.blade.php
│       │   ├── profile
│       │   │   └── edit.blade.php
│       │   └── dashboard.blade.php
│       ├── auth
│       │   ├── confirm-password.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       ├── components
│       │   ├── ui
│       │   │   └── button.blade.php
│       ├── emails
│       │   ├── application-received.blade.php
│       │   └── application-reviewed.blade.php
│       ├── layouts
│       │   ├── partials
│       │   │   └── admin-nav-content.blade.php
│       │   ├── admin.blade.php
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── pages
│       │   ├── art-city.blade.php
│       │   ├── blog.blade.php
│       │   ├── home.blade.php
│       │   └── work-with-us.blade.php
│       ├── partials
│       │   ├── icons
│       │   │   ├── facebook.blade.php
│       │   │   ├── instagram.blade.php
│       │   │   └── youtube.blade.php
│       │   ├── svg
│       │   │   ├── blueblob.blade.php
│       │   │   ├── clouds-blog.blade.php
│       │   │   ├── clouds.blade.php
│       │   │   ├── cloudsleft.blade.php
│       │   │   ├── cloudsleft1.blade.php
│       │   │   ├── dandelion-footer.blade.php
│       │   │   ├── dandelion.blade.php
│       │   │   ├── drop.blade.php
│       │   │   ├── droplet.blade.php
│       │   │   ├── insta-blob-1.blade.php
│       │   │   ├── insta-blob-2.blade.php
│       │   │   ├── ipad-bg.blade.php
│       │   │   ├── leaf-blog.blade.php
│       │   │   ├── leaf.blade.php
│       │   │   └── work-with-us-blob.blade.php
│       │   ├── flash.blade.php
│       │   ├── flash.blade.php.bak
│       │   ├── footer.blade.php
│       │   └── navbar.blade.php
│       ├── profile
│       │   ├── partials
│       │   │   ├── delete-user-form.blade.php
│       │   │   ├── update-password-form.blade.php
│       │   │   └── update-profile-information-form.blade.php
│       │   └── edit.blade.php
├── routes
│   ├── auth.php
│   ├── console.php
│   └── web.php
├── storage
│   ├── app
│   │   ├── private
│   │   │   └── .gitignore
│   │   ├── public
│   │   │   ├── images
│   │   │   │   ├── art-city-1.png
│   │   │   │   ├── art-city-1.svg
│   │   │   │   ├── art-city-1.webp
│   │   │   │   ├── art-city-2.png
│   │   │   │   ├── art-city-2.webp
│   │   │   │   ├── art-city-3.png
│   │   │   │   ├── art-city-3.webp
│   │   │   │   ├── art-city-4.png
│   │   │   │   ├── art-city-4.webp
│   │   │   │   ├── art-city-5.png
│   │   │   │   ├── art-city-5.webp
│   │   │   │   ├── art-city-hero.png
│   │   │   │   ├── art-city-hero.webp
│   │   │   │   ├── art-city-map.svg
│   │   │   │   ├── artist-1.png
│   │   │   │   ├── artist-1.webp
│   │   │   │   ├── artist-2.png
│   │   │   │   ├── artist-2.webp
│   │   │   │   ├── artist-3.png
│   │   │   │   ├── artist-3.webp
│   │   │   │   ├── artist-4.png
│   │   │   │   ├── artist-4.webp
│   │   │   │   ├── artist-5.png
│   │   │   │   ├── artist-5.webp
│   │   │   │   ├── bg-mobile-home-white.svg
│   │   │   │   ├── blueblob.svg
│   │   │   │   ├── clouds-blog.svg
│   │   │   │   ├── clouds-left.svg
│   │   │   │   ├── clouds-left1.svg
│   │   │   │   ├── clouds.svg
│   │   │   │   ├── droplet.svg
│   │   │   │   ├── edition-1.png
│   │   │   │   ├── edition-1.webp
│   │   │   │   ├── edition-2.png
│   │   │   │   ├── edition-2.webp
│   │   │   │   ├── edition-3.png
│   │   │   │   ├── edition-3.webp
│   │   │   │   ├── event-1.svg
│   │   │   │   ├── event-2.svg
│   │   │   │   ├── event-3.svg
│   │   │   │   ├── footer-logo.svg
│   │   │   │   ├── galery-1.jpg
│   │   │   │   ├── hero-face.png
│   │   │   │   ├── hero-face.webp
│   │   │   │   ├── insta-1.svg
│   │   │   │   ├── insta-2.svg
│   │   │   │   ├── insta-3.svg
│   │   │   │   ├── insta-4.svg
│   │   │   │   ├── insta-blob-1.svg
│   │   │   │   ├── insta-blob-2.svg
│   │   │   │   ├── ipad-bg.svg
│   │   │   │   ├── latest-news-1.svg
│   │   │   │   ├── latest-news-2.svg
│   │   │   │   ├── latest-news-3.svg
│   │   │   │   ├── leaf-blog.svg
│   │   │   │   ├── leaf.svg
│   │   │   │   ├── nav-logo.svg
│   │   │   │   ├── program-sub.svg
│   │   │   │   ├── video-bg.svg
│   │   │   │   └── work-with-us-blob.svg
│   │   │   ├── uploads
│   │   │   │   └── .gitkeep
│   │   │   ├── video
│   │   │   │   ├── video-insta.mp4
│   │   │   │   └── video.mp4
│   │   │   └── .gitignore
│   │   └── .gitignore
```

</details>

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

## Security Notes

- CSRF protection on all forms
- Rate limiting on the artist application route (3 submissions per IP per hour)
- Mass assignment protection via `$fillable` on all models
- PDF, DOCX, DOC file uploads enforced on both frontend (JS) and backend (Laravel validation + MIME check)
- Year restriction enforced server-side - admins cannot action past-year applications
- All errors handled with `try-catch` blocks and `Log::error()` logging
- **Soft Deletes**: Implemented to prevent accidental data loss; records are kept in the database but hidden from the UI.
- **Data Recovery**: Built-in support for reverting deletions via database-level restoration (`deleted_at = null`).

---

## Screenshots

<details>
<summary>Click to expand screenshots (images showcasing the application)</summary>

<table width="100%">

  <tr>
    <td align="center" valign="top">
      <img src="screenshot/home/home-desktop.png" alt="home-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>home-desktop-view</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/art-city/art-city-desktop.png" alt="art-city-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>art-city-desktop</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/blog/blog-desktop.png" alt="blog-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>blog-desktop</em>
    </td>
		<td align="center" valign="top">
      <img src="screenshot/work-with-us/work-with-us-desktop.png" alt="work-with-us-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>work-with-us-desktop</em>
    </td>
  </tr>

  <tr>
    <td align="center" valign="top">
      <img src="screenshot/home/home-tablet.png" alt="home-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>home-tablet</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/art-city/art-city-tablet.png" alt="art-city-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>art-city-tablet</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/blog/blog-tablet.png" alt="blog-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>blog-tablet</em>
    </td>
		<td align="center" valign="top">
      <img src="screenshot/work-with-us/work-with-us-tablet.png" alt="work-with-us-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>work-with-us-tablet</em>
    </td>
  </tr>

  <tr>
    <td align="center" valign="top">
      <img src="screenshot/home/home-mobile.png" alt="home-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>home-mobile</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/art-city/art-city-mobile-425.png" alt="art-city-mobil" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>art-city-mobile</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/blog/blog-mobile-425.png" alt="blog-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>blog-mobile</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/work-with-us/work-with-us-mobile.png" alt="work-with-us-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>work-with-us-mobile</em>
    </td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-dashboard-desktop.png" alt="admin-dashboard-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-dashboard-desktop</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-pending-desktop.png" alt="admin-pending-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-pending-desktop</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-all-applications-desktop.png" alt="admin-all-applications-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-all-applications-desktop</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-pending-details-desktop.png" alt="admin-pending-details-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-pending-details-desktop</em>
    </td>
		 <td align="center" valign="top">
      <img src="screenshot/admin/admin-profile-desktop.png" alt="admin-profile-desktop" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-profile-desktop</em>
    </td>
  </tr>
	
  <tr>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-dashboard-tablet.png" alt="admin-dashboard-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-dashboard-tablet</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-pending-tablet.png" alt="admin-pending-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-pending-tablet</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-all-applications-tablet.png" alt="admin-all-applications-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-all-applications-tablet</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-pending-details-tablet.png" alt="admin-pending-details-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-pending-details-tablet</em>
    </td>
		 <td align="center" valign="top">
      <img src="screenshot/admin/admin-profile-tablet.png" alt="admin-profile-tablet" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-profile-tablet</em>
    </td>
  </tr>

  <tr>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-dashboard-mobile.png" alt="admin-dashboard-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-dashboard-mobile</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-pending-mobile.png" alt="admin-pending-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-pending-mobile</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-all-applications-mobile.png" alt="admin-all-applications-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-all-applications-mobile</em>
    </td>
    <td align="center" valign="top">
      <img src="screenshot/admin/admin-pending-details-mobile.png" alt="admin-pending-details-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-pending-details-mobile</em>
    </td>
    	 <td align="center" valign="top">
      <img src="screenshot/admin/admin-profile-mobile.png" alt="admin-profile-mobile" style="width: 100%; max-width: 400px; height: auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />
      <br><em>admin-profile-mobile</em>
    </td>
  </tr>

</table>

</details>

---

## License

This project is proprietary. All rights reserved by the Еволуција на Сонот organization.

---

## 👥 Authors

- **Nikolovski Dejan** - [@Dejan.Nikolovski-FS21](https://git.brainster.co/Dejan.Nikolovski-FS21/brainsterchallenges_nikolovskidejan_fs21)
