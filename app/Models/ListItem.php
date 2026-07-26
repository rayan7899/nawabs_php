<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

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

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function list()
    {
        return $this->belongsTo(ItemList::class, 'list_id');
    }
}
