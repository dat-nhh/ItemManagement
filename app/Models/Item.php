<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable =[
        'id',
        'name',
        'category',
        'unit'
    ];

    public function stocksRel(): HasMany
    {
        return $this->hasMany(Stock::class, 'item');
    }

    public function categoryRel(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category'); 
    }
}
