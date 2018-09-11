<?php


namespace App;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Category extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'categories';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];
	
	public function categoryBelongsToBook()
    {
        return $this->belongsTo('App\Book','category_id');
    }
	
	
	
}