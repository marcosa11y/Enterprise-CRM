# Enterprise CRM

A professional Customer Relationship Management system built with CodeIgniter 3.1.13.

## ⚠️ Important Notice

This project uses **CodeIgniter 3.1.13** which reached End of Life (EOL) on December 31, 2020. 
This is for learning/maintenance purposes only. Do not use in production without security audits.

## 📋 Requirements

- PHP 7.4.x (Required - CI3.1.13 is not compatible with PHP 8+)
- MySQL 5.7+ or MariaDB 10.3+
- Apache with mod_rewrite enabled
- Composer (optional, for dependencies)

## 🚀 Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd CRM
```

### 2. Database Setup

1. Create a new MySQL database:
```sql
CREATE DATABASE enterprise_crm;
```

2. Copy the database configuration file:
```bash
cp application/config/database.php.example application/config/database.php
```

3. Edit `application/config/database.php` and update your database credentials:
```php
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'enterprise_crm',
    'dbdriver' => 'mysqli',
    // ... rest of config
);
```

### 3. Run Migrations

Access the migration controller via browser:
```
http://localhost/CRM/index.php/migrate
```

Or run via command line if CLI is configured:
```bash
php index.php migrate
```

### 4. Set Permissions

Ensure proper write permissions for the following directories:
```bash
chmod -R 755 application/cache
chmod -R 755 application/logs
chmod -R 755 application/assets
```

### 5. Configure Base URL

Edit `application/config/config.php` and set your base URL:
```php
$config['base_url'] = 'http://localhost/CRM/';
```

### 6. Access Application

Open your browser and navigate to:
```
http://localhost/CRM/
```

## 📁 Project Structure

```
CRM/
├── application/
│   ├── assets/          # CSS, JS, images
│   ├── cache/           # Cached data
│   ├── config/          # Configuration files
│   ├── controllers/     # Application controllers
│   │   ├── Auth.php         # Authentication
│   │   ├── Dashboard.php    # Main dashboard
│   │   ├── Companies.php    # Company management
│   │   ├── Leads.php        # Lead management
│   │   └── Deals.php        # Deal/pipeline management
│   ├── helpers/         # Custom helper functions
│   ├── libraries/       # Custom libraries
│   ├── migrations/      # Database migrations
│   ├── models/          # Data models
│   └── views/           # View templates
├── system/              # CodeIgniter core files
├── composer.json        # Composer dependencies
├── index.php            # Main entry point
└── test_db.php          # Database test script
```

## 🔑 Features

- **User Authentication** - Secure login/logout system
- **Dashboard** - Overview of key metrics and activities
- **Company Management** - CRUD operations for companies
- **Lead Management** - Track and manage potential customers
- **Deal Pipeline** - Manage sales opportunities and deals
- **Role-based Permissions** - User access control system

## 🛠️ Development

### Running Tests

```bash
phpunit --configuration tests/travis/sqlite.phpunit.xml
```

### Debug Mode

Enable debug mode by editing `application/config/config.php`:
```php
$config['environment'] = 'development';
$config['log_threshold'] = 4;
```

### Test Controllers

Several test controllers are available for development:
- `/index.php/debug` - Debug information
- `/index.php/test_permissions` - Permission testing
- `/index.php/test_phase3`, `test_phase4`, `test_phase5` - Phase testing

## 🔧 Configuration

Key configuration files:
- `application/config/config.php` - Main configuration
- `application/config/database.php` - Database settings
- `application/config/routes.php` - URL routing
- `application/config/autoload.php` - Auto-loading settings

## 📝 API Endpoints

If API functionality is enabled, endpoints follow the pattern:
```
GET    /api/companies     - List companies
POST   /api/companies     - Create company
GET    /api/companies/:id - Get company details
PUT    /api/companies/:id - Update company
DELETE /api/companies/:id - Delete company
```

## 🐛 Troubleshooting

### Common Issues

1. **Blank Page**
   - Check PHP error logs
   - Ensure PHP 7.4.x is being used
   - Verify database connection

2. **Permission Denied**
   - Check folder permissions for cache/, logs/
   - Ensure web server has write access

3. **Migration Errors**
   - Clear cache: `application/cache/*`
   - Check database credentials
   - Verify migrations table exists

## 📄 License

MIT License - See `license.txt` for details

## 👥 Support

- Documentation: CodeIgniter 3 User Guide
- Forum: http://forum.codeigniter.com/
- Issues: Project issue tracker

---

**Note**: This system should be thoroughly audited before any production use due to the outdated framework version.