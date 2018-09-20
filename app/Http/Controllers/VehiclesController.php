<?php


namespace App\Http\Controllers;


use App\Vehicle;
use App\Make;
use App\Modell;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;



class VehiclesController extends Controller

{
    protected $categoryObject;


    public function __construct(CategoriesController $categoryObject)
    {
        $this->middleware('auth');
	$this->categoryObject = $categoryObject;
    }
	
	
	
	
    public function index()
    {
	$vehicles = Vehicle::paginate(5);
        return view('vehicles.index',compact('vehicles'));	
    }


    
    
    public function create()
    {
        $makes  = app('App\Http\Controllers\MakesController')->getAllMakes();
        $models = app('App\Http\Controllers\ModelsController')->getAllModels();
        $user_id = \Auth::user()->id;
        //return view('books.create');
        return view('vehicles.create',compact('makes','models','user_id'));
    }


   
    
    
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'make_id' => 'required',
            'model_id' => 'required',
        ]);
        
       
        $vehicle = new Vehicle;
        $vehicle->title = $request->input('title');
        $vehicle->make_id = $request->input('make_id');
        $vehicle->model_id = $request->input('model_id');
        $vehicle->colour_id = 1;
        $vehicle->fuel_type_id = 1;
        $vehicle->body_type_id = 1;
        $vehicle->price = 5991;
        //$vehicle->manufactured_year = 2005;
        $vehicle->description = $request->input('description');
        $vehicle->user_id = \Auth::user()->id;
        $vehicle->token = str_random(20);
        // SAVE THE USER
            $vehicle->save();
            // THE SUCCESSFUL RETURN
            //return redirect('vehicles2')->with('status', 'Successfully created vehicle!');
            return redirect()->route('vehicles.edit', $vehicle->token)->with('status', 'Successfully created vehicle!');
        //$vehicle->save($request->all());        
        //Book::create($book);
        //$vehicle->save();


        //return redirect()->route('vehicles.index')->with('success','Vehicle created successfully.');
    }


   
    
    
    public function show($id)
    {
        $book = Book::find($id);
	return view('books.show',compact('book'));
    }


    
    public function edit($token)	
    {
        //$user = \Auth::user();
        $vehicle = Vehicle::orderBy('created_at','desc')
		 ->where('token','LIKE', '%'.$token.'%')		 
		 ->first();  
        
        $makes = app('App\Http\Controllers\MakesController')->getAllMakes();
        $make  = Make::where('id', '=', $vehicle->make_id)->first();
        
        $models = app('App\Http\Controllers\ModelsController')->getMakeModels($vehicle->make_id);
        $model  = Modell::where('id', '=', $vehicle->make_id)->first();
        
	return view('vehicles.edit',compact('vehicle','makes','make','models','model'));
    }

    
    
    
    
    
    
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'make_id' => 'required',
            'model_id' => 'required',
        ]);

        $vehicle = Vehicle::find($id);
        $vehicle->update($request->all());
        return redirect()->route('vehicles.index')->with('success','Vehicle updated successfully');
    }
    
    
    
    
    
    public function destroy($id)
    {
        
		$book = Book::find($id);
		$book->delete();
        return redirect()->route('books.index')
                         ->with('success','Book deleted successfully');
		
		//return 'eeeee';
    }
    
    
    
	
	
	
	
}