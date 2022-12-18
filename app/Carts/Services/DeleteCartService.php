<?php
namespace App\Carts\Services;

use App\Carts\Repositories\CartRepository;

class DeleteCartService
{
    public function __construct(
        protected CartRepository $cartRepository
    ){}

    public function delete($id){
        return $this->cartRepository->delete($id);
    }
}