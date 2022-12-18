<?php
namespace App\Customers\Repositories;

use App\Customers\Exceptions\CustomerCannotBeDeletedException;
use App\Customers\Exceptions\CustomerNotFoundException;
use App\Customers\Models\Customer;
use App\Customers\Requests\CreateCustomerRequest;
use App\Customers\Requests\UpdateCustomerRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerRepository
{

    public function __construct(
        protected $READY_STATUS = 'READY',
        protected Customer $customersModel
    ){}
    protected function defaultElo() {
        return $this->customersModel->where('created_at', '!=', null);
    }

    public function findAll(){
        return $this->defaultElo()->get();
    }

    public function findPerPage() {
        return $this->defaultElo()->paginate(25);
    }

    public function findById(string $id) {
        try{
            return $this->defaultElo()->where('id', $id)->firstOrFail();
        } catch(ModelNotFoundException $exception) {
            throw new CustomerNotFoundException();
        }
    }

    public function create(CreateCustomerRequest $request){

        $customerModel = Customer::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $this->READY_STATUS,
            'created_by' => Auth::user()->id
        ]);
        return $customerModel;
    }

    public function update(int $id, UpdateCustomerRequest $request){
        $customerModel = $this->findById($id);
        $input = [];
        if($request->name !== null)
            $input['name'] = $request->name;

        if($request->status !== null)
            $input['status'] = Str::upper($request->status);

        
        $input['modified_by'] = Auth::user()->id;

        $customerModel->update($input);
        return $customerModel;
    }

    public function delete(int $id){
        $customerModel = $this->findById($id);
        $customerModel->deleted_by = Auth::user()->id;
        try {
            $customerModel->delete();
            return $customerModel;
        } catch (QueryException $exception) {
            throw new CustomerCannotBeDeletedException();
        }
    }
}