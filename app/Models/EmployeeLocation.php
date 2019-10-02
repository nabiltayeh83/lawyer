<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployeeLocation extends Model
{
    use SoftDeletes ;
    protected $table = 'employee_locations';
    protected $hidden = ['updated_at', 'deleted_at'];


}