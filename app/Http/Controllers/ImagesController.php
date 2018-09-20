<?php

namespace App\Http\Controllers;

use App\Image;
use App\Book;
use Illuminate\Http\Request;
//for validation
use Illuminate\Support\Facades\Validator;
//for logged user
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Input;

//use Intervention\Image\Facades\Image;
//use App\Logic\User\UserRepository;
//images
use Intervention\Image\Facades\Image as Foto;

use File; //required to add/delete files
use DB;
//use Cache;
//use DB;
class ImagesController extends Controller
{
   //private $loopcount=0;
    
	public function __construct()
        {

                    //$this->user_id  = Auth::user()->id;
                    //$this->user_id = Auth::user()->name;

        }
	
	public function viewImagesList(Request $request)
	{
	//$galleries=Gallery::all();
	$images=Image::where('created_by',Auth::user()->id)->get();	
	return view('images.images')
	->with('images',$images);
	}
	
	//delete single img
    public function getImageDelete($id)
    {        
	$gallery_image = Image::find($id);
        $gallery_image_ok = $gallery_image->file_name;
		
		unlink(public_path('gallery/images/thumbs_240/'.$gallery_image_ok));
		unlink(public_path('gallery/images/thumbs_340/'.$gallery_image_ok));
		unlink(public_path('gallery/images/thumbs_1024/'.$gallery_image_ok));
        //from DB		
        $gallery_image->delete();
        
         				
		
    }
	
	
	//delete images on vehicle delete
	public function deleteImageswithVehicle($id)
	{	
	
		$images = Image::where('vehicle_id', '=', $id)->get();	
		
		foreach($images as $image) {			
			unlink(public_path('gallery/images/thumbs_240/'.$image->file_name));
			unlink(public_path('gallery/images/thumbs_340/'.$image->file_name));
			unlink(public_path('gallery/images/thumbs_1024/'.$image->file_name));
		}	

	}
	
	
		
	public function changeImageOrder(Request $request)
	{
			
                        //$string = Input::get('order');
                        //dd($string);
                        
                        $images = Image::orderBy('image_order','asc')->get();
			$string = Input::get('order');
			array($string);   
			$string = trim($string, ".");    
			$split = explode(",", $string);
			$count = 1;		
			foreach($split as $value) //loop over values
			{	    
			     $count ++;                            
                             $image = Image::find($value);
                             $image->image_order = $count;
                             $image->update();
				
			}                         
                         
	
	}
	
	////////////////////////////////////////////////////////////////////////////////////Upload image
	
	public function postImageUpload(Request $request)
	{
		
                //$loopcount=0;
		// 1 get file from post
		$file = $request->file('file');				
		$filename = Auth::user()->id.'-'.$request->input('vehicle_id').'-'.uniqid().'.'.$file->guessExtension();			
		$file->move('gallery/images/tobin',$filename);
		
		/////////////////////////////////////////////////////////Generate thumb1024
		$thumb = Foto::make('gallery/images/tobin/' . $filename)		
		->resize(1024, 683, function ($constraint) {
            $constraint->aspectRatio();
        })
		->resizeCanvas(1024, 683, 'center', false, array(255, 255, 255, 0))		
		->save('gallery/images/thumbs_1024/' . $filename,80);
		/////////////////////////////////////////////////////////
		
		/////////////////////////////////////////////////////////Generate thumb340
		$thumb = Foto::make('gallery/images/tobin/' . $filename)		
		->resize(340, 260, function ($constraint) {
            $constraint->aspectRatio();
        })
		->resizeCanvas(340, 260, 'center', false, array(255, 255, 255, 0))	
		
		->save('gallery/images/thumbs_340/' . $filename,60);

		/////////////////////////////////////////////////////////Generate thumb240
		$thumb = Foto::make('gallery/images/tobin/' . $filename)		
		->resize(240, 160, function ($constraint) {
            $constraint->aspectRatio();
        })
		->resizeCanvas(240, 160, 'center', false, array(255, 255, 255, 0))	
		
		->save('gallery/images/thumbs_240/' . $filename,60);
		/////////////////////////////////////////////////////////
		
		$gallery = Book::find($request->input('book_id'));
		///////   fill DB fields refer to method imagesFront() in Gallery model
		
		
                
                 
                 
        $image = Image::create([
		'book_id' => $request->input('book_id'),
		'file_name' => $filename,
		'file_size' => '777',
		'file_mime' => $file->getClientMimeType(),
		'file_path' => 'gallery/images/'.$filename,
		'created_by' => Auth::user()->id,
		'image_order' => 2,
		]);
                /*
                $foto = new Foto();
                $foto->book_id = $request->input('book_id');
		$foto->file_name = $filename;
		$foto->file_size = '777';
		$foto->file_mime = $file->getClientMimeType();
		$foto->file_path = 'gallery/images/'.$filename;
		$foto->created_by = Auth::user()->id;
                $foto->save();  
                 */
                   
                        
                        
		return $image;
		
	}
	
	
	
	

	
	
}
