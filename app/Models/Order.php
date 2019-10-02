<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use SoftDeletes ;
    protected $table = 'orders';
    protected $hidden = ['updated_at', 'deleted_at'];
    protected $with = ['promotion_code','car'];

    public function promotion_code()
    {
        return $this->belongsTo(PromotionCode::class,'promotion_code_id');
    }

    public function getImageBeforeAttribute($value)
    {
        if ($value != null){
            return url('uploads/images/before/' . $value);
        }
    }

    public function getImageAfterAttribute($value)
    {
        if ($value != null) {
            return url('uploads/images/after/' . $value);
        }
    }

    public function car()
    {
        return $this->belongsTo(Car::class,'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }







}