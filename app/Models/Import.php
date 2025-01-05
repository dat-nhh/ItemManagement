<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Import extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'vendor',
        'date',
        'warehouse'
    ];

    public function vendorRel(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor'); 
    }

    public function warehouseRel(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse');
    }

    public function detailsRel(): HasMany
    {
        return $this->hasMany(Import_detail::class, 'import');
    }
}
