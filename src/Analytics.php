<?php

namespace WdevRs\LaravelAnalytics;

use Illuminate\Support\Facades\Facade;

/**
 * @see LaravelAnalytics
 */
class Analytics extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-analytics';
    }
}
