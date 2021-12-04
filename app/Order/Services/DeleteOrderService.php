<?php
namespace App\Order\Services;

use App\Order\Repositories\OrderRepository;

class DeleteOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function delete($id){
        return $this->orderRepository->delete($id);
    }
}