<?php

namespace App\Http\Controllers;

//use App\Models\Model;
//use App\Models\Vehicle;
use Illuminate\Http\Request;
//for validation
use Illuminate\Support\Facades\Validator;
//for logged user
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Input;

//use Intervention\Image\Facades\Image;

//use File; //required to add/delete files
use DB;
//use Cache;
//use DB;
class ModelsController extends Controller
{
   
    
	public function __construct()
        {
            $this->middleware('auth');
            
        }

	public function getModels()
	{		
	
        
        $make_id = Input::get('make_id');
	$level2 = \DB::table('models')->where('make_id','=',$make_id)->get();
        $return = '<select name="make_id" id="make_id" class="form-control">';
	$return .= '<option value="">Choose Model</option>';			
	foreach($level2 as $temp)
	$return .= "<option value='$temp->id'>$temp->name</option>";
        $return .= "</select>";
	return $return;
       
	}
	
	
	
	
	
	

	
	
}
