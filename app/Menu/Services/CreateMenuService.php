<?php
namespace App\Menu\Services;

use App\Menu\Repositories\MenuRepository;
use App\Menu\Requests\CreateMenuRequest;

class CreateMenuService
{
    public function __construct(
        protected MenuRepository $menuRepository
    ){}

    public function create(CreateMenuRequest $request){
        return $this->menuRepository->create($request);
    }
}