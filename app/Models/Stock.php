<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'item',
        'warehouse',
        'quantity'
    ];

    public function importsRel(): BelongsToMany
    {
        return $this->belongsToMany(Import_detail::class, 'item');
    }

    public function exportsRel(): BelongsToMany
    {
        return $this->belongsToMany(Export_detail::class, 'item');
    }

    public function transfersRel(): BelongsToMany
    {
        return $this->belongsToMany(Transfer_detail::class, 'item');
    }

    public function itemRel(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item');
    }
}
