<?php


namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Category;

class Book extends Model
{
	//protected $connection = 'mongodb';
	//protected $collection = 'books';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'detail'
    ];
	
   

    public function category()
    {
	return $this->belongsTo('App\Category','category_id');
        //return $this->belongsTo('\App\Category','category_id','id');
        //return $this->belongsTo(Category::class,'category_id');
       
        
    }
	
	
    
	
}