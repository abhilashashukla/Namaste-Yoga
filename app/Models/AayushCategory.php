<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AayushCategory extends Model
{
    protected $table = 'ayush_categories';
    protected $fillable = [
							'id',
							'category_name',
							'status',
							'created_at',
							'updated_at',
                            'updated_by'
						];
    protected $hidden = ['_token'];
    
}