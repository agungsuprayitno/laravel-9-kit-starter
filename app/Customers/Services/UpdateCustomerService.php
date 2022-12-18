<?php
namespace App\Customers\Services;

use App\Customers\Repositories\CustomerRepository;
use App\Customers\Requests\UpdateCustomerRequest;

class UpdateCustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository
    ){}

    public function update(int $id, UpdateCustomerRequest $request){
        return $this->customerRepository->update($id, $request);
    }
}