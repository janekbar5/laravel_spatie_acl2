<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\VehicleRequest;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\ImagesController;
use App\Models\Tag;
use App\Models\EnginSize;
use App\Models\Review;
use App\Models\Role;
use App\Models\Vehicle;
use App\Models\VehicleMake;
//use App\Models\Images;
use App\Logic\User\UserRepository;
use Validator;
use DB;
use Session;
use File; //required to add/delete files
use Redirect;
use Flash;


class VehiclesController extends Controller
{
    //use Images;


	public function __construct(UserRepository $userRepository)
    {

		$this->user_id  = Auth::user()->id;
		$this->makes = app('App\Http\Controllers\MakeController')->getMakes();

		//$this->seo_locations  = SeoLocation::orderBy('city','asc')->get();

		$this->vehicles = Vehicle::orderBy('created_at','desc')
		 ->where('user_id','=', $this->user_id)
		 ->paginate(10);

		$this->total_vehicles = \DB::table('vehicles')->where('user_id','=', $this->user_id)->count();
		$this->total_value = \DB::table('vehicles')->where('user_id','=', $this->user_id)->sum('price');
		$this->total_images = \DB::table('images')->where('created_by','=', $this->user_id)->count();
		//$this->userRepository = $userRepository;


		$this->years = [];
		//for ($year=1900; $year <= 2015; $year=++)
		for($year=date("Y"); $year>=1900; $year=$year-1)
				$this->years[$year] = $year;

		///////////////////////

    }







	//////////////////////////////////////////////////////////////////////////
	public function index()
	{
	     	$user                   = \Auth::user();
        //$users 			        	= \DB::table('users')->get();
        //$total_users 	        = \DB::table('users')->count();

        $attemptsAllowed        = 4;
        $total_users_confirmed  = \DB::table('users')->count();
        $total_users_confirmed  = \DB::table('users')->where('active', '1')->count();
        $total_users_locked 		= \DB::table('users')->where('resent', '>', 3)->count();
        $total_users_new        = \DB::table('users')->where('active', '0')->count();


        $userRole               = $user->hasRole('user');
        $editorRole             = $user->hasRole('editor');
        $adminRole              = $user->hasRole('administrator');

        if($userRole)
        {
            $access = 'User';
        } elseif ($editorRole) {
            $access = 'Editor';
        } elseif ($adminRole) {
            $access = 'Administrator';
        }

        return view('admin.pages.vehicles-show2', [
        		'vehicles' 		              => $this->vehicles,
        		//'total_users' 	          => $total_users,
        		//'user' 			          		=> $user,
        		'access' 	                  => $access,
        		'total_vehicles'          	=> $this->total_vehicles,
            'total_images'   			  		=> $this->total_images,
						'total_value'   			  		=> $this->total_value,
            //'total_users_locked'      => $total_users_locked,
            //'total_users_new'         => $total_users_new,
        	]
        );
	}



	//////////////////////////////////////////////////////////////////////////

    public function getHome()
    {
        return view('admin.pages.user-home');
    }

	//////////////////////////////////////////////////////////////////////////

    public function showUserDashboard()
    {
        return view('admin.layouts.dashboard');
    }

    //////////////////////////////////////////////////////////////////////////
    public function showUserProfile()
    {
        return view('admin.layouts.user-profile');
    }









	//////////////////////////////////////////////////////////////////////////


	public function create_new_validator(array $data)
    {

		$messsages = array(
        'name.required'=>'Title field is required!!!!!!',
        'make_id.required'=>'Make field is required',
		'model_id.required'=>'Model field is required',
		'colour_id.required'=>'Colour field is required',
        'description.required'=>'The field description has to be description',
		'price.required'=>'The field price has to be number and not empty',
		'mileage.required'=>'The field mileage has to be number and not empty',
		);


		 $rules = array(
						'name'          => 'required|max:255',
            'make_id'       => 'required',
            'model_id'      => 'required|max:255',
            'description'   => 'required',
						//'price'   		=> 'required',
						//'price'			=> array('required', 'regex:/^\d*(\.\d{2})?$/'),
						'price'			=>'required|numeric|between:0,999999.99',
						'mileage'			=>'required|numeric|between:0,999999.99',
						//'price'			=> array('regex:/^(?:d*.d{1,2}|d+)$/','min:1','max:10'),
            'colour_id'   	=> 'required',
		);

		return Validator::make($data,$rules,$messsages);


    }
	
	
	
