<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_position',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
