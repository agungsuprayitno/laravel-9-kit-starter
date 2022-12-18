<?php
namespace App\Carts\Services;

use App\Carts\Repositories\CartRepository;
use App\Carts\Requests\UpdateCartRequest;

class UpdateCartService
{
    public function __construct(
        protected CartRepository $cartRepository
    ){}

    public function update(string $id, UpdateCartRequest $request){
        return $this->cartRepository->update($id, $request);
    }
}