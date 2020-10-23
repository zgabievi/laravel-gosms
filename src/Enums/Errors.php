<?php

namespace Zorb\GoSMS\Enums;

use BenSampo\Enum\Enum;

final class Errors extends Enum
{
    const INVALID_API_KEY = 100;
    const INVALID_BRAND_NAME = 101;
    const NOT_ENOUGH_BALANCE = 102;
    const MESSAGE_TOO_LONG = 103;
}
