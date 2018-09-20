<?php


namespace App;


//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use App\Category;


class Vehicle extends Model
{
	//protected $connection = 'mongodb';
	//protected $collection = 'books';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
	'user_id',
	'make_id', 
	'description'
    ];
	
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

	
	
    public function getCategory($id)
    {
	//return $this->categoryObject->getCategory($id);
	return Category::find($id);	
    }
	
	
    public function images()
    {
     return $this->hasMany('App\Image');
    }
	
    public function imagesFront()
    {	
        return $this->hasMany('App\Image')->orderBy('image_order')->limit(1);      
    }    
	
    public function imagesBack()
    {	
    return $this->hasMany('App\Image')->orderBy('image_order');		
    }
	
    public function make()
    {
    return $this->belongsTo('App\Make','make_id');
    }
	
	
	
    public function model()
    {
    return $this->belongsTo('App\Model','model_id');
    }	
	
	
	
	
	
	
	
	
	
}