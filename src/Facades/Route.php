<?php

namespace SoluzioneSoftware\Localization\Facades;

use Illuminate\Routing\Router;
use SoluzioneSoftware\Localization\RoutingServiceProvider;

/**
 * @method static string|null currentLocalizedRouteName(string $locale)
 * @method static Router aliasMiddleware(string $name, string $class)
 *
 * @see RoutingServiceProvider::bootRouter
 */
class Route extends \Illuminate\Support\Facades\Route
{
    //
}
