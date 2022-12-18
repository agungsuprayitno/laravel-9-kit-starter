<?php
namespace App\Products\Services;

use App\Products\Repositories\ProductRepository;

class DeleteProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

    public function delete($id){
        return $this->productRepository->delete($id);
    }
}