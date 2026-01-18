<?php

namespace App\Enums;

use App\Traits\EnumBehavior;

enum Currency: string
{
    use EnumBehavior;

    case BDT = 'BDT';
    case USD = 'USD';
}
