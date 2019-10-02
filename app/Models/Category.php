<?php
namespace App\Models;
use App\User;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model

{

    use SoftDeletes, Translatable;
    protected $table = 'categories';
    protected $guarded = [];
    public $translatedAttributes = ['name'];

}

