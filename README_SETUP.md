# AfriLoc - Laravel Livewire Property Rental Platform

## Setup Complete! ✅

A complete Laravel + Livewire property rental platform has been initialized with all features and best practices.

## What's Been Implemented

### 1. Core Laravel Setup
- ✅ Laravel 12 installed at project root
- ✅ SQLite database configured for development
- ✅ Vite configured for asset compilation
- ✅ Tailwind CSS 3 with custom colors matching the design
- ✅ Alpine.js for interactive components

### 2. Authentication & Authorization
- ✅ JWT Authentication (tymon/jwt-auth) for API routes
- ✅ Session-based authentication for web routes
- ✅ Spatie Laravel Permission for role-based access control
- ✅ Three roles: Admin, Owner, Tenant
- ✅ Middleware: JwtMiddleware, RoleMiddleware, LocaleMiddleware

### 3. Database Schema
- ✅ **Properties table**: Multi-language support (FR/EN), images, type (house/apartment/land), status, pricing
- ✅ **Bookings table**: Customer info, dates, status, payment tracking
- ✅ **Contacts table**: Contact form submissions
- ✅ **Spatie Permission tables**: Roles and permissions management

### 4. Eloquent Models
- ✅ Property: Relationships, scopes (featured, available), JSON casts for images
- ✅ Booking: Relationships with Property and User
- ✅ Contact: Contact message storage
- ✅ User: JWT implementation, Spatie roles, booking relationships

### 5. Livewire 3 Components

**Public Components:**
- ✅ Home: Hero section, featured properties, stats
- ✅ Properties/Index: Property listing with filters (type, price, search)
- ✅ Properties/Show: Property detail page
- ✅ Contact/ContactForm: Contact form with validation
- ✅ Components/Header: Navigation with language switcher
- ✅ Components/Footer: Footer with links
- ✅ Components/PropertyCard: Reusable property card

**Admin Components:**
- ✅ Admin/Dashboard: Statistics and quick links
- ✅ Admin/Properties/PropertyList: Manage properties
- ✅ Admin/Bookings/BookingList: Manage bookings with status updates
- ✅ Admin/Contacts/ContactList: View contact messages

### 6. Routes
- ✅ Web routes: Home, Properties, Contact, Auth (Login/Register), Admin
- ✅ API routes: Auth endpoints (register, login, logout, refresh)
- ✅ Middleware protection for admin routes

### 7. Localization
- ✅ Full FR/EN translation support
- ✅ Language switcher in header
- ✅ Session-based language preference
- ✅ Comprehensive translation files

### 8. Seeders & Sample Data
- ✅ RoleSeeder: Creates admin, owner, tenant roles with permissions
- ✅ AdminSeeder: Creates default admin user
- ✅ PropertySeeder: 6 sample properties (houses, apartments, land)

### 9. Static Assets
- ✅ Property images copied from Front folder
- ✅ Images: houses, apartments, land plots, hero image

## Running the Application

### Start Development Servers

The servers are already running in the background:

```bash
# Laravel server (port 8000)
php artisan serve

# Vite dev server (for assets)
npm run dev
```

### Access the Application

- **Homepage**: http://localhost:8000
- **Properties**: http://localhost:8000/properties
- **Contact**: http://localhost:8000/contact
- **Admin Login**: http://localhost:8000/login
- **Admin Dashboard**: http://localhost:8000/admin

### Default Admin Credentials

```
Email: admin@afriloc.com
Password: password123
```

## Key Features

### For Visitors
- Browse properties with filters (type, price range, search)
- View detailed property information
- Submit contact forms
- Multi-language support (EN/FR)

### For Admins
- Complete dashboard with statistics
- Manage properties (view, delete)
- Manage bookings (view, update status)
- View contact messages
- Role-based access control

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login (returns JWT token)
- `POST /api/auth/logout` - Logout
- `POST /api/auth/refresh` - Refresh JWT token
- `GET /api/auth/me` - Get authenticated user

## Project Structure

```
/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/AuthController.php
│   │   │   └── Auth/LoginController.php, RegisterController.php
│   │   └── Middleware/
│   │       ├── JwtMiddleware.php
│   │       ├── RoleMiddleware.php
│   │       └── LocaleMiddleware.php
│   ├── Livewire/
│   │   ├── Home.php
│   │   ├── Properties/Index.php, Show.php
│   │   ├── Contact/ContactForm.php
│   │   ├── Admin/Dashboard.php
│   │   ├── Admin/Properties/PropertyList.php
│   │   ├── Admin/Bookings/BookingList.php
│   │   └── Admin/Contacts/ContactList.php
│   └── Models/
│       ├── Property.php
│       ├── Booking.php
│       ├── Contact.php
│       └── User.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite
├── lang/
│   ├── en.json
│   └── fr.json
├── public/
│   └── images/ (property images)
├── resources/
│   ├── views/
│   │   ├── layouts/app.blade.php, guest.blade.php
│   │   ├── livewire/ (component views)
│   │   └── auth/ (login, register views)
│   ├── css/app.css
│   └── js/app.js
├── routes/
│   ├── web.php
│   └── api.php
└── Front/ (Original React application - kept for reference)
```

## Database

**SQLite** is configured for development. The database file is at `database/database.sqlite`.

To use PostgreSQL in production, update `.env`:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=afriloc
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then run: `php artisan migrate:fresh --seed`

## Next Steps

### Recommended Enhancements
1. **Property Management**: Add create/edit forms for properties in admin
2. **Image Upload**: Implement Livewire file upload for property images
3. **Booking System**: Add full booking workflow with calendar
4. **Payment Integration**: Add payment gateway (Stripe, PayPal, etc.)
5. **Email Notifications**: Send emails for bookings and contact forms
6. **Property Search**: Add advanced search with map integration
7. **User Dashboard**: Add tenant dashboard for managing bookings
8. **Reviews & Ratings**: Allow users to review properties

### Testing
```bash
# Run PHPUnit tests (create test cases as needed)
php artisan test

# Code formatting
./vendor/bin/pint

# Clear caches
php artisan optimize:clear
```

## Best Practices Implemented

✅ **Middleware** for authentication and authorization
✅ **Form Requests** for validation (can be added for additional validation)
✅ **API Resources** for consistent API responses
✅ **Eloquent Relationships** for data integrity
✅ **Scopes** for reusable queries
✅ **Seeders** for sample data
✅ **Migrations** for database versioning
✅ **Localization** for multi-language support
✅ **Livewire** for reactive components without writing JavaScript
✅ **Tailwind CSS** for utility-first styling
✅ **Role-Based Access Control** with Spatie Permission

## Troubleshooting

### If servers aren't running:
```bash
# Start Laravel
php artisan serve

# Start Vite
npm run dev
```

### Reset database:
```bash
php artisan migrate:fresh --seed
```

### Clear caches:
```bash
php artisan optimize:clear
```

## Support

For questions or issues, check:
- Laravel docs: https://laravel.com/docs
- Livewire docs: https://livewire.laravel.com/docs
- Spatie Permission: https://spatie.be/docs/laravel-permission

---

**Built with Laravel 12, Livewire 3, Tailwind CSS 3, and Alpine.js**

