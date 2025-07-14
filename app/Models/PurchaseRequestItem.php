<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequestItem extends Model
{
    protected $guarded = ['id'];

    public function purchaseRequest(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id', 'id');
    }

    // Satu item PR bisa masuk ke satu item PO
    public function purchaseOrderItem(): HasOne
    {
        return $this->hasOne(PurchaseOrderItem::class);
    }
}
