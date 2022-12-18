<?php

namespace App\Carts\Models;

use App\Carts\CartDetail\Models\CartDetailsModel;
use App\Customers\Models\Customer;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class CartsModel extends Model
{
    use UUID;
    protected $table = 'carts';
    protected $primaryKey = 'id';

    public $incrementing=false;

    protected $fillable = [
        'customer_id',
        'amount',
        'created_by',
        'modified_by',
    ];

    public function cartDetails() {
        return $this->hasMany(CartDetailsModel::class, 'cart_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}