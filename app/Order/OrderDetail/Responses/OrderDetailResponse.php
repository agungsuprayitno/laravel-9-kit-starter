<?php

namespace App\Order\OrderDetail\Responses;

use App\Order\OrderDetail\Models\OrderDetailsModel;
use League\Fractal\TransformerAbstract;

class OrderDetailResponse extends TransformerAbstract
{

    public function transform(OrderDetailsModel $orderDetailModel) {
        return [
            'id' => $orderDetailModel->id,
            'menu_id' => $orderDetailModel->menu_id,
            'menu_name' => $orderDetailModel->menu->name,
            'menu_price' => $orderDetailModel->menu->price,
            'order_id' => $orderDetailModel->order_id,
            'order_no' => $orderDetailModel->order->order_no,
            'order_date' => $orderDetailModel->order->order_date,
        ];
    }
}
