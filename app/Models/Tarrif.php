<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarrif extends Model
{
    protected $table = 'tarrifs';
    protected $fillable = [
        'ration_name',
        'cooking_day_before',
    ];

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class);
    }
}
