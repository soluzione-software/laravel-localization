# Laravel Localization
[![Latest Version](http://img.shields.io/packagist/v/soluzione-software/laravel-localization.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/soluzione-software/laravel-localization)
[![MIT License](https://img.shields.io/github/license/soluzione-software/laravel-localization.svg?label=License&color=blue&style=for-the-badge)](https://github.com/soluzione-software/laravel-localization/blob/master/LICENSE.md)

> Note the package is currently in beta. During the beta period things can and probably will change. Don't use it in production until a stable version has been released. We appreciate you helping out with testing and reporting any bugs.

The most native Laravel localization package.

## Installation & Configuration

```bash
composer require soluzione-software/laravel-localization
```
Edit `app/Providers/RouteServiceProvider.php`:
 
 ```php
<?php

namespace App\Providers;

// ...
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use SoluzioneSoftware\Localization\Traits\MapsLocalizedRoutes;

class RouteServiceProvider extends ServiceProvider
{
    use MapsLocalizedRoutes;
    
    // ...

    public function map()
    {
        // ...

        $this->mapLocalizedWebRoutes($this->namespace);
    }
    
    // ...
}
```

For each locale, create `routes/{locale}.web.php` routes file.

Move all routes to localize from `routes/web.php` to `routes/{locale}.web.php`

publish and edit config:
```bash
php artisan vendor:publish --tag=localization-config
```
