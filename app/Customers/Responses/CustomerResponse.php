<?php

namespace App\Customers\Responses;

use App\Customers\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerResponse extends TransformerAbstract
{
    public function transform(Customer $customerModel) {
        return [
            'id' => $customerModel->id,
            'name' => $customerModel->name,
            'type' => $customerModel->type,
            'status' => $customerModel->status
        ];
    }
}
