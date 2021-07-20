<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Config;


class SocialMedia extends Model
{
    use SoftDeletes;    
    protected $fillable = ['organization_name','org_facebook','org_twitter','org_instagram', 'org_youtube', 'org_other','status','updated_by'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    
    public static function GetSocialMediaData()
    {
        $socialmedia=SocialMedia::where('status','1')->orderBy('id','desc')->paginate(Config::get('app.social_media_record_per_page'));
        return $socialmedia;
        
    }
}
