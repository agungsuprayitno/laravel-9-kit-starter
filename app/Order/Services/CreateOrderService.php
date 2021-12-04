<?php
namespace App\Order\Services;

use App\Order\Repositories\OrderRepository;
use App\Order\Requests\CreateOrderRequest;

class CreateOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function create(CreateOrderRequest $request){
        return $this->orderRepository->create($request);
    }
}