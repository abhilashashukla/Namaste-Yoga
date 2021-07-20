<?php

namespace App\Models;
use DB;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class EventSubscriber extends Model
{
    protected $table = 'event_subscriber';
    protected $fillable = ['events_id',
    'users_id'
];
    protected $hidden = ['_token'];


}
