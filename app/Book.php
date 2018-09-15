<?php


namespace App;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Category;

class Book extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'books';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','category_id', 'detail'
    ];
	
    public function category()
    {
        //return $this->hasMany('App\Category');
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
	return $this->hasMany('App\Images')->orderBy('image_order')->limit(1);			
	}    
	
	
	
	
	
	
	
	
	
	
	
	
	
}