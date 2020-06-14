## About Ivory-Laravel

Ivory-Laravel is an api backend for Ivory-Vue.

### Install dependencies
```
composer install
```

### Initialize database
Create a database and user with required on MySQL.

Copy `.env.example` to `.env`, and change the database settings.

Run `php artisan migrate` to start database migration.

### Star a develop server
Before running for the first time, run `php artisan key:generate` to generate the application key.
```
php artisan serve
```

### API Endpoint
All API Endpoint start with `/api`

### IDE Helper
`php artisan ide-helper:generate` to generate Laravel Class Definition

`php artisan ide-helper:models` to generate Model Definition

Model definition need to run after Database Migration.

Notice: Don't overwrite model files, write definition to `_ide_helper_models.php`
