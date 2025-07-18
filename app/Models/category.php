<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = ['name', 'color'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getColorAttribute($value)
    {
        return $value ?: '#000000'; // Default color if not set
    }
}
