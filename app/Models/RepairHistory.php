<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairHistory extends Model
{
    protected $guarded = ['id'];

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_repair');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
