<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Area extends Model
{
    use SoftDeletes ;
    protected $table = 'areas';
    protected $with = ['points', 'employees'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function points()
    {
        return $this->hasMany(AreaPoints::class, 'area_id');
    }
    
    public function employees()
    {
        return $this->hasMany(AreaUsers::class, 'area_id');
    }
    

    
    


}