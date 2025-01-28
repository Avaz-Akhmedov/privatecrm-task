<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'client_name',
        'client_phone',
        'tarrif_id',
        'schedule_type',
        'comment',
        'first_date',
        'last_date',
    ];

    public function tarrif(): BelongsTo
    {
        return $this->belongsTo(Tarrif::class);
    }

    public function rations(): HasMany
    {
        return $this->hasMany(Ration::class);
    }
}
