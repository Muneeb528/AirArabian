# ✈️ AirArabian — Airline Ticketing System

> **PHP Laravel 11 · Bootstrap 5 · MySQL**  
> Dark Navy & Gold Premium Design

---

## 📋 Project Overview

A complete airline ticketing platform with 3 portals:
- **Public Website** — Browse tickets, become a vendor
- **Admin Panel** — Manage tickets, vendors, bookings, payments
- **Vendor Portal** — Book tickets, submit payment proofs

---

## 🚀 Setup Instructions

### Step 1 — Install Prerequisites

Download and install **Laragon** (recommended for Windows):
> https://laragon.org/download/

This includes: PHP 8.2, MySQL, Composer, and Apache automatically.

Alternatively install separately:
- PHP 8.1+: https://windows.php.net/download/
- Composer: https://getcomposer.org/download/
- MySQL: https://dev.mysql.com/downloads/installer/

---

### Step 2 — Install Laravel Dependencies

Open terminal in the project folder and run:

```bash
composer install
```

---

### Step 3 — Configure Environment

```bash
copy .env.example .env
php artisan key:generate
```

Edit `.env` and set your database:

```env
DB_DATABASE=airarbian
DB_USERNAME=root
DB_PASSWORD=
```

---

### Step 4 — Create Database

In MySQL/phpMyAdmin, create a database named `airarbian`.

Or via command line:
```sql
CREATE DATABASE airarbian CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Step 5 — Run Migrations & Seed Data

```bash
php artisan migrate --seed
```

This creates all tables and seeds:
- ✅ Admin account (`admin@airarbian.com` / `Admin@1234`)
- ✅ 10 sample tickets across all 4 categories

---

### Step 6 — Storage Link

```bash
php artisan storage:link
```

---

### Step 7 — Start the Server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## 🔐 Login Credentials

| Portal | URL | Email | Password |
|--------|-----|-------|----------|
| Admin | `/admin/login` | `admin@airarbian.com` | `Admin@1234` |
| Vendor | `/vendor/login` | *(assigned by admin)* | *(assigned by admin)* |

---

## ⚙️ Scheduler Setup (Auto-Release Held Tickets)

To enable the 4-hour auto-release of held tickets, add to Windows Task Scheduler:

**Command:** `php C:\path\to\Travel_Portal\artisan schedule:run`  
**Frequency:** Every minute

Or for development, run manually:
```bash
php artisan tickets:release-held
```

---

## 📁 Project Structure

```
Travel_Portal/
├── app/
│   ├── Console/Commands/ReleaseHeldTickets.php   # Auto-release held tickets
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   ├── VendorPortal/   # Vendor portal controllers
│   │   │   ├── HomeController.php
│   │   │   └── VendorInquiryController.php
│   │   └── Middleware/         # Admin, Vendor, Guest middlewares
│   └── Models/                 # User, Vendor, Ticket, Booking, Payment, HoldTicket
├── database/
│   ├── migrations/             # All 6 table migrations
│   └── seeders/DatabaseSeeder.php
├── public/
│   ├── css/app.css             # Public CSS (dark navy + gold)
│   ├── css/admin.css           # Admin panel CSS
│   └── js/app.js               # JavaScript
├── resources/views/
│   ├── layouts/                # app, admin, vendor layouts
│   ├── home.blade.php          # Landing page
│   ├── vendor-inquiry.blade.php
│   ├── admin/                  # All admin views
│   └── vendor/                 # All vendor portal views
└── routes/
    ├── web.php                 # All routes
    └── console.php             # Scheduled jobs
```

---

## 🗄️ Database Tables

| Table | Description |
|-------|-------------|
| `users` | Admin, Vendor accounts |
| `vendors` | Vendor applications & info |
| `tickets` | Flight tickets (UAE/KSA/Umrah/Tour) |
| `bookings` | Vendor bookings for customers |
| `payments` | Payment proofs (JazzCash/EasyPaisa) |
| `hold_tickets` | 4-hour ticket holds |

---

## 🎯 User Flows

### Normal User
1. Visit homepage → Browse tickets by category
2. Click "Book Now" → WhatsApp redirect to admin

### Vendor
1. Apply via "Become a Vendor" form
2. Admin approves + assigns login credentials
3. Vendor logs in → Books ticket (4-hour hold starts)
4. Uploads JazzCash/EasyPaisa payment screenshot
5. Admin verifies → Booking confirmed

### Admin
1. Login at `/admin/login`
2. Manage tickets (add/edit/delete)
3. Review vendor applications → Assign credentials
4. Verify payment proofs → Approve/Reject
5. Monitor all bookings and revenue

---

## 🎨 Design

- **Colors:** Dark Navy `#0a1628` + Gold `#c9a84c`
- **Font:** Inter (Google Fonts)
- **Framework:** Bootstrap 5.3
- **Icons:** Font Awesome 6.5

---

## 📦 Milestones

- [x] **M1:** Landing page + Admin panel
- [x] **M2:** Vendor system + Ticket management
- [x] **M3:** Booking flow + Payment integration
- [ ] **M4:** Testing + Deployment

---

## 🛠️ Commands Reference

```bash
# Run migrations fresh with seed
php artisan migrate:fresh --seed

# Release expired holds manually
php artisan tickets:release-held

# Run scheduler
php artisan schedule:run

# Clear caches
php artisan optimize:clear
```

---

*Built with ❤️ — AirArabian © 2025*
