<?php

namespace SoluzioneSoftware\Localization\Facades;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Route;

/**
 * @method static string localizedRoute(string $locale, string $name, mixed $parameters = [], bool $absolute = true)
 * @method static string notLocalizedRoute(string $name, mixed $parameters = [], bool $absolute = true)
 * @method static string toLocalized(string $locale, string $path, mixed $extra = [], bool|null $secure = null)
 * @method static string toNotLocalized(string $path, mixed $extra = [], bool|null $secure = null)
 * @method static bool isValidUrl(string $path)
 * @method static string toRoute(Route $route, mixed $parameters, bool $absolute)
 * @method static UrlGenerator getUrlGenerator()
 *
 * @see \SoluzioneSoftware\Localization\UrlGenerator
 */
class URL extends \Illuminate\Support\Facades\URL
{
    //
}
