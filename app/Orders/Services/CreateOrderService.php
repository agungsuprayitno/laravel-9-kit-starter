<?php
namespace App\Orders\Services;

use App\Orders\Repositories\OrderRepository;
use App\Orders\Requests\CreateOrderRequest;

class CreateOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function create(CreateOrderRequest $request){
        return $this->orderRepository->create($request);
    }
}