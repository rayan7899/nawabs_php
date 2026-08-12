<?php

namespace App\Models;

use App\Observers\ListItemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

#[ObservedBy(ListItemObserver::class)]
class ListItem extends Pivot
{
    protected $table = 'list_items';
    protected $fillable = [
        'need_at',
        'needed_by',
        'status',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($listItem) {
            if (!$listItem->created_by) {
                $listItem->created_by = Auth::id();
            }
        });
    }

    public function itemUsages()
    {
        return $this->hasMany(ItemUsage::class, 'list_items_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function list()
    {
        return $this->belongsTo(ItemList::class, 'list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
