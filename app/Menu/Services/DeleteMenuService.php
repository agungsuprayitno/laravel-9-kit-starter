<?php
namespace App\Menu\Services;

use App\Menu\Repositories\MenuRepository;

class DeleteMenuService
{
    public function __construct(
        protected MenuRepository $menuRepository
    ){}

    public function delete($id){
        return $this->menuRepository->delete($id);
    }
}