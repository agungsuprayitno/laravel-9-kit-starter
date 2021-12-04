<?php

namespace App\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenusModel extends Model
{
    use SoftDeletes;
    protected $table = 'menus';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'price',
        'status',
        'created_by',
        'modified_by',
        'deleted_at',
        'deleted_by'
    ];
}