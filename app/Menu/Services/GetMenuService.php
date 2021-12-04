<?php
namespace App\Menu\Services;

use App\Menu\Repositories\MenuRepository;

class GetMenuService
{
    public function __construct(
        protected MenuRepository $menuRepository
    ){}

    public function getAll(){
        return $this->menuRepository->findAll();
    }

    public function getPerPage(){

        return $this->menuRepository->findPerPage();
    }

    public function getById($id){
        return $this->menuRepository->findById($id);
    }
}