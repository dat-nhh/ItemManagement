<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable =[
        'id',
        'name',
        'address'
    ];

    public function importsRel(): HasMany
    {
        return $this->hasMany(Import::class, 'warehouse');
    }

    public function exportsRel(): HasMany
    {
        return $this->hasMany(Export::class, 'warehouse');
    }

    public function fromsRel(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_warehouse');
    }

    public function tosRel(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_warehouse');
    }
}
