<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = ['requester','notes','approved_at'];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
