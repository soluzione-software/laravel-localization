<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use SoluzioneSoftware\Localization\Facades\Route;

class LocalizationManager
{
    public function current(): string
    {
        $prefix = Route::current()->getPrefix();

        return in_array($prefix, $this->all())
            ? $prefix
            : App::getLocale();
    }

    public function all(): array
    {
        return Config::get('localization.locales');
    }

    public function localizeRouteName(string $routeName, ?string $locale = null): string
    {
        $locale = $locale ?: App::getLocale();

        $localizedRouteName = Str::start($routeName, "$locale.");
        return Facades\Route::getRoutes()->hasNamedRoute($localizedRouteName) ? $localizedRouteName : $routeName;
    }
}
