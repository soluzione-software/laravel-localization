<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
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
        $this->bootRedirector();
    }

    public function register()
    {
        $this->registerUrlGenerator();
    }

    private function bootRouter()
    {
        Router::macro('currentLocalizedRouteName', function (string $locale) {
            return str_replace(App::getLocale() . '.', "$locale.", Route::currentRouteName());
        });
    }

    private function bootRedirector()
    {
        Redirector::macro('localizedRoute', function (string $locale, string $route, array $parameters = [], int $status = 302, array $headers = []) {
            return Redirect::to(localized_route($locale, $route, $parameters), $status, $headers);
        });

        Redirector::macro('notLocalizedRoute', function (string $route, array $parameters = [], int $status = 302, array $headers = []) {
            return Redirect::to(not_localized_route($route, $parameters), $status, $headers);
        });

        Redirector::macro('toLocalized',
            function (string $locale, string $path, int $status = 302, array $headers = [], bool $secure = true) {
                return Redirect::to(localized_url($locale, $path, [], $secure), $status, $headers, $secure);
            });

        Redirector::macro('toNotLocalized',
            function (string $path, int $status = 302, array $headers = [], bool $secure = true) {
                return Redirect::to(not_localized_url($path, [], $secure), $status, $headers, $secure);
            });
    }

    /**
     * @see \Illuminate\Routing\RoutingServiceProvider::registerUrlGenerator
     */
    private function registerUrlGenerator()
    {
        $this->app->extend('url', function (UrlGeneratorContract $generator) {
            return new UrlGenerator(
                $generator,
                $this->app['routes'],
                $this->app['request'],
                $this->app['config']['app.asset_url']
            );
        });
    }
}
