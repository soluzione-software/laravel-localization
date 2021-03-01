<?php

namespace SoluzioneSoftware\Localization\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

trait MapsLocalizedRoutes
{
    protected function mapLocalizedWebRoutes(?string $namespace)
    {
        $middleware = array_merge(Arr::wrap(Config::get('localization.middleware')), ['web', 'localize']);

        foreach (Config::get('localization.locales') as $locale) {
            Route::middleware($middleware)
                ->prefix($locale)
                ->name("$locale.")
                ->namespace($namespace)
                ->group(App::basePath("routes/$locale.web.php"));
        }
    }
}
