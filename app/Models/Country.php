<?php
namespace App\Models;
use App\User;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model

{

    use SoftDeletes, Translatable;
    protected $table = 'countries';
    protected $guarded = [];
    public $translatedAttributes = ['name'];

}

