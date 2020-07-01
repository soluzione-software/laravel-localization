<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * @inheritDoc
     */
    public function to($path, $extra = [], $secure = null)
    {
        return $this->isValidUrl($path)
            ? $path
            : parent::to(Str::start($path, '/' . App::getLocale()), $extra, $secure);
    }

    /**
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
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function toNotLocalized(string $path, $extra = [], $secure = null)
    {
        return parent::to($path, $extra, $secure);
    }

    /**
     * @inheritDoc
     * @throws UrlGenerationException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        return $this->routes->hasNamedRoute($name)
            ? $this->toRoute($this->routes->getByName($name), $parameters, $absolute)
            : parent::route(App::getLocale() . ".$name", $parameters, $absolute);
    }

    /**
     * @param  string  $locale
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    public function localizedRoute(string $locale, string $name, $parameters = [], bool $absolute = true)
    {
        $previousLocale = App::getLocale();
        App::setLocale($locale);
        $route = parent::route(Str::start($name, "$locale."), $parameters, $absolute);
        App::setLocale($previousLocale);
        return $route;
    }

    /**
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    public function notLocalizedRoute(string $name, $parameters = [], bool $absolute = true)
    {
        return parent::route($name, $parameters, $absolute);
    }
}
