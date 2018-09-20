<?php


namespace App\Http\Controllers;


use App\Vehicle;
use App\Make;
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
        return view('books.create');
    }


   
    
    
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        //dd($request->all());
        $book = new Book;        
        $book->title = $request->input('title');
        $book->category_id = $request->input('category_id');
        $book->description = $request->input('description');

        
        //Book::create($book);
        $book->save();


        return redirect()->route('books.index')
                        ->with('success','Book created successfully.');
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
        $makes = app('App\Http\Controllers\MakesController')->getMakes();
        $make = Make::where('id', '=', $vehicle->make_id)->first();    
	return view('vehicles.edit',compact('vehicle','makes','make'));
    }

    public function getCategories(){
        //return $categories = Category::pluck('name', 'id');
        return $categories = Category::all();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $book = Vehicle::find($id);
        //dd($request->all());
        //$book->title = $request->input('title');
        //$book->category_id = $request->input('category_id');
        //$book->description = $request->input('description');
        
        $book->update($request->all());


        return redirect()->route('vehicles.index')->with('success','Vehicle updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
		$book = Book::find($id);
		$book->delete();
        return redirect()->route('books.index')
                         ->with('success','Book deleted successfully');
		
		//return 'eeeee';
    }
    
    
    public function getModels($make_id)
	{		
	//$make_id = 'ddddddd';
	
        dd($make_id);
        /*
        $make_id = Input::get('make_id');
	$level2 = \DB::table('models')->where('make_id','=',$make_id)->get();
	$return = '<option value="">Choose Model</option>';			
	foreach($level2 as $temp)
	$return .= "<option value='$temp->id'>$temp->name</option>";
	return $return;
        */
	}
	
	
	
	
}