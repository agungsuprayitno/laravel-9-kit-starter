<?php

namespace App\Carts\CartDetail\Responses;

use App\Carts\CartDetail\Models\CartDetailsModel;
use League\Fractal\TransformerAbstract;

class CartDetailResponse extends TransformerAbstract
{

    public function transform(CartDetailsModel $cartDetailModel) {
        return [
            'id' => $cartDetailModel->id,
            'product_id' => $cartDetailModel->product_id,
            'qty' => $cartDetailModel->qty,
            'product_name' => $cartDetailModel->product->name,
            'product_price' => number_format($cartDetailModel->product->price, 2),
            'cart_id' => $cartDetailModel->cart_id,
        ];
    }
}
