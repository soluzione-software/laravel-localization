<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Routing\Redirector as IlluminateRedirector;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SoluzioneSoftware\Localization\Facades\Route;
use SoluzioneSoftware\Localization\Facades\URL;

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
            /** @var \Illuminate\Routing\UrlGenerator $urlGenerator */
            $urlGenerator = URL::getUrlGenerator();
            $redirector = new IlluminateRedirector($urlGenerator);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });

        $this->app->extend('redirect', function (IlluminateRedirector $redirector) {
            return new Redirector($redirector);
        });
    }
}
