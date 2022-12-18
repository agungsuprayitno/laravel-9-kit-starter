<?php

namespace App\Observers;

use App\Products\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{

     /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the ProductModel "created" event.
     *
     * @param  \App\Models\ProductModel  $ProductModel
     * @return void
     */
    public function created(Product $productModel)
    {
        return $productModel->created_by = Auth::user()->id;
    }

    /**
     * Handle the ProductModel "updated" event.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return void
     */
    public function updated(Product $productModel)
    {
        return $productModel->updated_by = Auth::user()->id;
    }

    /**
     * Handle the ProductModel "deleted" event.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return void
     */
    public function deleted(Product $productModel)
    {
        return $productModel->deleted_by = Auth::user()->id;
    }

    /**
     * Handle the ProductModel "forceDeleted" event.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return void
     */
    public function forceDeleted(Product $productModel)
    {
        return $productModel->deleted_by = Auth::user()->id;
    }
}
