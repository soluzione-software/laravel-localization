<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use SoluzioneSoftware\Localization\Facades\Route;

class LocalizationManager
{
    public function current(): string
    {
        $prefix = Route::current()->getPrefix();

        return in_array($prefix, $this->all())
            ? $prefix
            : ($this->negotiateFromHeaders() ?: App::getLocale());
    }

    public function all(): array
    {
        return Config::get('localization.locales');
    }

    private function negotiateFromHeaders(): ?string
    {
        $accept = Request::header('Accept-Language');
        if (!$accept) {
            return null;
        }

        $locales = $this->all();
        foreach (explode(';', $accept) as $item) {
            if (in_array($item, $locales)) {
                return $item;
            }

            foreach (explode(',', $item) as $item2) {
                if (in_array($item2, $locales)) {
                    return $item2;
                }
            }
        }

        return null;
    }

    public function localizeRouteName(string $routeName, ?string $locale = null): string
    {
        $locale = $locale ?: App::getLocale();

        $localizedRouteName = Str::start($routeName, "$locale.");
        return Facades\Route::getRoutes()->hasNamedRoute($localizedRouteName) ? $localizedRouteName : $routeName;
    }
}
