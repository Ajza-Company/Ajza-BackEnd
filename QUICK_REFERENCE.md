# Quick Reference Card - Ajza App

## 🚀 Quick Commands

### Start Development Server
```bash
php artisan serve
```
**URL**: http://localhost:8000

### Clear & Seed Database
```bash
php artisan db:seed --class=FreshDatabaseSeeder
```

### Fresh Migration + Seed
```bash
php artisan migrate:fresh --seed
```

## 👤 Login Credentials

### Admin Account
- **Email**: `store@ajza.net`
- **Password**: `1Alqarawi1`
- **Role**: Admin (Full Access)

### Supplier Accounts
- **Email**: `supplier1@ajza.net` / **Password**: `password123`
- **Email**: `supplier2@ajza.net` / **Password**: `password123`
- **Email**: `supplier3@ajza.net` / **Password**: `password123`
- **Role**: Supplier

## 📊 Sample Data Included

### Users & Roles
- ✅ Admin user with all permissions
- ✅ 3 Supplier accounts with supplier permissions
- ✅ Roles: Admin, Supplier, User
- ✅ Permissions system configured

### Categories
- ✅ Car Parts (قطع غيار السيارات)
  - Oil Filters (فلاتر زيت)
  - Oils (زيوت)
  - A/C & Heating (تكييف وتدفئة)
  - Brakes (فرامل)
  - Electrical (كهرباء)

### Locations
- ✅ Saudi Arabia (Countries, States, Cities)
- ✅ Complete geographical data

### Car Data
- ✅ Car Brands (Toyota, Honda, Ford, BMW, etc.)
- ✅ Car Models
- ✅ Car Types

### System
- ✅ Locales: English (en), Arabic (ar)
- ✅ Permissions and Roles
- ✅ Basic settings

## 🔧 Development Tools

### Database
- **Host**: 127.0.0.1
- **Database**: ajza_app
- **Username**: root
- **Password**: (empty)

### Frontend (if needed)
```bash
# Install dependencies
cmd /c "C:\laragon\bin\nodejs\node-v22\npm.cmd install"

# Start Vite dev server
cmd /c "C:\laragon\bin\nodejs\node-v22\npm.cmd run dev"
```

## 📁 Key Files

### Database
- `database/seeders/FreshDatabaseSeeder.php` - Main seeder
- `database/data/` - JSON data files
- `DATABASE_SEEDING.md` - Full documentation

### Configuration
- `.env` - Environment variables
- `config/` - Application configuration

## 🚨 Troubleshooting

### Common Issues
1. **ZIP Extension**: Already fixed in backup config
2. **Database Connection**: Check `.env` file
3. **Node.js**: Use Laragon path: `C:\laragon\bin\nodejs\node-v22\`

### Reset Everything
```bash
php artisan migrate:fresh --seed
```

## 📞 Support
- Check `DATABASE_SEEDING.md` for detailed documentation
- Laravel logs: `storage/logs/laravel.log`
- Database logs: Check MySQL error logs

---
**Last Updated**: August 8, 2025
**Version**: Ajza App v1.0
