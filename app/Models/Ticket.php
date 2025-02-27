<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $guarded = ['id'];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(TicketSubcategory::class, "ticket_subcategory_id");
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
    
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function handle(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handle_by');
    }

    public function problemHandlings(): HasOne
    {
        return $this->hasOne(ProblemHandling::class);
    }
    public function menuBoms(): HasMany
    {
        return $this->hasMany(MenuBom::class);
    }
    public function promos(): HasMany
    {
        return $this->hasMany(Promo::class);
    }
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
    public function voidMenus(): HasMany
    {
        return $this->hasMany(VoidMenu::class);
    }
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }
    public function assetRequests(): HasMany
    {
        return $this->hasMany(AssetRequest::class);
    }
}
