<?php


namespace App\Http\Controllers;


use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BookController extends Controller

{
    protected $categoryObject;


	public function __construct(CategoryController $categoryObject)
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
            'name' => 'required',
            'detail' => 'required',
        ]);


        Book::create($request->all());


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
		return view('books.edit',compact('book'));
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
            'name' => 'required',
            'detail' => 'required',
        ]);

        $book = Book::find($id);
        $book->update($request->all());


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