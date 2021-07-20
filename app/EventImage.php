<?php

namespace App;
use DB;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    protected $table = 'event_image';
    protected $fillable = ['events_id','image'];
    protected $hidden = ['_token'];
	
	
	public static function getImages($events_id)
	{
		
		return EventImage::where('events_id',$events_id)->first();
	}
 
	


}
