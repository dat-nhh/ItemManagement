<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'email'
    ];

    public function importsRel(): HasMany
    {
        return $this->hasMany(Import::class, 'vendor');
    }
}
