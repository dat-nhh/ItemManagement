<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Import_detail extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'import',
        'item',
        'quantity'
    ];

    public function importRel(): BelongsTo
    {
        return $this->belongsTo(Import::class, 'import');
    }

    public function stockRel(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'item');
    }
}
