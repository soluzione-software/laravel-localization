<?php

namespace SoluzioneSoftware\Localization\Facades;

use DateInterval;
use DateTimeInterface;

/**
 * @method static string localizedRoute(string $locale, string $name, mixed $parameters = [], bool $absolute = true)
 * @method static string localizedSignedRoute(string $locale, string $name, array $parameters = [], DateTimeInterface|DateInterval|int|null $expiration = null, bool $absolute = true)
 * @method static string localizedTemporarySignedRoute(string $locale, string $name, DateTimeInterface|DateInterval|int|null $expiration = null, array $parameters = [], bool $absolute = true)
 * @method static string notLocalizedRoute(string $name, mixed $parameters = [], bool $absolute = true)
 * @method static string notLocalizedSignedRoute(string $name, array $parameters = [], DateTimeInterface|DateInterval|int|null $expiration = null, bool $absolute = true)
 * @method static string notLocalizedTemporarySignedRoute(string $name, DateTimeInterface|DateInterval|int|null $expiration = null, array $parameters = [], bool $absolute = true)
 * @method static string toLocalized(string $locale, string $path, mixed $extra = [], bool|null $secure = null)
 * @method static string localizedSecure(string $locale, string $path, mixed $extra = [])
 *
 * @see \SoluzioneSoftware\Localization\UrlGenerator
 */
class URL extends \Illuminate\Support\Facades\URL
{
    //
}
