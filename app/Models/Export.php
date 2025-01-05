<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Export extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'customer',
        'date',
        'warehouse'
    ];

    public function customerRel(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer');
    }

    public function warehouseRel(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse');
    }

    public function detailsRel(): HasMany
    {
        return $this->hasMany(Export_detail::class, 'import');
    }
}
