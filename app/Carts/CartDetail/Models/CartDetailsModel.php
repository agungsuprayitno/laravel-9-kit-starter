<?php

namespace App\Carts\CartDetail\Models;

use App\Carts\Models\CartsModel;
use App\Products\Models\Product;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartDetailsModel extends Model
{
    use SoftDeletes, UUID;
    protected $table = 'cart_details';
    protected $primaryKey = 'id';
    public $incrementing=false;

    protected $fillable = [
        'cart_id',
        'product_id',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    public function cart() {
        return $this->belongsTo(CartsModel::class, 'cart_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}