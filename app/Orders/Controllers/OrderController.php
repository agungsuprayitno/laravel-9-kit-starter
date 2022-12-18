<?php

namespace App\Orders\Controllers;

use App\Orders\Services\GetOrderService;
use App\Http\Controllers\Controller;
use App\Orders\Requests\CreateOrderRequest;
use App\Orders\Requests\GetOrderByStatusRequest;
use App\Orders\Requests\UpdateOrderRequest;
use App\Orders\Responses\OrderResponse;
use App\Orders\Services\CreateOrderService;
use App\Orders\Services\DeleteOrderService;
use App\Orders\Services\UpdateOrderService;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class OrderController extends Controller
{
    public function __construct(
        protected Manager $fractal,
        protected GetOrderService $getOrderService,
        protected CreateOrderService $createOrderService,
        protected UpdateOrderService $updateOrderService,
        protected DeleteOrderService $deleteOrderService,
    ){}

    public function getAll(){
        $order = $this->getOrderService->getAll();
        $order = new Collection($order, new OrderResponse());
        $order = $this->fractal->createData($order);

        return response()->json($order);
    }

    public function getPerPage(){
        $orderPaginate = $this->getOrderService->getPerPage();
        $orderCollection = $orderPaginate->getCollection();

        $orderCollectionResource = new Collection($orderCollection, new OrderResponse());
        
        $orderCollectionResource->setPaginator(new IlluminatePaginatorAdapter($orderPaginate));
        $order = $this->fractal->createData($orderCollectionResource);

        return response()->json($order);
    }

    public function getByStatus(GetOrderByStatusRequest $request){
        $order = $this->getOrderService->getByStatus($request);
        $order = new Item($order, new OrderResponse());
        $order = $this->fractal->createData($order);
        $this->fractal->parseIncludes('orderDetails');

        return response()->json($order);
    }

    public function create(CreateOrderRequest $request){
        $order = $this->createOrderService->create($request);
        $order = new Item($order, new OrderResponse());
        $order = $this->fractal->createData($order);
        $this->fractal->parseIncludes('orderDetails');

        return response()->json($order);
    }

    public function update($orderId, UpdateOrderRequest $request){
        $order = $this->updateOrderService->update($orderId, $request);
        $order = new Item($order, new OrderResponse());
        $order = $this->fractal->createData($order);
        $this->fractal->parseIncludes('orderDetails');

        return response()->json($order);
    }

    public function delete($orderId){
        $order = $this->deleteOrderService->delete($orderId);
        $order = new Item($order, new OrderResponse());
        $order = $this->fractal->createData($order);

        return response()->json($order);
    }
}
