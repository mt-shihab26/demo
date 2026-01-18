<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage as StorageFacade;

class Storage
{
    public static function public(): mixed
    {
        return StorageFacade::disk('public');
    }
}
