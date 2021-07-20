<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AayushProducts extends Model
{
    use SoftDeletes;
    
    protected $table = 'ayush_products';
    protected $fillable = [
							'id',
							'ayush_categories_id',
                            'product_name',
                            'product_description',
                            'key_ingredients',
                            'direction',
							'status',
							'created_at',
							'created_by',
							'updated_at',
                            'updated_by'
						];
    
    protected $hidden = ['_token'];
    
    protected $dates = ['deleted_at'];
	
    
    /*public function getSelect($is_select=false){
        //$select = Notification::orderBy('created_at','DESC');
        if($is_select){
            return $select;
        }
        return $select->get();
    }
    
    public function saveData($request,$data){
        $data->save();
    }*/
    
}