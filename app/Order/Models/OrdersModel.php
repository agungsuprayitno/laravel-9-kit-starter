<?php

namespace App\Order\Models;

use App\Order\OrderDetail\Models\OrderDetailsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersModel extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
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