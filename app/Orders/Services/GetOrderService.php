<?php
namespace App\Orders\Services;

use App\Orders\Repositories\OrderRepository;
use App\Orders\Requests\GetOrderByStatusRequest;

class GetOrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ){}

    public function getAll(){
        return $this->orderRepository->findAll();
    }

    public function getPerPage(){

        return $this->orderRepository->findPerPage();
    }

    public function getById($id){
        return $this->orderRepository->findById($id);
    }
    public function getByStatus(GetOrderByStatusRequest $request){
        return $this->orderRepository->findByStatus($request);
    }
}