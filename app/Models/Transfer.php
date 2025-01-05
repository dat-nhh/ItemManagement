<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'from_warehouse',
        'to_warehouse',
        'date'
    ];

    public function fromRel(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse');
    }

    public function toRel(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse');
    }

    public function detailsRel(): HasMany
    {
        return $this->hasMany(Transfer_detail::class, 'transfer');
    }
}
