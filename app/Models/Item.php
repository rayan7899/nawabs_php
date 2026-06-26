<?php

namespace App\Models;

use App\Observers\ItemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

#[ObservedBy(ItemObserver::class)]
class Item extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'type',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->created_by = Auth::id();
        });
    }

    public function itemUsage(): HasMany
    {
        return $this->hasMany(ItemUsage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
