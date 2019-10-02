<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslation extends Model
{
    use SoftDeletes;
    protected $table='category_translations';
    protected $fillable = ['name','category_id','locale'];
}
