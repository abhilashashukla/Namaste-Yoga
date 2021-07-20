<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class CelebrityTestimonial extends Model
{
    use SoftDeletes;    
    public $table ='celebrity_testimonial';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $fillable = ['name','video_id','status','updated_by'];
    protected $dates = ['deleted_at'];
	
	
    public static function GetAllTestimonials()
    {
        $celebritytestimonial=CelebrityTestimonial::orderBy('id','desc')->paginate(Config::get('app.celebrity_testimonial_record_per_page'));
        return $celebritytestimonial;
        
    }
}
