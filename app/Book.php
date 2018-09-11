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
        'name', 'detail'
    ];
	
	public function bookHasCategory()
    {
        return $this->hasMany('App\Category');
    }

	
	
	public function getCategory($id)
    {
		//return $this->categoryObject->getCategory($id);
		return Category::find($id);	
	}
	
}