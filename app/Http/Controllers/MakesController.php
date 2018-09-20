<?php

namespace App\Http\Controllers;

use App\Make;

class MakesController extends Controller
{
   
    
    public function getAllMakes()
    {
    return $makes = Make::all();	
    }
    
    
    
	
}
