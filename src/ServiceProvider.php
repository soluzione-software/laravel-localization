<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SoluzioneSoftware\Localization\Facades\Redirect;
use SoluzioneSoftware\Localization\Http\Middleware\Localize;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootConfig();

        Facades\Route::aliasMiddleware('localize', Localize::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerLocalizationManager();

        Route::get('/', function () {
            return Redirect::toLocalized(App::getLocale(), '/');
        });
    }

    private function bootConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/localization.php' => App::configPath('localization.php'),
        ], ['config', 'localization', 'localization-config']);

        $this->mergeConfigFrom(__DIR__ . '/../config/localization.php', 'localization');
    }

    protected function registerLocalizationManager()
    {
        $this->app->singleton('localization.manager', function () {
            return new LocalizationManager();
        });
    }
}
