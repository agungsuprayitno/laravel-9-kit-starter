<?php
namespace App\Order\Services;

use App\Order\Repositories\OrderRepository;
use App\Order\Requests\UpdateOrderRequest;

class UpdateOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function update(int $id, UpdateOrderRequest $request){
        return $this->orderRepository->update($id, $request);
    }
}