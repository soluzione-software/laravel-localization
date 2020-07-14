<?php

namespace SoluzioneSoftware\Localization;

use BadMethodCallException;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
use Illuminate\Http\RedirectResponse;
use SoluzioneSoftware\Localization\Facades\Localization;
use SoluzioneSoftware\Localization\Facades\URL;

/**
 * @mixin \Illuminate\Routing\Redirector
 */
class Redirector
{
    /**
     * @var \Illuminate\Routing\Redirector
     */
    protected $redirector;

    public function __construct(UrlGeneratorContract $urlGenerator) {
        $this->redirector = new \Illuminate\Routing\Redirector($urlGenerator);
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return RedirectResponse
     * @see \Illuminate\Routing\Redirector::to
     */
    public function to($path, $status = 302, $headers = [], $secure = null): RedirectResponse
    {
        return $this->redirector->to(URL::to($path, [], $secure), $status, $headers);
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param  string  $route
     * @param  mixed   $parameters
     * @param  int     $status
     * @param  array   $headers
     * @return RedirectResponse
     */
    public function route($route, $parameters = [], $status = 302, $headers = []): RedirectResponse
    {
        return $this->redirector->route(Localization::localizeRouteName($route), $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to a localized named route.
     *
     * @param  string  $locale
     * @param  string  $route
     * @param  mixed  $parameters
     * @param  int  $status
     * @param  array  $headers
     * @return RedirectResponse
     */
    public function localizedRoute(string $locale, string $route, array $parameters = [], int $status = 302, array $headers = [])
    {
        return $this->redirector->route(Localization::localizeRouteName($route, $locale), $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to a not localized named route.
     *
     * @param  string  $route
     * @param  mixed  $parameters
     * @param  int  $status
     * @param  array  $headers
     * @return RedirectResponse
     */
    public function notLocalizedRoute(string $route, array $parameters = [], int $status = 302, array $headers = [])
    {
        return $this->redirector->route($route, $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to a localized named route.
     *
     * @param  string  $locale
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool  $secure
     * @return RedirectResponse
     */
    public function toLocalized(string $locale, string $path, int $status = 302, array $headers = [], bool $secure = true)
    {
        return $this->redirector->to(URL::toLocalized($locale, $path, [], $secure), $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to a not localized named route.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool  $secure
     * @return RedirectResponse
     */
    public function toNotLocalized(string $path, int $status = 302, array $headers = [], bool $secure = true)
    {
        return $this->redirector->to(URL::toNotLocalized($path, [], $secure), $status, $headers, $secure);
    }

    /**
     * Get the decorated Redirector instance.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function getRedirector()
    {
        return $this->redirector;
    }

    /**
     * Pass dynamic methods call onto decorated Redirector.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array([$this->redirector, $method], $parameters);
    }
}
