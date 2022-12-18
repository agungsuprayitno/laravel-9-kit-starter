<?php

namespace App\Orders\OrderDetail\Responses;

use App\Orders\OrderDetail\Models\OrderDetailsModel;
use League\Fractal\TransformerAbstract;

class OrderDetailResponse extends TransformerAbstract
{

    public function transform(OrderDetailsModel $orderDetailModel) {
        return [
            'id' => $orderDetailModel->id,
            'product_id' => $orderDetailModel->product_id,
            'product_name' => $orderDetailModel->product->name,
            'product_price' => $orderDetailModel->product->price,
            'order_id' => $orderDetailModel->order_id,
            'order_no' => $orderDetailModel->order->order_no,
            'order_date' => $orderDetailModel->order->order_date,
        ];
    }
}
