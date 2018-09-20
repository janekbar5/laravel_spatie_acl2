<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vehicle extends Model {
    
	//protected $table = 'vehicles';
	
	protected $fillable = [
	'name',
	'make_id',
	'model_id',
	'colour_id',
	'description',
	'token',
	'price',
	'manufactured_year',
	//////
	'fuel_type_id',
	'body_type_id',
	'registration',
	'reg_code',
	'attention_grabber',
	'engine_size',	
	'mileage',
	'mileage_unit',
	'transmission',
];	










	
	
	public function imagesFront()
	{	
	return $this->hasMany('App\Models\Images')->orderBy('image_order')->limit(1);			
	}
	
	
	public function imagesFront2()
	{	
	//return $this->hasMany('App\Models\Image')->orderBy('image_order')->limit(1);
	return $this->hasMany('App\Models\Images')->limit(1);	
	}
	
	
	
	public function imagesGallery()
	{	
	//return $this->hasMany('App\Models\Image')->orderBy('image_order')->limit(1);
	return $this->hasMany('App\Models\Images')->orderBy('image_order');	
	}
	
	
	
	public function imagesBack()
	{	
	return $this->hasMany('App\Models\Images')->orderBy('image_order');		
	}
	
	
	public function makeRelation()
	{
		return $this->belongsTo('App\Models\VehicleMake','make_id');
	}
	
	
	
	public function modelRelation()
	{
		return $this->belongsTo('App\Models\VehicleModel','model_id');
	}
	
	public function userRelation()
	{
		return $this->belongsTo('App\Models\User','user_id');
	}
	
	public function profileRelation()
	{
		//return $this->belongsToMany('App\Models\Profile','user_id');
		return $this->hasOne('App\Models\Profile','user_id','user_id');
	}
	
	
	public function tags()
    {
    	return $this->belongsToMany('App\Models\Tag');
    }
	
	
	
	public function enginsizes()
    {
    	return $this->belongsToMany('App\Models\EnginSize');
    }
	
	
	public function reviews()
    {
    	return $this->belongsToMany('App\Models\Review');
    }
	
	
	
	public function hasBodyTypes()
	{
		return $this->belongsTo('App\Models\BodyType','body_type_id');
	}
	
	
	
	public function profileLat()
	{

		//return $posts = $this->all()->take(2)->get();
		//return $lat = $this->hasOne('App\Models\Profile','user_id','user_id')->lat;
		//return 'eee';

	}
	
}