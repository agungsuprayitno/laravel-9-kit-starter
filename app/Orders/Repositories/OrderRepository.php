<?php
namespace App\Orders\Repositories;

use App\Carts\CartDetail\Models\CartDetailsModel;
use App\Carts\Models\CartsModel;
use App\Orders\Exceptions\OrderCannotBeDeletedException;
use App\Orders\Exceptions\OrderItemEmptyException;
use App\Orders\Exceptions\OrderNotFoundException;
use App\Orders\Models\OrdersModel;
use App\Orders\OrderDetail\Models\OrderDetailsModel;
use App\Orders\Requests\CreateOrderRequest;
use App\Orders\Requests\GetOrderByStatusRequest;
use App\Orders\Requests\UpdateOrderRequest;
use App\Products\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderRepository
{
    protected $ACTIVE_STATUS = 'ACTIVE';

    public function __construct(
        protected OrdersModel $ordersModel,
        protected OrderDetailsModel $orderDetailsModel,
    ){}
    protected function defaultElo() {
        return $this->ordersModel->where('created_by', Auth::user()->id);
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
            throw new OrderNotFoundException();
        }
    }

    public function findByStatus(GetOrderByStatusRequest $request) {
        return $this->defaultElo()->where('status', $request->status)->get();
    }

    static function autoNumber($str, $model, $count = 1){
        $code = $str.date('Ymd');
        $countModel = $model->count();
        $number = $countModel + $count;
        $strPad = str_pad($number,3,0, STR_PAD_LEFT);
        $autoNumber = $code.'-'.$strPad;

        return $autoNumber;
    }

    public function create(CreateOrderRequest $request){
        $cart = CartsModel::where('id', $request->cart_id)->firstOrFail();
        $items = CartDetailsModel::whereIn('product_id', $request->items)->get();
        $itemsGroup = [];

        if(count($items) == 0) throw new OrderItemEmptyException();

        return DB::transaction(function () use ($items, $itemsGroup, $cart, $request) {
            $orderAmount = 0;
            foreach($items as $item) {
                $orderAmount += $item->product->price;
            }

            $orderModel = OrdersModel::create([
                'order_no' => $this->autoNumber('ORDER', $this->ordersModel),
                'order_date' => date('Y-m-d H:i:s'),
                'amount' => $orderAmount,
                'customer_id' => $cart->customer_id,
                'status' => $this->ACTIVE_STATUS,
                'created_by' => Auth::user()->id
            ]);
            
            foreach($items as $item) {
                for($i = 1; $i <= $item->qty; $i ++) {
                    $itemsGroup[] = [
                        'id' => Str::uuid()->toString(),
                        'order_id' => $orderModel->id,
                        'product_id' => $item->product_id,
                        'created_by' => auth()->user()->id
                    ];
                }
            }

            $this->orderDetailsModel->upsert($itemsGroup, ['id']);

            //  Delete Cart Detail items when order created
            CartDetailsModel::where('id', $request->cart_id)->whereIn('product_id', $request->items)->delete();
            
            return $orderModel;
        });

    }

    public function update(int $id, UpdateOrderRequest $request){
        $orderModel = $this->findById($id);
        
        return DB::transaction(function () use ($orderModel, $request) {
            $this->orderDetailsModel->where('order_id')->delete();

            $items = Product::whereIn('id', $request->items)->get();
            $itemsGroup = [];
            $input = [];
            $orderAmount = 0;
            foreach($items as $item) {
                $orderAmount += $item->price;
                $itemsGroup[] = [
                    'product_id' => $item->id,
                    'order_id' => $orderModel->id,
                    'created_by' => auth()->user()->id
                ];
            }

            if($request->status !== null)
                $input['status'] = $request->status;
            
            $input['amount'] = $orderAmount;
            $input['modified_by'] = Auth::user()->id;
            $orderModel->update($input);

            $this->orderDetailsModel->upsert($itemsGroup, ['id']);
            
            return $orderModel;
        });
    }

    public function delete(int $id){
        $orderModel = $this->findById($id);
        $orderModel->deleted_by = Auth::user()->id;
        try {
            $orderModel->delete();
            return $orderModel;
        } catch (QueryException $exception) {
            throw new OrderCannotBeDeletedException();
        }
    }
}