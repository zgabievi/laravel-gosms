<?php

namespace Zorb\GoSMS\Facades;

use Zorb\GoSMS\GoSMS as GoSMSService;
use Illuminate\Support\Facades\Facade;

class GoSMS extends Facade
{
    //
    protected static function getFacadeAccessor()
    {
        return GoSMSService::class;
    }
}
