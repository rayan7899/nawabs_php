<?php

namespace App\Models;

use App\ItemUsageActions;
use Illuminate\Database\Eloquent\Model;

class ItemUsage extends Model
{
    protected $fillable = ['action'];

    protected $casts = [
        'action' => ItemUsageActions::class,
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
