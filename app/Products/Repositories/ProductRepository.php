<?php
namespace App\Products\Repositories;

use App\Products\Exceptions\ProductCannotBeDeletedException;
use App\Products\Exceptions\ProductNotFoundException;
use App\Products\Models\Product;
use App\Products\Requests\CreateProductRequest;
use App\Products\Requests\UpdateProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductRepository
{
    protected $ACTIVE_STATUS = 'ACTIVE';

    public function __construct(
        protected Product $productsModel
    ){}
    protected function defaultElo() {
        return $this->productsModel->where('created_at', '!=', null);
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
            throw new ProductNotFoundException();
        }
    }

    public function create(CreateProductRequest $request){

        $productModel = Product::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $this->ACTIVE_STATUS,
            'created_by' => Auth::user()->id
        ]);
        return $productModel;
    }

    public function update(int $id, UpdateProductRequest $request){
        $productModel = $this->findById($id);
        $input = [];
        if($request->name !== null)
            $input['name'] = $request->name;

        if($request->status !== null)
            $input['status'] = Str::upper($request->status);

        
        $input['modified_by'] = Auth::user()->id;

        $productModel->update($input);
        return $productModel;
    }

    public function delete(int $id){
        $productModel = $this->findById($id);
        $productModel->deleted_by = Auth::user()->id;
        try {
            $productModel->delete();
            return $productModel;
        } catch (QueryException $exception) {
            throw new ProductCannotBeDeletedException();
        }
    }
}