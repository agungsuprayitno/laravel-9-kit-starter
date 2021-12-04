<?php

namespace App\Menu\Controllers;

use App\Menu\Services\GetMenuService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Menu\Requests\CreateMenuRequest;
use App\Menu\Requests\UpdateMenuRequest;
use App\Menu\Responses\MenuResponse;
use App\Menu\Services\CreateMenuService;
use App\Menu\Services\DeleteMenuService;
use App\Menu\Services\UpdateMenuService;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class MenuController extends Controller
{
    public function __construct(
        protected Manager $fractal,
        protected GetMenuService $getMenuService,
        protected CreateMenuService $createMenuService,
        protected UpdateMenuService $updateMenuService,
        protected DeleteMenuService $deleteMenuService,
    ){}

    public function getall(){
        $customer = $this->getMenuService->getAll();
        $customer = new Collection($customer, new MenuResponse());
        $customer = $this->fractal->createData($customer);

        return response()->json($customer);
    }

    public function getPerPage(){
        $menuPaginate = $this->getMenuService->getPerPage();
        $menuCollection = $menuPaginate->getCollection();

        $menuCollectionResource = new Collection($menuCollection, new MenuResponse());
        
        $menuCollectionResource->setPaginator(new IlluminatePaginatorAdapter($menuPaginate));
        $menu = $this->fractal->createData($menuCollectionResource);

        return response()->json($menu);
    }

    public function create(CreateMenuRequest $request){
        $menu = $this->createMenuService->create($request);
        $menu = new Item($menu, new MenuResponse());
        $menu = $this->fractal->createData($menu);

        return response()->json($menu);
    }

    public function update($menuId, UpdateMenuRequest $request){
        $menu = $this->updateMenuService->update($menuId, $request);
        $menu = new Item($menu, new MenuResponse());
        $menu = $this->fractal->createData($menu);

        return response()->json($menu);
    }

    public function delete($menuId){
        $menu = $this->deleteMenuService->delete($menuId);
        $menu = new Item($menu, new MenuResponse());
        $menu = $this->fractal->createData($menu);

        return response()->json($menu);
    }
}
