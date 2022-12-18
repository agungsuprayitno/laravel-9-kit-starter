<?php

namespace App\Carts\Responses;

use App\Carts\Models\CartsModel;
use App\Carts\CartDetail\Responses\CartDetailResponse;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class CartResponse extends TransformerAbstract
{

    protected $availableIncludes = ['cartDetails'];

    public function transform(CartsModel $cartModel) {
        return [
            'id' => $cartModel->id,
            'cart_date' => Carbon::parse($cartModel->created_at)->format('Y-m-d H:i:s'),
            'amount' => number_format($cartModel->amount, 2),
        ];
    }

    protected function includeCartDetails(CartsModel $cartModel) {
        return $this->collection($cartModel->cartDetails, new CartDetailResponse());
    }
}
