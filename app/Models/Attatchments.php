<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attatchments extends Model
{
    protected $fillable = ['image'];
    


     public function Product()
    {
        return $this->belongsTo(Product::class);
    }


     public function getImageAttribute($value)
    {

    	if($value  && file_exists( public_path().'/uploads/products/' . $value)){
    		return url('uploads/products/'.$value);
    	}else{
            return url('uploads/basit.jpg');
    	}
    }

     






}
