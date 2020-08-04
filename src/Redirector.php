<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector as BaseRedirector;
use SoluzioneSoftware\Localization\Facades\Localization;
use SoluzioneSoftware\Localization\Facades\URL;

class Redirector extends BaseRedirector
{
    /**
     * @inheritDoc
     */
    public function route($route, $parameters = [], $status = 302, $headers = [])
    {
        return parent::route(Localization::localizeRouteName($route), $parameters, $status, $headers);
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
        return parent::route(Localization::localizeRouteName($route, $locale), $parameters, $status, $headers);
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
        return parent::route($route, $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to the given localized path.
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
        return parent::to(URL::toLocalized($locale, $path), $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to the given localized HTTPS path.
     *
     * @param  string  $locale
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @return RedirectResponse
     */
    public function localizedSecure(string $locale, string $path, int $status = 302, array $headers = [])
    {
        return parent::secure(URL::localizedSecure($locale, $path), $status, $headers);
    }
}
