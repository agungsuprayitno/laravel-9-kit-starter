<?php
namespace App\Menu\Repositories;

use App\Menu\Exceptions\MenuCannotBeDeletedException;
use App\Menu\Exceptions\MenuNotFoundException;
use App\Menu\Models\MenusModel;
use App\Menu\Requests\CreateMenuRequest;
use App\Menu\Requests\UpdateMenuRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MenuRepository
{

    public function __construct(
        protected $READY_STATUS = 'READY',
        protected MenusModel $menusModel
    ){}
    protected function defaultElo() {
        return $this->menusModel->where('created_at', '!=', null);
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
            throw new MenuNotFoundException();
        }
    }

    public function create(CreateMenuRequest $request){

        $menuModel = MenusModel::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $this->READY_STATUS,
            'created_by' => Auth::user()->id
        ]);
        return $menuModel;
    }

    public function update(int $id, UpdateMenuRequest $request){
        $menuModel = $this->findById($id);
        $input = [];
        if($request->name !== null)
            $input['name'] = $request->name;

        if($request->status !== null)
            $input['status'] = Str::upper($request->status);

        
        $input['modified_by'] = Auth::user()->id;

        $menuModel->update($input);
        return $menuModel;
    }

    public function delete(int $id){
        $menuModel = $this->findById($id);
        $menuModel->deleted_by = Auth::user()->id;
        try {
            $menuModel->delete();
            return $menuModel;
        } catch (QueryException $exception) {
            throw new MenuCannotBeDeletedException();
        }
    }
}