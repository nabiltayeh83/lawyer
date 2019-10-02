<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryTranslation extends Model
{
    use SoftDeletes;
    protected $table='country_translations';
    protected $fillable = ['name','country_id','locale'];
}
