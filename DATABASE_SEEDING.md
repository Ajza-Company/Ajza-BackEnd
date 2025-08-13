# Database Seeding Documentation

## Overview
This document explains how to clear and populate the Ajza application database with sample data for development and testing purposes.

## Quick Start

### Clear and Seed Database (Recommended)
```bash
php artisan db:seed --class=FreshDatabaseSeeder
```

### Alternative Methods

#### Method 1: Fresh Migration + Seed
```bash
php artisan migrate:fresh --seed
```

#### Method 2: Clear and Seed Manually
```bash
# Clear all data
php artisan migrate:fresh

# Seed with specific seeder
php artisan db:seed --class=DatabaseSeeder
```

## Available Seeders

### 1. FreshDatabaseSeeder (Recommended)
- **Purpose**: Completely clears the database and populates it with fresh sample data
- **Command**: `php artisan db:seed --class=FreshDatabaseSeeder`
- **What it does**:
  - Truncates all tables (except migrations)
  - Runs all essential seeders in correct order
  - Provides clear feedback during the process

### 2. DatabaseSeeder (Main Seeder)
- **Purpose**: Seeds the database with basic data
- **Command**: `php artisan db:seed`
- **What it includes**:
  - Permissions and Roles
  - Locales (English, Arabic)
  - Admin User
  - Suppliers
  - Car Brands
  - Categories
  - Countries/States/Cities

### 3. Individual Seeders

#### PermissionSeeder
- Creates system permissions
- Data source: `database/data/permissions.json`

#### RoleSeeder
- Creates user roles (Admin, Supplier, etc.)
- Data source: `database/data/roles.json`

#### LocaleSeeder
- Creates language locales (English, Arabic)
- Data source: `database/data/locales.json`

#### UserSeeder
- Creates admin user account
- **Admin Credentials**:
  - Email: `store@ajza.net`
  - Password: `1Alqarawi1`
  - Role: Admin with all permissions

#### SupplierSeeder
- Creates sample supplier accounts
- **Supplier Credentials**:
  - Email: `supplier1@ajza.net` / Password: `password123`
  - Email: `supplier2@ajza.net` / Password: `password123`
  - Email: `supplier3@ajza.net` / Password: `password123`
  - Role: Supplier with supplier permissions

#### CarBrandSeeder
- Creates car brand data
- Uses factory to generate sample brands

#### CategorySeeder
- Creates product categories and subcategories
- Includes car parts categories with Arabic translations

#### CountrySeeder
- Creates countries, states, and cities data
- Focuses on Saudi Arabia data
- Data sources:
  - `database/data/countries/countries.json`
  - `database/data/countries/states.json`
  - `database/data/countries/cities.json`

## Sample Data Summary

### Users
| Type | Email | Password | Role |
|------|-------|----------|------|
| Admin | store@ajza.net | 1Alqarawi1 | Admin |
| Supplier 1 | supplier1@ajza.net | password123 | Supplier |
| Supplier 2 | supplier2@ajza.net | password123 | Supplier |
| Supplier 3 | supplier3@ajza.net | password123 | Supplier |

### Categories
- **Car Parts** (قطع غيار السيارات)
  - Oil Filters (فلاتر زيت)
  - Oils (زيوت)
  - A/C & Heating (تكييف وتدفئة)
  - Brakes (فرامل)
  - Electrical (كهرباء)

### Locations
- **Countries**: Saudi Arabia
- **States**: All Saudi states
- **Cities**: Major Saudi cities

### Car Brands
- Toyota, Honda, Ford, BMW, Mercedes, etc.

## Data Files

### JSON Data Files
Located in `database/data/`:

- `permissions.json` - System permissions
- `roles.json` - User roles
- `locales.json` - Language locales
- `countries/countries.json` - Countries data
- `countries/states.json` - States data
- `countries/cities.json` - Cities data

### Factory Files
Located in `database/factories/`:
- UserFactory.php
- StoreFactory.php
- ProductFactory.php
- CompanyFactory.php
- And more...

## Development Workflow

### 1. Initial Setup
```bash
# Fresh installation
php artisan migrate:fresh --seed
```

### 2. During Development
```bash
# Clear and reseed when needed
php artisan db:seed --class=FreshDatabaseSeeder
```

### 3. Testing
```bash
# For testing environment
php artisan migrate:fresh --seed --env=testing
```

## Troubleshooting

### Common Issues

#### 1. Foreign Key Constraints
If you get foreign key errors:
```bash
# The FreshDatabaseSeeder handles this automatically
# But if needed manually:
DB::statement('SET FOREIGN_KEY_CHECKS=0');
# ... your operations
DB::statement('SET FOREIGN_KEY_CHECKS=1');
```

#### 2. Memory Issues
For large datasets, increase PHP memory:
```bash
php -d memory_limit=512M artisan db:seed --class=FreshDatabaseSeeder
```

#### 3. Timeout Issues
Increase execution time:
```php
// In seeder file
ini_set('max_execution_time', '3600'); // 1 hour
```

### Reset Database
```bash
# Complete reset
php artisan migrate:fresh --seed

# Or use the fresh seeder
php artisan db:seed --class=FreshDatabaseSeeder
```

## Best Practices

1. **Always use FreshDatabaseSeeder** for development
2. **Backup production data** before seeding
3. **Test seeders** in development environment first
4. **Keep sample data realistic** and relevant
5. **Document any changes** to seeders or data files

## Customization

### Adding New Seeders
1. Create new seeder: `php artisan make:seeder NewSeeder`
2. Add to `FreshDatabaseSeeder` in correct order
3. Update this documentation

### Modifying Sample Data
1. Edit JSON files in `database/data/`
2. Update factory files if needed
3. Re-run seeder to apply changes

## Support

For issues with database seeding:
1. Check the seeder logs
2. Verify JSON data files are valid
3. Ensure database connection is working
4. Check foreign key relationships
