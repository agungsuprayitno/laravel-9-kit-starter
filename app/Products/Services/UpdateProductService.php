<?php
namespace App\Products\Services;

use App\Products\Repositories\ProductRepository;
use App\Products\Requests\UpdateProductRequest;

class UpdateProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

    public function update(int $id, UpdateProductRequest $request){
        return $this->productRepository->update($id, $request);
    }
}