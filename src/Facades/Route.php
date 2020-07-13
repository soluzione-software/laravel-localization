<?php

namespace SoluzioneSoftware\Localization\Facades;

use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use SoluzioneSoftware\Localization\RoutingServiceProvider;

/**
 * @method static string|null currentLocalizedRouteName(string $locale)
 * @method static Router aliasMiddleware(string $name, string $class)
 * @method static RouteCollection getRoutes()
 *
 * @see RoutingServiceProvider::bootRouter
 */
class Route extends \Illuminate\Support\Facades\Route
{
    //
}
