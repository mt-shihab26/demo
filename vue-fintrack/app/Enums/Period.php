<?php

namespace App\Enums;

use App\Traits\EnumBehavior;

enum Period: string
{
    use EnumBehavior;

    case MONTHLY = 'monthly';
    case WEEKLY = 'weekly';
}
