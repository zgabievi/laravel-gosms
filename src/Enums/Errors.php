<?php

namespace Zorb\GoSMS\Enums;

use BenSampo\Enum\Enum;

final class Errors extends Enum
{
    const INVALID_API_KEY = 100;
    const INVALID_BRAND_NAME = 101;
    const NOT_ENOUGH_BALANCE = 102;
    const MESSAGE_TOO_LONG = 103;
    const MESSAGE_ID_NOT_FOUND = 104;
    const INVALID_NUMBER_FORMAT = 105;
    const NUMBER_IS_IN_BLACK_LIST = 106;
    const BRAND_ALREADY_EXISTS = 107;
    const BRAND_NAME_ADD_IMPOSSIBLE = 108;
}
