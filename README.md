# Homestay Finder

A web-based accommodation discovery platform for Cambodia, built as a Year 2 Computer Science final project at UTE (University of Technology and Entrepreneurship).

---

## Live Demo

**[homestayfinderuniproject-production.up.railway.app](https://homestayfinderuniproject-production.up.railway.app)**

> Admin login: `admin@homestayfinder.com` / `password`

---

##  About

Homestay Finder allows travelers to discover hotels, guesthouses, and resorts across all provinces of Cambodia. Users can search and filter properties, read reviews, and get redirected to booking pages. Admins can manage hotels, users, reviews, and site settings through a dedicated dashboard.

---

##  Features

### Public (No login required)
- Browse and search hotels by name, province, price range, star rating and amenities
- View detailed hotel pages with photos, amenities, location and booking links
- Read guest reviews and ratings
- About Us and Contact pages

### Guest (Login required)
- Register and login
- Leave star ratings and written reviews
- Manage profile (name, email, password)
- View personal review history

### Admin
- Dashboard with stats (total hotels, users, reviews)
- Add, edit, delete hotels with image uploads
- Manage provinces and amenities filters
- User management (ban/unban, delete)
- Review moderation
- Maintenance mode toggle

---

##  Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS, Bootstrap 5, Bootstrap Icons |
| Backend | PHP, Laravel 11 |
| Database | MySQL |
| Auth | Laravel Auth + RBAC (Role-Based Access Control) |
| Version Control | Git + GitHub |
| Hosting | Railway |
| Local Dev | XAMPP, PHP Artisan |

---

##  Team

| Name | Role | Responsibilities |
|---|---|---|
| Roby | Frontend & UI Designer | All HTML/Bootstrap pages, responsive design |
| Panha | Auth & User Profiles | Login/Register, RBAC middleware, user profile |
| HengLeap | Homestay CRUD & Reviews | Reviews, user management, maintenance mode, filters |
| Tola | Search & Public Features | Search filters, hotel details, booking redirect |
| Ratana | Admin Dashboard & Hotels | Admin dashboard, add/edit/delete hotels, image upload |

---

##  Local Setup

### Requirements
- PHP 8.2+
- Composer
- MySQL
- XAMPP (or any local server)

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/AzzelT/HomeStay_Finder_Uni_project.git
cd HomeStay_Finder_Uni_project
```

**2. Install dependencies**
```bash
composer install
```

**3. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure database**

Open `.env` and update:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestay_db
DB_USERNAME=root
DB_PASSWORD=
```

**5. Create database**

Open phpMyAdmin and create a database named `homestay_db`

**6. Run migrations and seed**
```bash
php artisan migrate --seed
```

**7. Link storage**
```bash
php artisan storage:link
```

**8. Start the server**
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000`

### Default Admin Account
```
Email:    admin@homestayfinder.com
Password: password
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/     # All controllers
│   └── Middleware/      # CheckAdmin middleware
├── Models/              # Eloquent models
database/
├── migrations/          # Database table definitions
└── seeders/             # Default data seeder
resources/
└── views/
    ├── layouts/         # Base layout (app.blade.php)
    ├── pages/           # Public pages
    ├── auth/            # Login & register
    ├── profile/         # User profile pages
    └── admin/           # Admin panel views
routes/
└── web.php              # All application routes
public/
└── css/                 # Custom CSS files
```

---

##  License

This project was built for educational purposes as part of a university final project.

© 2026 Homestay Finder — UTE Cambodia
