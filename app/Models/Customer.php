<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function contactPeople()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function customerProducts()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrders::class);
    }
}
