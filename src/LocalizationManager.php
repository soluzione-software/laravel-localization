<?php

namespace SoluzioneSoftware\Localization;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use SoluzioneSoftware\Localization\Facades\Route;

class LocalizationManager
{
    public function current(): string
    {
        $prefix = Route::current()->getPrefix();

        return in_array($prefix, Config::get('localization.locales'))
            ? $prefix
            : App::getLocale();
    }
}
