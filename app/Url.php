<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    //
    protected $table = 'urls';
    protected $primaryKey = 'id_url';
    protected $fillable=[
    	'url',
    	'short_code',
    	'hits',
    ];
}
