<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'email'
    ];

    public function exportsRel(): HasMany
    {
        return $this->hasMany(Export::class, 'customer');
    }
}
