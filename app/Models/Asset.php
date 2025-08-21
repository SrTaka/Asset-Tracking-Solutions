 <?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AssetService
{
    public static function generateUniqueId($length = 8)
    {
        do {
            $id = Str::upper(Str::random($length));
        } while (self::where('id', $id)->exists());

        return $id;
    }
}

class Asset extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asset) {
            if (empty($asset->id)) {
                $asset->id = self::generateUniqueId();
            }
        });
    }

    public static function generateUniqueId($length = 8)
    {
        do {
            // Generates a random uppercase alphanumeric string
            $id = Str::upper(Str::random($length));
        } while (self::where('id', $id)->exists());

        return $id;
    }
}