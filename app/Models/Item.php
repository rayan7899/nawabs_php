<?php

namespace App\Models;

use App\Observers\ItemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy(ItemObserver::class)]
class Item extends Model
{
    protected $fillable = [
        'name',
        'active',
        'list_id',
        'user_id',
        'category_id',
        'private'
    ];

    public function itemUsage()
    {
        return $this->hasMany(ItemUsage::class);
    }

    public function lists()
    {
        return $this->belongsToMany(ItemList::class, 'item_list')
                    ->withPivot('active')
                    ->withTimestamps();
    }
    
    public function list()
    {
        return $this->belongsTo(ItemList::class, 'list_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
