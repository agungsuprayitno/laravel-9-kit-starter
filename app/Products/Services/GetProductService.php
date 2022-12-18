<?php
namespace App\Products\Services;

use App\Products\Repositories\ProductRepository;

class GetProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ){}

    public function getAll(){
        return $this->productRepository->findAll();
    }

    public function getPerPage(){

        return $this->productRepository->findPerPage();
    }

    public function getById($id){
        return $this->productRepository->findById($id);
    }
}