<?php
namespace App\Carts\Repositories;

use App\Carts\Exceptions\CartNotFoundException;
use App\Carts\Models\CartsModel;
use App\Carts\CartDetail\Models\CartDetailsModel;
use App\Carts\Exceptions\CartCannotBeDeletedException;
use App\Carts\Requests\CreateCartRequest;
use App\Carts\Requests\UpdateCartRequest;
use App\Customers\Models\Customer;
use App\Products\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartRepository
{
    public function __construct(
        protected CartsModel $cartsModel,
        protected CartDetailsModel $cartDetailsModel,
    ){}
    protected function defaultElo() {
        return $this->cartsModel->where('created_by', Auth::user()->id);
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
            throw new CartNotFoundException();
        }
    }

    public function create(CreateCartRequest $request){

        $items = Product::whereIn('id', $request->items)->get();
        $customer = Customer::where('id', $request->customer_id)->firstOrFail();
        $cart = CartsModel::where('customer_id', $request->customer_id)->first();
        
        return DB::transaction(function () use ($items ,$customer, $cart) {
            $cartAmount = 0;
            $cartModel = $cart;
            $cartDetails = collect([]);
            foreach($items as $item) {
                $cartAmount += $item->price;
            }
            if($cart == null) {
                $cartModel = CartsModel::create([
                    'customer_id' => $customer->id,
                    'amount' => $cartAmount,
                    'created_by' => Auth::user()->id
                ]);
            }
            else {
                $cartDetails = CartDetailsModel::where('cart_id', $cart->id)->get();
            }
            
            foreach($items as $item) {
                $qty = 1;
                $itemExist = $cartDetails->firstWhere('product_id', $item->id);
               
                if($itemExist !== null) {
                    CartDetailsModel::where('product_id', $item->id)
                    ->where('cart_id', $cartModel->id)
                    ->update(['qty' => $itemExist->qty + 1]);
                }else {
                    CartDetailsModel::create([
                        'id' => Str::uuid()->toString(),
                        'product_id' => $item->id,
                        'qty' => $qty,
                        'cart_id' => $cartModel->id,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
            
            return $cartModel;
        });

    }

    public function update(string $id, UpdateCartRequest $request){
        $cart = $this->findById($id);
        
        return DB::transaction(function () use ($cart, $request) {
            try{
                $cartDetail = CartDetailsModel::where(['product_id' => $request->item_id, 'cart_id' => $cart->id])->firstOrFail();
            } catch(ModelNotFoundException $exception) {
                throw new CartNotFoundException();
            }
            $cartAmount = 0;
            $items = CartDetailsModel::where('cart_id', $cart->id)->get();
            foreach($items as $item) {
                if($cartDetail->product_id == $item->product_id) {
                    $price = $item->product->price * $request->qty;
                } else {
                    $price = $item->product->price * $item->qty;
                }
                $cartAmount += $price;
            }
            
            $input['amount'] = $cartAmount;
            $input['modified_by'] = Auth::user()->id;
            $cart->update($input);

            $cartDetail->qty = $request->qty;
            $cartDetail->save();
            
            return $cart;
        });
    }

    public function delete(int $id){
        $cartModel = $this->findById($id);
        $cartModel->deleted_by = Auth::user()->id;
        try {
            $cartModel->delete();
            return $cartModel;
        } catch (QueryException $exception) {
            throw new CartCannotBeDeletedException();
        }
    }
}