# BJ Computers E-Commerce Platform

A modern, dark-themed e-commerce platform built with Laravel for managing computer products, inventory, and transactions.

## Technology Stack

**Framework:** Laravel 11  
**Frontend:** Blade Templates, Tailwind CSS, Vue.js  
**Database:** MySQL  
**Build Tool:** Vite  
**Package Manager:** Composer (PHP), npm (Node.js)  
**Development Environment:** XAMPP, VS Code  
**Version Control:** Git, GitHub  

## Features

- **Product Management:** Create, read, update, and delete products with categories and brands
- **Inventory Tracking:** Real-time stock management with low/medium/out-of-stock indicators
- **Transaction History:** Complete transaction logging with stock snapshots
- **User Management:** Admin panel for managing users with different roles (admin, staff, customer)
- **Dark Theme UI:** Modern, minimalist dark interface with red accent colors
- **Responsive Design:** Mobile-friendly grid and list view options
- **Category & Brand Filtering:** Server-side filtering for products

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** (included with XAMPP)
- **MySQL 8.0+** (included with XAMPP)
- **Node.js 18+** and npm
- **Composer** (PHP dependency manager)
- **XAMPP** (Apache + MySQL + PHP)
- **Git**

## Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/1clxrnce/it9projectfinalversion.git
cd it9projectfinalversion
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and generate an app key:

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=it9project
DB_USERNAME=root
DB_PASSWORD=
```

**Note:** If using XAMPP, the default MySQL user is `root` with no password.

### 6. Start XAMPP

1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Verify MySQL is running on port 3306

### 7. Run Migrations

```bash
php artisan migrate
```

This creates all necessary database tables.

### 8. Create Storage Symlink

```bash
php artisan storage:link
```

This allows images stored in `storage/app/public/` to be accessible via the web.

### 9. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

## Running the Application

### Development Server

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

### Default Admin Credentials

After migration, you can create an admin user or check the database for existing credentials.

## Project Structure

```
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/               # Eloquent models
│   └── Providers/            # Service providers
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── views/                # Blade templates
│   │   ├── admin/            # Admin panel views
│   │   ├── products/         # Product views
│   │   ├── transactions/     # Transaction views
│   │   └── layouts/          # Layout templates
│   └── css/                  # Tailwind CSS
├── routes/
│   └── web.php               # Web routes
├── storage/
│   └── app/public/           # User-uploaded files (images)
└── public/
    └── build/                # Compiled assets
```

## Key Routes

- `/` - Homepage with product categories
- `/products` - Product listing with filtering
- `/products/{id}` - Product details
- `/dashboard` - Admin dashboard with inventory overview
- `/admin/products` - Admin product management
- `/admin/users` - Admin user management
- `/transactions` - Transaction history
- `/transactions/{id}` - Transaction details

## Database Tables

- `users` - User accounts with roles
- `products` - Product catalog
- `categories` - Product categories
- `brands` - Product brands
- `stock_transactions` - Inventory transaction history
- `transactions` - Order/transaction records

## Development Commands

```bash
# Build assets for production
npm run build

# Watch for asset changes (development)
npm run dev

# Run database migrations
php artisan migrate

# Create a new migration
php artisan make:migration migration_name

# Seed the database
php artisan db:seed

# Clear application cache
php artisan cache:clear

# List all routes
php artisan route:list
```

## Deployment

For production deployment:

1. Set environment variables in `.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Cache configuration and routes:
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

3. Build frontend assets:
   ```bash
   npm run build
   ```

4. Ensure MySQL database is accessible from your hosting provider

5. Run migrations on the production server:
   ```bash
   php artisan migrate --force
   ```

## Troubleshooting

**Issue:** "XAMPP MySQL not starting"
- Check if port 3306 is already in use
- Restart XAMPP services

**Issue:** "Vendor folder missing after cloning"
- Run `composer install` to restore PHP dependencies

**Issue:** "Images not displaying"
- Place images in the `public/` folder:
  - `public/logo/logo.png` - BJ Computers logo
  - `public/dekstop/` - Carousel/banner images
  - `public/products/` - Product images
  - `public/brands/` - Brand logos
  - `public/categories/` - Category images
- Images are served directly from the public folder, not from storage

**Issue:** "npm run dev not working"
- Run `npm install` to ensure all dependencies are installed
- Check Node.js version: `node --version`

## License

This project is open-source software licensed under the MIT license.
