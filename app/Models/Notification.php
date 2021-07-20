<?php

namespace App\Models;

//use DB;
//use Validator;
//use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'general_notifications';
    protected $fillable = [
							'id',
							'notification_name',
							'notification_message',
							'created_by',
							'created_at'
						];
    protected $hidden = ['_token'];
	


    public function getSelect($is_select=false){
        //$select = Notification::orderBy('created_at','DESC');
        if($is_select){
            return $select;
        }
        return $select->get();
    }

    public function saveData($request,$data){
        //$data->status = $request->status;
        $data->save();
    }
    
}