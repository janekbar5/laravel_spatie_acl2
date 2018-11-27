<?php

namespace App;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	
	//protected $connection = 'mongodb';
	//protected $collection = 'images';
	
	protected $table = 'tags';
	
    protected $fillable = [
	'name',
	
	];
	
	
	
	public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle','vehicle_tag','vehicle_id','tag_id');
    }
	
	
}
