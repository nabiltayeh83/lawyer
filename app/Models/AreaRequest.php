<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AreaRequest extends Model
{
    use SoftDeletes ;
    protected $table = 'area_requests';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


}