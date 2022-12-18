<?php

namespace App\Orders\OrderDetail\Models;

use App\Orders\Models\OrdersModel;
use App\Products\Models\Product;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class OrderDetailsModel extends Model
{
    use UUID;
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    public $incrementing=false;

    protected $fillable = [
        'order_id',
        'product_id',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    public function order() {
        return $this->belongsTo(OrdersModel::class, 'order_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}