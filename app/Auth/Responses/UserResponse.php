<?php

namespace App\Auth\Responses;

use App\Auth\Models\UsersModel;
use League\Fractal\TransformerAbstract;

class UserResponse extends TransformerAbstract
{
    public function transform(UsersModel $userModel) {
        return [
            'id' => $userModel->id,
            'name' => $userModel->name
        ];
    }
}
