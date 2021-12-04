<?php

namespace App\Observers;

use App\Menu\Models\MenusModel;
use Illuminate\Support\Facades\Auth;

class MenuObserver
{

     /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the MenuModel "created" event.
     *
     * @param  \App\Models\MenuModel  $MenuModel
     * @return void
     */
    public function created(MenusModel $menuModel)
    {
        return $menuModel->created_by = Auth::user()->id;
    }

    /**
     * Handle the MenuModel "updated" event.
     *
     * @param  \App\Models\MenuModel  $menuModel
     * @return void
     */
    public function updated(MenusModel $menuModel)
    {
        return $menuModel->updated_by = Auth::user()->id;
    }

    /**
     * Handle the MenuModel "deleted" event.
     *
     * @param  \App\Models\MenuModel  $menuModel
     * @return void
     */
    public function deleted(MenusModel $menuModel)
    {
        return $menuModel->deleted_by = Auth::user()->id;
    }

    /**
     * Handle the MenuModel "forceDeleted" event.
     *
     * @param  \App\Models\MenuModel  $menuModel
     * @return void
     */
    public function forceDeleted(MenusModel $menuModel)
    {
        return $menuModel->deleted_by = Auth::user()->id;
    }
}
