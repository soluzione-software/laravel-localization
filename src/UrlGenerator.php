<?php

namespace SoluzioneSoftware\Localization;

use DateInterval;
use DateTimeInterface;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use InvalidArgumentException;
use SoluzioneSoftware\Localization\Facades\Localization;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * @inheritDoc
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        return parent::route(Localization::localizeRouteName($name), $parameters, $absolute);
    }

    /**
     * @inheritDoc
     */
    public function signedRoute($name, $parameters = [], $expiration = null, $absolute = true)
    {
        return parent::signedRoute(Localization::localizeRouteName($name), $parameters, $expiration, $absolute);
    }

    /**
     * Generate an absolute URL to the given localized path.
     *
     * @param  string  $locale
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function toLocalized(string $locale, string $path, $extra = [], $secure = null)
    {
        return $this->isValidUrl($path)
            ? $path
            : parent::to(Str::start($path, "/$locale"), $extra, $secure);
    }

    /**
     * Generate a localized secure, absolute URL to the given path.
     *
     * @param  string  $locale
     * @param  string  $path
     * @param  mixed  $extra
     * @return string
     */
    public function localizedSecure(string $locale, string $path, $extra = [])
    {
        return $this->toLocalized($locale, $path, $extra, true);
    }

    /**
     * Get the URL to a localized named route.
     *
     * @param  string  $locale
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     * @throws InvalidArgumentException
     */
    public function localizedRoute(string $locale, string $name, $parameters = [], bool $absolute = true)
    {
        $previousLocale = App::getLocale();
        App::setLocale($locale);
        $route = parent::route(Localization::localizeRouteName($name, $locale), $parameters, $absolute);
        App::setLocale($previousLocale);
        return $route;
    }

    /**
     * Get the URL to a not localized named route.
     *
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     * @throws InvalidArgumentException
     */
    public function notLocalizedRoute(string $name, $parameters = [], bool $absolute = true)
    {
        return parent::route($name, $parameters, $absolute);
    }

    /**
     * Create a signed route URL for a localized named route.
     *
     * @param  string  $locale
     * @param  string  $name
     * @param  array  $parameters
     * @param  DateTimeInterface|DateInterval|int|null  $expiration
     * @param  bool  $absolute
     * @return string
     */
    public function localizedSignedRoute(string $locale, string $name, $parameters = [], $expiration = null, $absolute = true)
    {
        $previousLocale = App::getLocale();
        App::setLocale($locale);
        $route = parent::signedRoute(Localization::localizeRouteName($name, $locale), $parameters, $expiration, $absolute);
        App::setLocale($previousLocale);
        return $route;
    }

    /**
     * Create a signed route URL for a not localized named route.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @param  DateTimeInterface|DateInterval|int|null  $expiration
     * @param  bool  $absolute
     * @return string
     */
    public function notLocalizedSignedRoute($name, $parameters = [], $expiration = null, $absolute = true)
    {
        return parent::signedRoute($name, $parameters, $expiration, $absolute);
    }

    /**
     * Create a temporary signed route URL for a localized named route.
     *
     * @param  string  $locale
     * @param  string  $name
     * @param  DateTimeInterface|DateInterval|int  $expiration
     * @param  array  $parameters
     * @param  bool  $absolute
     * @return string
     */
    public function localizedTemporarySignedRoute(string $locale, string $name, $expiration, $parameters = [], $absolute = true)
    {
        return parent::temporarySignedRoute(Localization::localizeRouteName($name, $locale), $expiration, $parameters, $absolute);
    }

    /**
     * Create a temporary signed route URL for a not localized named route.
     *
     * @param  string  $name
     * @param  DateTimeInterface|DateInterval|int  $expiration
     * @param  array  $parameters
     * @param  bool  $absolute
     * @return string
     */
    public function notLocalizedTemporarySignedRoute($name, $expiration, $parameters = [], $absolute = true)
    {
        return parent::signedRoute($name, $expiration, $parameters, $absolute);
    }
}
