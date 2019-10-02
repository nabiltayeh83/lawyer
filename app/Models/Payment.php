<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $table = 'payment_methods';
    protected $fillable = ['title', 'logo', 'status'];


    public function getLogoAttribute($value){

    	if($value){
    		return url($value);
    	}else{
    		return "";
    	}
    }



    public function selected_payment(){

        return $this->hasOne(PaymentCompanies::class, 'payment_id');
    }


    




}
