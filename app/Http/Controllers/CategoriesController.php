<?php


namespace App\Http\Controllers;


use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CategoriesController extends Controller

{
     public function __construct()
    {
        $this->middleware('auth');
    }
	
	
	
	
    public function index()
    {
        $categories = Category::all();
        return view('categories.index',compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
			//return 'rrrrrrrrrrrrrrrrr';
    }


    
    public function create()
    {
        return view('categories.create');
    }


    
	
	
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);


        //Category::create($request->all());
        $category = new Category;        
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        //Book::create($book);
        $category->save();


        return redirect()->route('categories.index')
                         ->with('success','Category created successfully.');
    }


    
	
    public function show($id)
    {
        
		$category = Category::find($id);
		return view('categories.show',compact('category'));
    }
	
	


    
    public function edit($id)	
    {
        $category = Category::find($id);
		return view('categories.edit',compact('category'));
    }


   
    public function update(Request $request, $id)
    {
         request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $category = Category::find($id);
        
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        //Book::create($book);
        $category->save();
        
        //$category->update($request->all());


        return redirect()->route('categories.index')
                         ->with('success','Category updated successfully');
    }
   
   
   
   
   
    public function destroy($id)
    {
        
		$category = Category::find($id);
		$category->delete();
        return redirect()->route('categories.index')
                         ->with('success','category deleted successfully');		
		
    }
	
	
	
	
	
}