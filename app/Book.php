<?php


namespace App;


//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
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
        'name','category_id', 'detail'
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
      
        
        //dd($janek);
        //echo $janek->_id;
        /*
        if($this->hasMany('App\Image')->exists()){
            $img = $this->hasMany('App\Image')->orderBy('image_order')->limit(1);
            $photo = '<img src="'.$img->file_path.'" style="width:100px"/>';
        }else{
            $photo = '<img src="http://placehold.it/50x50" width="100"/>';
        }
       echo $photo; 
         * 
         * 
         */  
        /*
        if (is_object($record->poster)) {
            //echo 'object';
                    $photo = $this->hasMany('App\Image')->orderBy('image_order')->limit(1);
        }else{
                    $photo = 'http://placehold.it/50x50';
        }
         * */
         
    }    
	
    public function imagesBack()
    {	
    return $this->hasMany('App\Image')->orderBy('image_order');		
    }
	
	
	
	
	
	
	
	
	
	
	
}