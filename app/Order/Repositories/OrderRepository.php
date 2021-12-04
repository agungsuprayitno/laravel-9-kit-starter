<?php
namespace App\Order\Repositories;

use App\Menu\Models\MenusModel;
use App\Order\Exceptions\OrderCannotBeDeletedException;
use App\Order\Exceptions\OrderNotFoundException;
use App\Order\Models\OrdersModel;
use App\Order\OrderDetail\Models\OrderDetailsModel;
use App\Order\Requests\CreateOrderRequest;
use App\Order\Requests\GetOrderByStatusRequest;
use App\Order\Requests\UpdateOrderRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderRepository
{

    public function __construct(
        protected $ACTIVE_STATUS = 'ACTIVE',
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

    public function findById(int $id) {
        try{
            return $this->defaultElo()->where('id', $id)->firstOrFail();
        } catch(ModelNotFoundException $exception) {
            throw new OrderNotFoundException();
        }
    }

    public function findByStatus(GetOrderByStatusRequest $request) {
        return $this->defaultElo()->where('status', $request->status)->get();
    }

    static function autoNumber($str, $model, $column, $count = 1){
        $code = $str.date('Ymd');
        $queryModel = $model->where($column, 'like', $code.'%')->orderBy($column, 'DESC')->first();
        $existNumber = $queryModel ? $queryModel->$column : '';
        $explode = $existNumber ? explode('-', $existNumber) : 0;
        $number = $explode != 0 ?  (int)$explode[1] + $count : $explode + $count;
        $strPad = str_pad($number,3,0, STR_PAD_LEFT);
        $autoNumber = $code.'-'.$strPad;

        return $autoNumber;
    }

    public function create(CreateOrderRequest $request){

        $items = MenusModel::whereIn('id', $request->items)->get();
        $itemsGroup = [];
        return DB::transaction(function () use ($items, $itemsGroup) {
            $orderAmount = 0;
            foreach($items as $item) {
                $orderAmount += $item->price;
            }

            $orderModel = OrdersModel::create([
                'order_no' => $this->autoNumber('PSN', $this->ordersModel, 'order_no'),
                'order_date' => date('Y-m-d H:i:s'),
                'amount' => $orderAmount,
                'status' => $this->ACTIVE_STATUS,
                'created_by' => Auth::user()->id
            ]);
            
            foreach($items as $item) {
                $itemsGroup[] = [
                    'menu_id' => $item->id,
                    'order_id' => $orderModel->id,
                    'created_by' => auth()->user()->id
                ];
            }

            $this->orderDetailsModel->upsert($itemsGroup, ['id']);
            
            return $orderModel;
        });

    }

    public function update(int $id, UpdateOrderRequest $request){
        $orderModel = $this->findById($id);
        
        return DB::transaction(function () use ($orderModel, $request) {
            $this->orderDetailsModel->where('order_id')->delete();

            $items = MenusModel::whereIn('id', $request->items)->get();
            $itemsGroup = [];
            $input = [];
            $orderAmount = 0;
            foreach($items as $item) {
                $orderAmount += $item->price;
                $itemsGroup[] = [
                    'menu_id' => $item->id,
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