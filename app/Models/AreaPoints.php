<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AreaPoints extends Model
{
    use SoftDeletes ;
    protected $table = 'areas_points';
    protected $hidden = [ 'updated_at', 'deleted_at'];

}