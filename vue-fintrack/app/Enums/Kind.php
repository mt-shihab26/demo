<?php

namespace App\Enums;

use App\Traits\EnumBehavior;

enum Kind: string
{
    use EnumBehavior;

    case INCOME = 'income';
    case EXPENSE = 'expense';
}
