# BJ Computers E-Commerce Platform

A modern e-commerce platform built with Laravel for BJ Computers, featuring inventory management, product catalog, and transaction tracking.

## Features

- **Product Management**: Browse and manage computer products with categories and brands
- **Inventory Tracking**: Real-time stock level monitoring with low/medium/out-of-stock indicators
- **Transaction Management**: Track all inventory transactions with detailed snapshots
- **User Management**: Admin panel for managing users with different roles (customer, staff, admin)
- **Dark Theme UI**: Modern dark-themed interface with responsive design
- **Grid/List View**: Toggle between grid and list views for products
- **Category & Brand Filtering**: Filter products by category and brand

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: MySQL
- **Build Tool**: Vite
- **Server**: Apache with PHP 8.4

## Installation

### Prerequisites
- PHP 8.4+
- MySQL 8.0+
- Node.js 20+
- Composer

### Setup

1. Clone the repository
```bash
git clone https://github.com/1clxrnce/it9projectfinalversion.git
cd it9projectfinalversion
```

2. Install PHP dependencies
```bash
composer install
```

3. Install Node dependencies
```bash
npm install
```

4. Create environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure database in `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bj_computers
DB_USERNAME=root
DB_PASSWORD=
```

7. Run migrations
```bash
php artisan migrate
```

8. Create storage symlink
```bash
php artisan storage:link
```

9. Build frontend assets
```bash
npm run build
```

10. Start development server
```bash
php artisan serve
```

## Development

### Build Assets
```bash
npm run dev      # Development with hot reload
npm run build    # Production build
```

### Database
```bash
php artisan migrate           # Run migrations
php artisan migrate:rollback  # Rollback migrations
php artisan tinker           # Interactive shell
```

## Deployment

### Production Setup

1. Set environment variables in `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

2. Cache configuration:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Build assets:
```bash
npm run build
```

4. Run migrations:
```bash
php artisan migrate --force
```

### Docker Deployment

Build and run with Docker:
```bash
docker build -t bj-computers .
docker run -p 10000:10000 bj-computers
```

The application will be available at `http://localhost:10000`

## Project Structure

```
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates
│   └── css/                 # Tailwind CSS
├── routes/
│   └── web.php              # Web routes
└── public/
    └── storage/             # Uploaded files
```

## License

This project is proprietary software for BJ Computers.
