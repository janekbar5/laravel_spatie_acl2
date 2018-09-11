@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Categories</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a>
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
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($categories as $category)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $category->name }}</td>
	        <td>{{ $category->description }}</td>
	        <td>
               
                {!! Form::open(['method' => 'DELETE', 'route'=>['categories.destroy', $category->id]]) !!}    
                    <a class="btn btn-info" href="{{ route('categories.show',$category->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                 {!! Form::close() !!}
	        </td>
	    </tr>
	    @endforeach
    </table>


@endsection