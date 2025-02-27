<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    protected $guarded = ['id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, "asset_category_id");
    }

    public function business_unit(): BelongsTo
    {
        return $this->belongsTo(BusinessUnit::class);
    }


}
