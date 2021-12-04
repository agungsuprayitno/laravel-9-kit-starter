<?php
namespace App\Menu\Services;

use App\Menu\Repositories\MenuRepository;
use App\Menu\Requests\UpdateMenuRequest;

class UpdateMenuService
{
    public function __construct(
        protected MenuRepository $menuRepository
    ){}

    public function update(int $id, UpdateMenuRequest $request){
        return $this->menuRepository->update($id, $request);
    }
}