<?php

namespace App\Orders\Responses;

use App\Orders\Models\OrdersModel;
use App\Orders\OrderDetail\Responses\OrderDetailResponse;
use League\Fractal\TransformerAbstract;

class OrderResponse extends TransformerAbstract
{

    protected $availableIncludes = ['orderDetails'];

    public function transform(OrdersModel $orderModel) {
        return [
            'id' => $orderModel->id,
            'order_no' => $orderModel->order_no,
            'order_date' => $orderModel->order_date,
            'amount' => $orderModel->amount,
            'status' => $orderModel->status
        ];
    }

    protected function includeOrderDetails(OrdersModel $orderModel) {
        return $this->collection($orderModel->orderDetails, new OrderDetailResponse());
    }
}
