<?php


namespace App\Http\Controllers;


use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BooksController extends Controller

{
    protected $categoryObject;


	public function __construct(CategoriesController $categoryObject)
    {
        $this->middleware('auth');
	$this->categoryObject = $categoryObject;
    }
	
	
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$books = Book::all();
		//$books = Book::with('bookHasCategory')->get();
		$books = Book::paginate(5);
        return view('books.index',compact('books'));
			//return 'rrrrrrrrrrrrrrrrr';
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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


    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
	return view('books.show',compact('book'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)	
    {
        $book = Book::find($id);
        $categories = $this->getCategories();
        $category = Category::find($book->category_id);
	return view('books.edit',compact('book','categories','category'));
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

        $book = Book::find($id);
        //dd($request->all());
        $book->title = $request->input('title');
        $book->category_id = $request->input('category_id');
        $book->description = $request->input('description');
        
        $book->update();


        return redirect()->route('books.index')
                         ->with('success','Book updated successfully');
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
	
	
	
	
}