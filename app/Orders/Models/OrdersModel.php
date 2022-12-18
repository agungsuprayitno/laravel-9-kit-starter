<?php

namespace App\Orders\Models;

use App\Orders\OrderDetail\Models\OrderDetailsModel;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersModel extends Model
{
    use SoftDeletes , UUID;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing=false;

    protected $fillable = [
        'customer_id',
        'order_no',
        'order_date',
        'status',
        'amount',
        'created_by',
        'modified_by',
        'deleted_by',
        'deleted_at',
    ];

    public function orderDetails() {
        return $this->hasMany(OrderDetailsModel::class, 'order_id', 'id');
    }
}