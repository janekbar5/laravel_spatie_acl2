<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Make;
use App\Modell;
use App\Tag;
use Illuminate\Http\Request;
use Validator;
use Response;

//use Illuminate\Support\Facades\Auth;



class VehiclesController extends Controller {

    protected $categoryObject;

    public function __construct(CategoriesController $categoryObject) {
        $this->middleware('auth');
        $this->categoryObject = $categoryObject;
    }

    public function formValidator(array $data) {
        //////////custom message
        $messsages = array(
            'title.required' => 'You cant leave title field empty',
            'description.required' => 'You cant leave description field empty',
            'make_id.required' => 'You cant leave make field empty',
            'model_id.required' => 'You cant leave model field empty',
        );


        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'make_id' => 'required',
            'model_id' => 'required',
        );

        return Validator::make($data, $rules, $messsages);
    }

    //where('token','LIKE', '%'.$token.'%')

    public function index() {
        $vehicles = Vehicle::where('user_id', '=', \Auth::user()->id)->paginate(5);
        return view('vehicles.index', compact('vehicles'));
        //return 'huj';
    }

    public function create() {
        $makes = app('App\Http\Controllers\MakesController')->getAllMakes();
        $models = app('App\Http\Controllers\ModelsController')->getAllModels();
        $user_id = \Auth::user()->id;

        $tags = \App\Tag::pluck('name');
        $currentTags = [];
        //return view('books.create');
        return view('vehicles.create', compact('makes', 'models', 'user_id', 'tags', 'currentTags'));
    }

    public function createAjax() {
        $makes = app('App\Http\Controllers\MakesController')->getAllMakes();
        $models = app('App\Http\Controllers\ModelsController')->getAllModels();
        $user_id = \Auth::user()->id;
        //return view('books.create');
        return view('vehicles.create-ajax', compact('makes', 'models', 'user_id'));
    }

    public function createAjaxPost(Request $request) {


        $formValidator = $this->formValidator($request->all());

        if ($formValidator->passes()) {
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
            $token = str_random(20);
            $vehicle->token = $token;
            $vehicle->save();
            return Response::json(['success' => '1', 'token' => $token]);
        } else {
            return Response::json(['errors' => $formValidator->errors()]);
        }
    }

    public function editAjax($token) {
        $tags = \App\Tag::pluck('name', 'id');
        $currentTags = [];
        $vehicle = Vehicle::orderBy('created_at', 'desc')
                ->where('token', 'LIKE', '%' . $token . '%')
                ->first();

        $makes = app('App\Http\Controllers\MakesController')->getAllMakes();
        $make = Make::where('id', '=', $vehicle->make_id)->first();

        $models = app('App\Http\Controllers\ModelsController')->getMakeModels($vehicle->make_id);
        $model = Modell::where('id', '=', $vehicle->make_id)->first();

        foreach ($vehicle->tags as $tag) {
            $currentTags[] = $tag->id;
        }

        return view('vehicles.edit-ajax', compact('vehicle', 'makes', 'make', 'models', 'model', 'tags', 'currentTags'));
    }

    public function storeAjax(Request $request) {


        $formValidator = $this->formValidator($request->all());

        if ($formValidator->passes()) {
            $vehicle = Vehicle::find($request->input('id'));
            $vehicle->update($request->all());
            
            
    
    
    
            $vehicle->tags()->sync($request->Input('tags'));
            
            return Response::json(['success' => '1']);
        } else {
            return Response::json(['errors' => $formValidator->errors()]);
        }
    }

    public function store(Request $request) {


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
        $vehicle->save();

        $vehicle->tags()->sync($request->Input('tags'));
        return redirect()->route('vehicles.edit', $vehicle->token)->with('status', 'Successfully created vehicle!');
    }

    public function show($id) {
        $book = Book::find($id);
        return view('books.show', compact('book'));
    }

    public function edit($token) {
        //$user = \Auth::user();
        $currentTags = [];
        $tags = \App\Tag::pluck('name', 'id');
        //$tags = \App\Tag::all();
        $vehicle = Vehicle::orderBy('created_at', 'desc')
                ->where('token', 'LIKE', '%' . $token . '%')
                ->first();

        $makes = app('App\Http\Controllers\MakesController')->getAllMakes();
        $make = Make::where('id', '=', $vehicle->make_id)->first();

        $models = app('App\Http\Controllers\ModelsController')->getMakeModels($vehicle->make_id);
        $model = Modell::where('id', '=', $vehicle->make_id)->first();

        //$designcategories = Category::pluck('title', 'id');      
        foreach ($vehicle->tags as $tag) {
            $currentTags[] = $tag->id;
        }

        return view('vehicles.edit', compact('vehicle', 'makes', 'make', 'models', 'model', 'tags', 'currentTags'));
    }

    public function update(Request $request, $id) {
        //dd($request->Input('tags'));
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'make_id' => 'required',
            'model_id' => 'required',
        ]);

        $vehicle = Vehicle::find($id);
        $vehicle->update($request->all());

        $tags = $request->input('tags');
        foreach ($tags as $tag) {
            if (is_numeric($tag))
            {
                $tagArr[] =  $tag;
            }   
            else
            {
                // if the tag not numeric thats meaninig that its new tag and we should create it
                $newTag = Tag::create(['name'=>$tag]);
                // the new Tag id is 3 for exaple 
                $tagArr[] = $newTag->id;
            }  
            //now we have new array of tags id , example (1,2,3)
        }
        
        //dd($tagArr);
        
        //$vehicle->tags()->sync($request->Input('tags'));
        $vehicle->tags()->sync($tagArr);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully');
    }

    public function destroy($id) {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully');
        //return 'eeeee';
    }

}
