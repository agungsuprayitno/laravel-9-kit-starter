<?php

namespace App\Menu\Responses;

use App\Menu\Models\MenusModel;
use League\Fractal\TransformerAbstract;

class MenuResponse extends TransformerAbstract
{
    public function transform(MenusModel $menuModel) {
        return [
            'id' => $menuModel->id,
            'name' => $menuModel->name,
            'type' => $menuModel->type,
            'status' => $menuModel->status
        ];
    }
}
