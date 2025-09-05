<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemUsage extends Model
{
    protected $fillable = ['action'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
