<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\UrlGenerator;
use SoluzioneSoftware\Localization\Facades\URL;

if (! function_exists('localized_route')) {
    /**
     * Generate the URL to a localized named route.
     *
     * @param  string  $locale
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function localized_route(string $locale, string $name, $parameters = [], bool $absolute = true)
    {
        return URL::localizedRoute($locale, $name, $parameters, $absolute);
    }
}

if (! function_exists('not_localized_route')) {
    /**
     * Generate the URL to a not localized named route.
     *
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function not_localized_route(string $name, $parameters = [], bool $absolute = true)
    {
        return URL::notLocalizedRoute($name, $parameters, $absolute);
    }
}

if (! function_exists('localized_url')) {
    /**
     * Generate a localized url for the application.
     *
     * @param  string  $locale
     * @param  string|null  $path
     * @param  mixed  $parameters
     * @param  bool|null  $secure
     * @return UrlGenerator|string
     */
    function localized_url(string $locale, $path = null, $parameters = [], $secure = null)
    {
        return is_null($path)
            ? Container::getInstance()
            : URL::toLocalized($locale, $path, $parameters, $secure);
    }
}

if (! function_exists('localized_secure_url')) {
    /**
     * Generate a localized HTTPS url for the application.
     *
     * @param  string  $locale
     * @param  string  $path
     * @param  mixed  $parameters
     * @return string
     */
    function localized_secure_url(string $locale, string $path, $parameters = []): string
    {
        return localized_url($locale, $path, $parameters, true);
    }
}
