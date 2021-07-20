<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aasana extends Model
{
    use SoftDeletes;    
    public $table ='aasanas';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $fillable = ['aasana_categories_id','aasana_sub_categories_id','aasana_name','aasana_description','assana_tag','assana_video_id','assana_video_duration','assana_benifits','assana_instruction','status','updated_by'];
    protected $dates = ['deleted_at'];
}
