@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Books</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('books.create') }}"> Create New Book</a>
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
			<th>Category</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($books as $book)
	    <tr>
	        <td></td>
	        <td>{{ $book->name }}</td>
	        <td>{{ $book->description }}</td>
			<td>{{ $book->getCategory($book->category_id)->name }}</td>
	        <td>
                {!! Form::open(['method' => 'DELETE', 'route'=>['books.destroy', $book->id]]) !!}    
                    <a class="btn btn-info" href="{{ route('books.show',$book->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('books.edit',$book->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                 {!! Form::close() !!}
	        </td>
	    </tr>
	    @endforeach
    </table>
	
	
	
	{!! $books->render() !!}
	


@endsection