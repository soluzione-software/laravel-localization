<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SoluzioneSoftware\Localization\Facades\Route;

class RoutingServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootRouter();
    }

    public function register()
    {
        $this->registerUrlGenerator();
        $this->registerRedirector();
    }

    private function bootRouter()
    {
        Router::macro('currentLocalizedRouteName', function (string $locale) {
            return str_replace(App::getLocale() . '.', "$locale.", Route::currentRouteName());
        });
    }

    /**
     * @see \Illuminate\Routing\RoutingServiceProvider::registerUrlGenerator
     */
    private function registerUrlGenerator()
    {
        $this->app->extend('url', function (UrlGeneratorContract $generator) {
            return new UrlGenerator($generator);
        });
    }

    /**
     * Register the Redirector decorator.
     *
     * @return void
     */
    protected function registerRedirector()
    {
        $this->app->singleton('redirect', function ($app) {
            $redirector = new Redirector($app['url']);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });
    }
}
