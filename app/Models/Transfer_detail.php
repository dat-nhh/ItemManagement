<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transfer_detail extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'transfer',
        'item',
        'date'
    ];

    public function transferRel(): BelongsTo
    {
        return $this->belongsTo(Transfer::class, 'transfer');
    }

    public function stockRel(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'stock');
    }
}
