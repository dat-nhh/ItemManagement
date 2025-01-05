<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Export_detail extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'export',
        'item',
        'quantity'
    ];

    public function exportRel(): BelongsTo
    {
        return $this->belongsTo(Export::class, 'export');
    }

    public function stockRel(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'item');
    }
}
