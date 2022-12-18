<?php
namespace App\Carts\Services;

use App\Carts\Repositories\CartRepository;
use App\Carts\Requests\CreateCartRequest;

class CreateCartService
{
    public function __construct(
        protected CartRepository $cartRepository
    ){}

    public function create(CreateCartRequest $request){
        return $this->cartRepository->create($request);
    }
}