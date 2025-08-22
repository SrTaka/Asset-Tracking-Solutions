<?php

namespace App\Services;

use App\Models\Asset;
use Illuminate\Support\Str;

class AssetService
{
    public static function generateUniqueId(int $length = 8): string
    {
        do {
            $id = Str::upper(Str::random($length));
        } while (Asset::where('id', $id)->exists());

        return $id;
    }
}


