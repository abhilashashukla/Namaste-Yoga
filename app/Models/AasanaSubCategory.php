<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AasanaSubCategory extends Model
{
    use SoftDeletes;    
    public $table ='aasana_sub_categories';
    protected $fillable = ['aasana_categories_id','subcategory_name','subcategory_description','status','subcategory_image','updated_by'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
   
}
