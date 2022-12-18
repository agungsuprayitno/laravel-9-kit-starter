<?php
namespace App\Orders\Services;

use App\Orders\Repositories\OrderRepository;
use App\Orders\Requests\UpdateOrderRequest;

class UpdateOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function update(int $id, UpdateOrderRequest $request){
        return $this->orderRepository->update($id, $request);
    }
}