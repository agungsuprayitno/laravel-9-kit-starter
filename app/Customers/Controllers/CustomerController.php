<?php

namespace App\Customers\Controllers;

use App\Customers\Services\GetCustomerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Customers\Requests\CreateCustomerRequest;
use App\Customers\Requests\UpdateCustomerRequest;
use App\Customers\Responses\CustomerResponse;
use App\Customers\Services\CreateCustomerService;
use App\Customers\Services\DeleteCustomerService;
use App\Customers\Services\UpdateCustomerService;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CustomerController extends Controller
{
    public function __construct(
        protected Manager $fractal,
        protected GetCustomerService $getCustomerService,
        protected CreateCustomerService $createCustomerService,
        protected UpdateCustomerService $updateCustomerService,
        protected DeleteCustomerService $deleteCustomerService,
    ){}

    public function getall(){
        $customer = $this->getCustomerService->getAll();
        $customer = new Collection($customer, new CustomerResponse());
        $customer = $this->fractal->createData($customer);

        return response()->json($customer);
    }

    public function getPerPage(){
        $customerPaginate = $this->getCustomerService->getPerPage();
        $customerCollection = $customerPaginate->getCollection();

        $customerCollectionResource = new Collection($customerCollection, new CustomerResponse());
        
        $customerCollectionResource->setPaginator(new IlluminatePaginatorAdapter($customerPaginate));
        $customer = $this->fractal->createData($customerCollectionResource);

        return response()->json($customer);
    }

    public function getById($customerId){
        $customer = $this->getProductService->getById($customerId);
        $customer = new Item($customer, new CustomerResponse());
        $customer = $this->fractal->createData($customer);

        return response()->json($customer);
    }

    public function create(CreateCustomerRequest $request){
        $customer = $this->createCustomerService->create($request);
        $customer = new Item($customer, new CustomerResponse());
        $customer = $this->fractal->createData($customer);

        return response()->json($customer);
    }

    public function update($customerId, UpdateCustomerRequest $request){
        $customer = $this->updateCustomerService->update($customerId, $request);
        $customer = new Item($customer, new CustomerResponse());
        $customer = $this->fractal->createData($customer);

        return response()->json($customer);
    }

    public function delete($customerId){
        $customer = $this->deleteCustomerService->delete($customerId);
        $customer = new Item($customer, new CustomerResponse());
        $customer = $this->fractal->createData($customer);

        return response()->json($customer);
    }
}
