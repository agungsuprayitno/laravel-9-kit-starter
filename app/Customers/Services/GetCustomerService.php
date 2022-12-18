<?php
namespace App\Customers\Services;

use App\Customers\Repositories\CustomerRepository;

class GetCustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository
    ){}

    public function getAll(){
        return $this->customerRepository->findAll();
    }

    public function getPerPage(){

        return $this->customerRepository->findPerPage();
    }

    public function getById($id){
        return $this->customerRepository->findById($id);
    }
}