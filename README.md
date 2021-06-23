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

#### Add Has2FA in your User model

```bash
use Has2FA;
```

#### Advisable to hide two_factor_secret_key and two_factor_recovery_code column and add it to your fillable

```bash
protected $hidden = [
    ...
    'two_factor_secret_key',
    'two_factor_recovery_code'
    ...
];

protected $fillable = [
    ...
    'two_factor_secret_key',
    'two_factor_recovery_code',
    ...
];

```

#### You may add this to your config/app.php

```bash
'providers' => [
...
ErinRugas\Laravel2fa\TwoFactorAuthServiceProvider::class
...
]

```