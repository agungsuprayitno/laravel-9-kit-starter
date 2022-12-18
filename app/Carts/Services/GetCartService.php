<?php
namespace App\Carts\Services;

use App\Carts\Repositories\CartRepository;
use App\Carts\Requests\GetCartByStatusRequest;

class GetCartService
{
    public function __construct(
        protected CartRepository $cartRepository
    ){}

    public function getAll(){
        return $this->cartRepository->findAll();
    }

    public function getPerPage(){

        return $this->cartRepository->findPerPage();
    }

    public function getById($id){
        return $this->cartRepository->findById($id);
    }
    public function getByStatus(GetCartByStatusRequest $request){
        return $this->cartRepository->findByStatus($request);
    }
}