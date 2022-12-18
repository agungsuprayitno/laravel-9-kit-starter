<?php

namespace App\Observers;

use App\Customers\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{

     /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the CustomerModel "created" event.
     *
     * @param  \App\Models\CustomerModel  $CustomerModel
     * @return void
     */
    public function created(Customer $customerModel)
    {
        return $customerModel->created_by = Auth::user()->id;
    }

    /**
     * Handle the CustomerModel "updated" event.
     *
     * @param  \App\Models\CustomerModel  $customerModel
     * @return void
     */
    public function updated(Customer $customerModel)
    {
        return $customerModel->updated_by = Auth::user()->id;
    }

    /**
     * Handle the CustomerModel "deleted" event.
     *
     * @param  \App\Models\CustomerModel  $customerModel
     * @return void
     */
    public function deleted(Customer $customerModel)
    {
        return $customerModel->deleted_by = Auth::user()->id;
    }

    /**
     * Handle the CustomerModel "forceDeleted" event.
     *
     * @param  \App\Models\CustomerModel  $customerModel
     * @return void
     */
    public function forceDeleted(Customer $customerModel)
    {
        return $customerModel->deleted_by = Auth::user()->id;
    }
}
