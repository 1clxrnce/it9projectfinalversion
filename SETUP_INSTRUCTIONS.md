# Computer Parts Inventory System - Setup Instructions

## Role-Based Access Control

This Laravel application implements a 3-tier role-based access system:

### Roles:

1. **Customer** - Can only browse products and view quantities
2. **Staff** - Can browse products + add stock transactions (in/out/adjustment)
3. **Admin** - Full access: manage users, products, categories, brands, and transactions

## Database Structure

Based on your ERD:
- Users (with role field)
- Categories
- Brands
- Products (linked to categories and brands)
- Inventory (tracks quantity per product)
- StockTransactions (tracks all inventory movements)

## Setup Steps

1. **Run migrations:**
```bash
php artisan migrate
```

2. **Seed the database with sample data:**
```bash
php artisan db:seed
```

This creates:
- 3 test users (one for each role)
- Sample categories (CPU, GPU, RAM, etc.)
- Sample brands (Intel, AMD, NVIDIA, etc.)
- Sample products with inventory

## Test Credentials

After seeding, you can login with:

- **Admin:** admin@example.com / password
- **Staff:** staff@example.com / password
- **Customer:** customer@example.com / password

## Routes Structure

### Customer Routes (all authenticated users):
- `GET /products` - Browse all products
- `GET /products/{id}` - View product details

### Staff Routes (staff + admin):
- `GET /transactions` - View all transactions
- `GET /transactions/create` - Create new transaction
- `POST /transactions` - Store transaction

### Admin Routes (admin only):
- `/admin/users` - User management (CRUD)
- `/admin/categories` - Category management (CRUD)
- `/admin/brands` - Brand management (CRUD)
- `/admin/products` - Product management (CRUD)

## Key Features

1. **Role Middleware** - Protects routes based on user role
2. **Inventory Management** - Automatic inventory updates on transactions
3. **Transaction Types:**
   - `in` - Add stock
   - `out` - Remove stock (validates sufficient quantity)
   - `adjustment` - Set exact quantity

## Next Steps

You'll need to create views for:
- Authentication (login/register)
- Product browsing
- Transaction management
- Admin panels

Or install Laravel Breeze/Jetstream for authentication scaffolding:
```bash
composer require laravel/breeze --dev
php artisan breeze:install
```
