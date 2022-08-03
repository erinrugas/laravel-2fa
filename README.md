# Laravel 2FA

Minimal starter laravel application with two factor authentication using bootstrap 5.

## Requirements
* [Laravel 9](https://github.com/laravel/framework)
* [PHP 8](https://www.php.net/)

## Installation

#### Create new laravel 9 app or follow instruction in [laravel docs](https://laravel.com/docs/9.x/installation)

```bash
laravel new your-app-name
```

#### Get the package using composer

```bash
composer require erinrugas/laravel-2fa
```
#### For Laravel 8
```bash
composer require erinrugas/laravel-2fa "^1.1.4"
```

#### Install the frontend packages (this will add bootstrap 5 and sass package.json)
##### *NOTE: If you are using laravel 9.19.0 or latest, this command will remove vite and revert back to laravel-mix. To migrate from laravel-mix to vite you may follow laravel instruction [here](https://laravel.com/docs/9.x/vite)*.

```bash
php artisan laravel-2fa:install
```

```bassh
npm install
npm run dev
```



#### Add migration file for two factor authentication and migrate it.

```bash
php artisan laravel-2fa:migration
```

#### Run migrate.

```bash
php artisan migrate
```

#### Add this to your config/app.php

```bash
'providers' => [
...
ErinRugas\Laravel2fa\TwoFactorAuthServiceProvider::class
...
]

```
#### *NOTE: You need to re-run php artisan laravel-2fa:install every time you update the version*

## License

This Laravel 2FA is open source software license under the [MIT license](https://opensource.org/licenses/MIT).
