<?php

namespace App\Products\Responses;

use App\Products\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductResponse extends TransformerAbstract
{
    public function transform(Product $productModel) {
        return [
            'id' => $productModel->id,
            'name' => $productModel->name,
            'type' => $productModel->type,
            'status' => $productModel->status
        ];
    }
}
