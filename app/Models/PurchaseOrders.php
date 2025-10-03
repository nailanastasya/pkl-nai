<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'purchase_order_number',
        'file_path',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function nodins()
    {
        return $this->belongsTo(Nodin::class);
    }
}
