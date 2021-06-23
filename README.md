# Laravel 2FA

Minimal starter laravel application with two factor authentication using bootstrap 5.

## Requirements
* [Laravel 8](https://github.com/laravel/framework)
* [PHP >= 7.3](https://www.php.net/)

## Installation

#### Create new laravel app (Laravel 8)

```bash
laravel new your-app-name
```

#### Get the package using composer

```bash
composer require erinrugas/laravel-2fa
```

#### Install the packages (this will also add bootstrap 5 and sass package.json)

```bash
php artisan artisan laravel-2fa:install

npm install

npm run dev
```

#### Add migration file for two factor authentication and migrate it.

```bash
php artisan artisan laravel-2fa:migration
```

#### Run migrate.

```bash
php artisan migrate
```

#### You may add this to your config/app.php

```bash
'providers' => [
...
ErinRugas\Laravel2fa\TwoFactorAuthServiceProvider::class
...
]

```