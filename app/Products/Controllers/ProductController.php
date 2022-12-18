<?php

namespace App\Products\Controllers;

use App\Products\Services\GetProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Products\Requests\CreateProductRequest;
use App\Products\Requests\UpdateProductRequest;
use App\Products\Responses\ProductResponse;
use App\Products\Services\CreateProductService;
use App\Products\Services\DeleteProductService;
use App\Products\Services\UpdateProductService;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductController extends Controller
{
    public function __construct(
        protected Manager $fractal,
        protected GetProductService $getProductService,
        protected CreateProductService $createProductService,
        protected UpdateProductService $updateProductService,
        protected DeleteProductService $deleteProductService,
    ){}

    public function getall(){
        $product = $this->getProductService->getAll();
        $product = new Collection($product, new ProductResponse());
        $product = $this->fractal->createData($product);

        return response()->json($product);
    }

    public function getById($productId){
        $product = $this->getProductService->getById($productId);
        $product = new Item($product, new ProductResponse());
        $product = $this->fractal->createData($product);

        return response()->json($product);
    }

    public function getPerPage(){
        $ProductPaginate = $this->getProductService->getPerPage();
        $ProductCollection = $ProductPaginate->getCollection();

        $ProductCollectionResource = new Collection($ProductCollection, new ProductResponse());
        
        $ProductCollectionResource->setPaginator(new IlluminatePaginatorAdapter($ProductPaginate));
        $Product = $this->fractal->createData($ProductCollectionResource);

        return response()->json($Product);
    }

    public function create(CreateProductRequest $request){
        $Product = $this->createProductService->create($request);
        $Product = new Item($Product, new ProductResponse());
        $Product = $this->fractal->createData($Product);

        return response()->json($Product);
    }

    public function update($productId, UpdateProductRequest $request){
        $Product = $this->updateProductService->update($productId, $request);
        $Product = new Item($Product, new ProductResponse());
        $Product = $this->fractal->createData($Product);

        return response()->json($Product);
    }

    public function delete($productId){
        $Product = $this->deleteProductService->delete($productId);
        $Product = new Item($Product, new ProductResponse());
        $Product = $this->fractal->createData($Product);

        return response()->json($Product);
    }
}
