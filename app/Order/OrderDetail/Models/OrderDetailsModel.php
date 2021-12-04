<?php

namespace App\Order\OrderDetail\Models;

use App\Menu\Models\MenusModel;
use App\Order\Models\OrdersModel;
use Illuminate\Database\Eloquent\Model;

class OrderDetailsModel extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'menu_id',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    public function order() {
        return $this->belongsTo(OrdersModel::class, 'order_id', 'id');
    }

    public function menu() {
        return $this->belongsTo(MenusModel::class, 'menu_id', 'id');
    }
}