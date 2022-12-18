<?php
namespace App\Orders\Services;

use App\Orders\Repositories\OrderRepository;

class DeleteOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function delete($id){
        return $this->orderRepository->delete($id);
    }
}