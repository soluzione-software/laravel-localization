<?php

namespace SoluzioneSoftware\Localization\Facades;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect as BaseRedirect;
use SoluzioneSoftware\Localization\Redirector;

/**
 * @method static RedirectResponse localizedRoute(string $locale, string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method static RedirectResponse notLocalizedRoute(string $route, array $parameters = [], int $status = 302, array $headers = [])
 * @method static RedirectResponse toLocalized(string $locale, string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static RedirectResponse toNotLocalized(string $path, int $status = 302, array $headers = [], bool $secure = null)
 *
 * @see Redirector
 */
class Redirect extends BaseRedirect
{
    //
}
