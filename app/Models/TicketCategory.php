<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketCategory extends Model
{
    protected $guarded = ['id'];

    public function ticketSubcategories(): HasMany
    {
        return $this->hasMany(TicketSubcategory::class);
    }
}
