<?php

namespace App\Http\Controllers;

use App\Modell;
use Illuminate\Support\Facades\Input;
use DB;


class ModelsController extends Controller
{
   
    
	
	public function getModelsAjax()
	{		
	//dd('uuuuuu');        
        $make_id = Input::get('make_id');
	$level2 = DB::table('models')->where('make_id','=',$make_id)->get();
        //dd($level2);
        $return = '<select name="make_id" id="make_id" class="form-control">';
	$return .= '<option value="">Choose Model</option>';			
	foreach($level2 as $temp){
	$return .= "<option value='$temp->id'>$temp->title</option>";
        }
        $return .= "</select>";
	return $return;
       
	}
	
        public function getMakeModels($id)
        {
        return $makes = Modell::where('make_id','=',$id)->get();	
        }
	public function getAllModels()
        {
        return $makes = Modell::all();	
        }
	
	
	
	

	
	
}
