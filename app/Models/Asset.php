 <?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\AssetService;

class Asset extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'description', 'category_id', 'purchase_date', 'purchase_price'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($asset) {
            if (empty($asset->id)) {
                $asset->id = AssetService::generateUniqueId();
            }
        });
    }
}