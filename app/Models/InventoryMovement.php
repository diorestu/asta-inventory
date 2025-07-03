<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $guarded = ['id'];
    
    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'fromwh_id', 'id');
    }
    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'towh_id', 'id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'prod_id', 'id');
    }
}
