<?php
namespace App\customers\Services;

use App\customers\Repositories\CustomerRepository;
use App\customers\Requests\CreateCustomerRequest;

class CreatecustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository
    ){}

    public function create(CreateCustomerRequest $request){
        return $this->customerRepository->create($request);
    }
}