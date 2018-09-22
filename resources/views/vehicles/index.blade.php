@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Bikes</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('vehicles.create') }}"> Create New Bike</a>
                <a class="btn btn-success" href="{{ route('vehicles.create.ajax') }}"> Create New Bike A</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Foto</th>            
	    <th>Title</th>
            <th>Make</th>
            <th>Model</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($vehicles as $vehicle)
	    <tr>
	        <td>{{ $vehicle->id }}</td>
                <td>
                    @if ($vehicle->imagesFront->count() > 0)
                        @foreach ($vehicle->imagesFront as $image)			 
                            <img src="{{asset('gallery/images/thumbs_340/'.$image->file_name)}}" style="width:100px"/>
                        @endforeach 
                    @else
                            <img src="http://placehold.it/340x260" style="width:100px"/>
                    @endif
                </td>
                
	        <td>{{ $vehicle->title }}</td>
	        
		<td>{{ $vehicle->make()->first()->title }}</td>
                <td>{{ $vehicle->model()->first()->title }}</td>
	        <td>
                {!! Form::open(['method' => 'DELETE', 'route'=>['vehicles.destroy', $vehicle->id]]) !!}    
                    <a class="btn btn-info" href="{{ route('vehicles.show',$vehicle->token) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('vehicles.edit',$vehicle->token) }}">Edit</a>
                    <a class="btn btn-primary" href="{{ route('vehicles.edit.ajax',$vehicle->token) }}">Edit A</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                 {!! Form::close() !!}
	        </td>
	    </tr>
	    @endforeach
    </table>
	
	
    
	
	{!! $vehicles->render() !!}

@endsection
