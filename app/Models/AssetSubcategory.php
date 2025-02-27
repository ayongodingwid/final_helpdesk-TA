<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetSubcategory extends Model
{
    protected $guarded = ['id'];

    public function asetCategory(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function asets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
