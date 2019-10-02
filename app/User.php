<?php

namespace App;

use App\Models\Cart;
use App\Models\categoryUser;
use App\Models\Category;
use App\Models\City;
use App\Models\NotificationMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,SoftDeletes;

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'pivot'
    ];



    protected $fillable = ['name', 'email', 'mobile', 'password', 'status', 'type', 'image'];

    public function getImageAttribute($value)
    {
        if($value){
            return url('uploads/images/users/' . $value);
        }else{
            return url('uploads/images/users/defualtUser.jpg');
        }
    }

    public function getTypeAttribute($value)
    {
        return (string)$value;
    }

    public function getPhoneAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }

    public function getLatAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }

    public function getLanAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }

    public function getLocationAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }

    public function notification()
    {
        return $this->hasMany(NotificationMessage::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

}
