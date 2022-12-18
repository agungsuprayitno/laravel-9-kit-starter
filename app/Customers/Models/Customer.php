<?php

namespace App\Customers\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    
    use SoftDeletes, HasFactory, UUID;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $incrementing=false;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'status',
        'created_by',
        'modified_by',
        'deleted_at',
        'deleted_by'
    ];
}