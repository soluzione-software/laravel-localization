<?php

namespace SoluzioneSoftware\Localization;

use BadMethodCallException;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UrlGenerator implements UrlGeneratorContract
{
    /**
     * @var UrlGeneratorContract
     */
    protected $urlGenerator;

    public function __construct(UrlGeneratorContract $urlGenerator) {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritDoc
     */
    public function to($path, $extra = [], $secure = null)
    {
        return $this->isValidUrl($path)
            ? $path
            : $this->urlGenerator->to(Str::start($path, '/'.App::getLocale()), $extra, $secure);
    }

    /**
     * @inheritDoc
     * @throws UrlGenerationException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        return Facades\Route::getRoutes()->hasNamedRoute($name)
            ? $this->toRoute(Facades\Route::getRoutes()->getByName($name), $parameters, $absolute)
            : $this->urlGenerator->route(App::getLocale().".$name", $parameters, $absolute);
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->urlGenerator->current();
    }

    /**
     * @inheritDoc
     */
    public function previous($fallback = false)
    {
        return $this->urlGenerator->previous($fallback);
    }

    /**
     * @inheritDoc
     */
    public function secure($path, $parameters = [])
    {
        return $this->urlGenerator->secure($path, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function asset($path, $secure = null)
    {
        return $this->urlGenerator->asset($path, $secure);
    }

    /**
     * @inheritDoc
     */
    public function action($action, $parameters = [], $absolute = true)
    {
        return $this->urlGenerator->action($action, $parameters, $absolute);
    }

    /**
     * @inheritDoc
     */
    public function setRootControllerNamespace($rootNamespace)
    {
        return $this->urlGenerator->setRootControllerNamespace($rootNamespace);
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
            : $this->urlGenerator->to(Str::start($path, "/$locale"), $extra, $secure);
    }

    /**
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function toNotLocalized(string $path, $extra = [], $secure = null)
    {
        return $this->urlGenerator->to($path, $extra, $secure);
    }

    /**
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
        $route = $this->urlGenerator->route(Str::start($name, "$locale."), $parameters, $absolute);
        App::setLocale($previousLocale);
        return $route;
    }

    /**
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     * @throws InvalidArgumentException
     */
    public function notLocalizedRoute(string $name, $parameters = [], bool $absolute = true)
    {
        return $this->urlGenerator->route($name, $parameters, $absolute);
    }

    /**
     * Get the decorated Url generator instance.
     *
     * @return UrlGeneratorContract
     */
    public function getUrlGenerator(): UrlGeneratorContract
    {
        return $this->urlGenerator;
    }

    /**
     * Determine if the given path is a valid URL.
     *
     * @param  string  $path
     * @return bool
     * @see \Illuminate\Routing\UrlGenerator::isValidUrl
     */
    public function isValidUrl($path)
    {
        return $this->__call('isValidUrl', [$path]);
    }

    /**
     * Get the URL for a given route instance.
     *
     * @param  Route  $route
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     * @throws UrlGenerationException
     * @see \Illuminate\Routing\UrlGenerator::toRoute
     */
    public function toRoute(Route $route, $parameters, bool $absolute)
    {
        return $this->__call('toRoute', [$route, $parameters, $absolute]);
    }

    /**
     * Pass dynamic methods call onto decorated UrlGenerator.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array([$this->urlGenerator, $method], $parameters);
    }
}
