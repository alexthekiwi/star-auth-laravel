<?php

namespace AlexClark\StarAuth;

use Illuminate\Support\Facades\Facade;

class StarAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'star-auth';
    }
}
