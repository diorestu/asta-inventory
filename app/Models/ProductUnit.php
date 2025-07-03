<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductUnit extends Model
{
    protected $guarded = ['id'];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'unit_id', 'id');
    }
}
