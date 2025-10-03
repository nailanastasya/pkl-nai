<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'nodin_id',
        'customer_product_id',
        'invoice_subject',
        'description',
        'amount',
        'file_path',
        'date',
        'due_date',
        'status'
    ];

    public function nodin()
    {
        return $this->belongsTo(Nodin::class);
    }

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class, 'customer_product_id');
    }

    // Relasi: 1 Invoice bisa punya banyak Receipt
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