	////////////////////////////////////////////////////////////////////////////////////STORE
	public function store(Request $request)
    {

        $create_new_validator = $this->create_new_validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
            );
        }
        else
        {
            $vehicle                   = new Vehicle;
            $vehicle->user_id          = $this->user_id;
            $vehicle->name       	   = $request->input('name');
            $vehicle->make_id          = $request->input('make_id');
			$vehicle->model_id         = $request->input('model_id');
			$vehicle->colour_id        = $request->input('colour_id');
			$vehicle->price            = $request->input('price');
			$vehicle->description      = $request->input('description');
			$vehicle->body_type_id      = $request->input('body_type_id');
			$vehicle->manufactured_year = $request->input('manufactured_year');
			$vehicle->token            = str_random(20);
            // SAVE THE USER
            $vehicle->save();
            // THE SUCCESSFUL RETURN
            //return redirect('vehicles2')->with('status', 'Successfully created vehicle!');
            return redirect()->route('/vehicles/edit', $vehicle->token)->with('status', 'Successfully created vehicle!');

        }

    }
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////STORE Ajax
	public function storeAjax(Request $request)
        {

        $create_new_validator = $this->create_new_validator($request->all());

        if ($create_new_validator->fails()) {
            //$this->throwValidationException($request,$create_new_validator);
			$vehicle = new Vehicle;
			//flash('Welcome Aboard!');
			return redirect()->route('/vehicles-ajax/edit', $vehicle->token)->with('status', 'New book was added');

        }
        else
        {
            $vehicle                   = new Vehicle;
            $vehicle->user_id          = $this->user_id;
            $vehicle->name       	   = $request->input('name');
            $vehicle->make_id          = $request->input('make_id');
						$vehicle->model_id         = $request->input('model_id');
						$vehicle->colour_id        = $request->input('colour_id');
						$vehicle->price            = $request->input('price');
						$vehicle->description      = $request->input('description');
						$vehicle->body_type_id      = $request->input('body_type_id');
						$vehicle->manufactured_year = $request->input('manufactured_year');
						$vehicle->token            = str_random(20);
            // SAVE THE USER
            $vehicle->save();
            // THE SUCCESSFUL RETURN
            //return redirect('vehicles2')->with('status', 'Successfully created vehicle!');
            return redirect()->route('/vehicles/edit', $vehicle->token)->with('status', 'Successfully created vehicle!');

        }

    }
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////Print

	public function printSalesFlyier($token)
    {
		//$makesList = VehicleMake::lists('name', 'id')->toArray();
		$vehicle = Vehicle::orderBy('created_at','desc')
		 ->where('token','LIKE', '%'.$token.'%')
		 ->first();

		return view('admin.pages.vehicles-print-flyier',compact('vehicle'));

    }


	//////////////////////////////////////////////////////////////////////////////////Create
	public function create()
    {
	    //return view('admin.pages.vehicles-create');
		$makesList = VehicleMake::lists('name', 'id')->toArray();
		$coloursList = DB::table('colours')->lists('name', 'id');
		$bodytypes = DB::table('bodytypes')->lists('name', 'id');
		/////////////////////////
		$years=$this->years;
		$tags = \App\Models\Tag::pluck('name', 'id');
		$enginsizes = \App\Models\EnginSize::pluck('name', 'id');

		return view('admin.pages.vehicles-create',compact('makesList','coloursList','bodytypes','years','tags'));

    }
	
	
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////EDIT
	public function edit($token)
    {
        ///////////////////////////
		$currentTags[] ='';
		$currentEngineSizes[] ='';
		$currentReviews[] ='';

		$makesList = VehicleMake::lists('name', 'id')->toArray();
		$vehicle = Vehicle::orderBy('created_at','desc')
		 ->where('token','LIKE', '%'.$token.'%')
		 //->where('id','=', $id)
		 ->first();

	  $selected_level2 = $vehicle->make_id;
		$coloursList = DB::table('colours')->lists('name', 'id');
		$bodytypes = DB::table('bodytypes')->lists('name', 'id');
		$level2 = \DB::table('models')->where('make_id', '=', $selected_level2)->get(); //ok
		$years=$this->years;


		////////////////////////////////////////////get all tags Step 1
		$tags = \App\Models\Tag::pluck('name', 'id');
		//return $tags;
		////////////////////////////////////////////get gurrent tags Step 2
		foreach ($vehicle->tags as $tag) {
		$currentTags[] = $tag->id;
		}



		////////////////////////////////////////////get all tags Step 1
		$enginsizes = \App\Models\EnginSize::pluck('name', 'id');
		//return $tags;
		////////////////////////////////////////////get gurrent tags Step 2
		foreach ($vehicle->enginsizes as $enginsize) {
			$currentEngineSizes[] = $enginsize->id;
		}



		////////////////////////////////////////////get all review Step 1
		$reviews = \App\Models\Review::pluck('name', 'id');
		//return $tags;
		////////////////////////////////////////////get gurrent review Step 2
		foreach ($vehicle->reviews as $review) {
			$currentReviews[] = $review->id;
		}





		return view('admin.pages.vehicles-edit',compact(
			'vehicle',
			'makesList',
			'selected_level2',
			'coloursList',
			'bodytypes',
			'years',
			'tags',
			'currentTags',
			'enginsizes',
			'currentEngineSizes',
			'reviews',
			'currentReviews'
		));



    }
	
	
	
	
		////////////////////////////////////////////////////////////////////////////////////EDIT Ajax
	public function editAjax($token)
    {
        ///////////////////////////
		$currentTags[] ='';
		$currentEngineSizes[] ='';
		$currentReviews[] ='';

		$makesList = VehicleMake::lists('name', 'id')->toArray();
		$vehicle = Vehicle::orderBy('created_at','desc')
		 ->where('token','LIKE', '%'.$token.'%')
		 //->where('id','=', $id)
		 ->first();

	    $selected_level2 = $vehicle->make_id;
		$coloursList = DB::table('colours')->lists('name', 'id');
		$bodytypes = DB::table('bodytypes')->lists('name', 'id');
		$level2 = \DB::table('models')->where('make_id', '=', $selected_level2)->get(); //ok
		$years=$this->years;


		////////////////////////////////////////////get all tags Step 1
		$tags = \App\Models\Tag::pluck('name', 'id');
		//return $tags;
		////////////////////////////////////////////get gurrent tags Step 2
		foreach ($vehicle->tags as $tag) {
		$currentTags[] = $tag->id;
		}



		////////////////////////////////////////////get all tags Step 1
		$enginsizes = \App\Models\EnginSize::pluck('name', 'id');
		//return $tags;
		////////////////////////////////////////////get gurrent tags Step 2
		foreach ($vehicle->enginsizes as $enginsize) {
			$currentEngineSizes[] = $enginsize->id;
		}



		////////////////////////////////////////////get all review Step 1
		$reviews = \App\Models\Review::pluck('name', 'id');
		//return $tags;
		////////////////////////////////////////////get gurrent review Step 2
		foreach ($vehicle->reviews as $review) {
			$currentReviews[] = $review->id;
		}





		return view('admin.pages.vehicles-edit-ajax',compact(
			'vehicle',
			'makesList',
			'selected_level2',
			'coloursList',
			'bodytypes',
			'years',
			'tags',
			'currentTags',
			'enginsizes',
			'currentEngineSizes',
			'reviews',
			'currentReviews'
		));



    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////POST UPDATE
	public function update(Request $request, $token)
	//use App\Http\Requests\BookRequest;
    {
        //dd($request->all());



		$create_new_validator = $this->create_new_validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
            );
        }else {
				$vehicleUpdate=$request->all();
				$vehicle = Vehicle::where('token', 'LIKE', '%'.$token.'%')->first();

				$vehicle->update($vehicleUpdate);

				/////////////////////////////////////////////////////Tags step 3
				$this->syncTags($vehicle, $request->input('tag_list',[]));
				/////////////////////////////////////////////////////enginsizes step 3
				$this->syncEnginsizes($vehicle, $request->input('enginsize_list',[]));
				/////////////////////////////////////////////////////reviews step 3
				$this->syncReviews($vehicle, $request->input('review_list',[]));


				return redirect('vehicles')->with('status', 'Successfully updated!');
		}

    }


	///////////////////////////////////////////////////////////////////////////////////////Tags step 4
    //public function syncTags(Vehicle $vehicle, array $tags)
	public function syncTags(Vehicle $vehicle, array $tags)
    {
        foreach ($tags as $key => $tag) {
            if (!is_numeric($tag)) {
                $newTag = \App\Tag::create(['name' => $tag, 'slug' => $tag]);
                $tags[$key] = $newTag->id;
            }
        }

        $vehicle->tags()->sync($tags);
    }


	///////////////////////////////////////////////////////////////////////////////////////enginsizes step 4
    public function syncEnginsizes(Vehicle $vehicle, array $enginsizes)
    {

			foreach ($enginsizes as $key => $enginsize) {
				if (!is_numeric($enginsize)) {
					$newEnginSize = \App\Models\EnginSize::create(['name' => $enginsize, 'slug' => $enginsize]);
					$enginsizes[$key] = $newEnginSize->id;
				}
			}


        $vehicle->enginsizes()->sync($enginsizes);
    }


	///////////////////////////////////////////////////////////////////////////////////////reviews step 4
	public function syncReviews(Vehicle $vehicle, array $reviews)
    {

			foreach ($reviews as $key => $review) {
				if (!is_numeric($review)) {
					$newReview = \App\Models\Review::create(['name' => $review, 'slug' => $review]);
					$reviews[$key] = $newReview->id;
				}
			}

        $vehicle->reviews()->sync($reviews);


    }



	//////////////////////////////////////////////////////////////////////////////////DELETE
	public function destroy($token)
    {
        // finding record to delete in DB
		$vehicle = Vehicle::where('token', '=', $token)->first();
		$id = $vehicle->id;
		//delete images files from directories
		app('App\Http\Controllers\ImagesController')->deleteImageswithVehicle($id);
    	//delete record from BD
		$vehicle->delete();
		return redirect('vehicles')->with('status', 'Successfully deleted!');
		//echo 'images exist';
    }





}
