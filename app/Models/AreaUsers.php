<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class AreaUsers extends Model
{
    use SoftDeletes ;
    protected $table = 'areas_users';
    protected $hidden = [ 'updated_at', 'deleted_at'];
    
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}