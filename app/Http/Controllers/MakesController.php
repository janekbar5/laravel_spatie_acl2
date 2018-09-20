<?php

namespace App\Http\Controllers;

use App\Make;

class MakesController extends Controller
{
   
    	public function getMakes()
	{
	return $makes = Make::all();	
	}
	
	
	
	
}
