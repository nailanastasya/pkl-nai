<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nodin extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'nodin',
        'subject',
        'date',
        'status',
        'file_path',
        'file_name',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }
}
