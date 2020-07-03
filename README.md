## About Ivory-Laravel

Ivory-Laravel is an api backend for Ivory-Vue.

### Front end
https://github.com/ZYKJShadow/ivory-admin

https://github.com/samnyan/ivory-vue

### Install dependencies
```
composer install
```

### Initialize database
Create a database and user with required on MySQL.

Copy `.env.example` to `.env`, and change the database settings.

Run `php artisan migrate` to start database migration.

### Star a develop server
Before running for the first time, run `php artisan key:generate` and `php artisan jwt:secret` to generate the application key.
```
php artisan serve
```

### API Document
All API Endpoint start with `/api`

Read generated document [here](public/docs/index.html)

`php artisan apidoc:generate` for updating the api document.

### IDE Helper
`php artisan ide-helper:generate` to generate Laravel Class Definition

`php artisan ide-helper:models` to generate Model Definition

Model definition need to run after Database Migration.

Notice: Don't overwrite model files, write definition to `_ide_helper_models.php`
