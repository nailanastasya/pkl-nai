<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'invoice_id',
        'file_path',
        'date',
    ];

    // Relasi: 1 Receipt milik 1 Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
