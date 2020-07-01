<?php

namespace SoluzioneSoftware\Localization\Facades;

use Illuminate\Support\Facades\Facade;
use SoluzioneSoftware\Localization\LocalizationManager;

/**
 * @method static string current()
 *
 * @see LocalizationManager
 */
class Localization extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'localization.manager';
    }
}
