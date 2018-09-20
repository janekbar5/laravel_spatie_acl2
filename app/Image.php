<?php

namespace App;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	
	//protected $connection = 'mongodb';
	//protected $collection = 'images';
	
	protected $table = 'images';
	
    protected $fillable = [
	'book_id',
	'file_name',
	'file_size',
	'file_mime',
	'file_path',
	'created_by',
	'image_order',
	];
	
	
	
	public function gallery()
	{
	return $this->belongsTo('App\Book');
	}
	
	
}
