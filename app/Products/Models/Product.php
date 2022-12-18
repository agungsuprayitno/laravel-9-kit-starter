<?php

namespace App\Products\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    
    use SoftDeletes, HasFactory, UUID;
    protected $table = 'products';
    protected $primaryKey = 'id';

    public $incrementing=false;

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