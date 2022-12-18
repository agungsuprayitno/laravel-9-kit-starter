<?php

namespace App\Carts\Controllers;

use App\Carts\Services\GetCartService;
use App\Http\Controllers\Controller;
use App\Carts\Requests\CreateCartRequest;
use App\Carts\Requests\UpdateCartRequest;
use App\Carts\Responses\CartResponse;
use App\Carts\Services\CreateCartService;
use App\Carts\Services\UpdateCartService;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CartController extends Controller
{
    public function __construct(
        protected Manager $fractal,
        protected GetCartService $getCartService,
        protected CreateCartService $createCartService,
        protected UpdateCartService $updateCartService,
    ){}

    public function getAll(){
        $cart = $this->getCartService->getAll();
        $cart = new Collection($cart, new CartResponse());
        $cart = $this->fractal->createData($cart);

        return response()->json($cart);
    }

    public function getPerPage(){
        $cartPaginate = $this->getCartService->getPerPage();
        $cartCollection = $cartPaginate->getCollection();

        $cartCollectionResource = new Collection($cartCollection, new CartResponse());
        
        $cartCollectionResource->setPaginator(new IlluminatePaginatorAdapter($cartPaginate));
        $cart = $this->fractal->createData($cartCollectionResource);

        return response()->json($cart);
    }

    public function create(CreateCartRequest $request){
        $cart = $this->createCartService->create($request);
        $cart = new Item($cart, new CartResponse());
        $cart = $this->fractal->createData($cart);
        $this->fractal->parseIncludes('cartDetails');

        return response()->json($cart);
    }

    public function update($cartId, UpdateCartRequest $request){
        $cart = $this->updateCartService->update($cartId, $request);
        $cart = new Item($cart, new CartResponse());
        $cart = $this->fractal->createData($cart);
        $this->fractal->parseIncludes('cartDetails');

        return response()->json($cart);
    }
}
