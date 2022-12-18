<?php
namespace App\Customers\Services;

use App\Customers\Repositories\CustomerRepository;

class DeleteCustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository
    ){}

    public function delete($id){
        return $this->customerRepository->delete($id);
    }
}