<?php
namespace App\Products\Services;

use App\Products\Repositories\ProductRepository;
use App\Products\Requests\CreateProductRequest;

class CreateProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

    public function create(CreateProductRequest $request){
        return $this->productRepository->create($request);
    }
}