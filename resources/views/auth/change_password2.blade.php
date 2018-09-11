@extends('layouts.app')

@section('content')
    <h3 class="page-title">Books</h3>
	
	

	<table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($books as $book)
	    <tr>
	        <td></td>
	        <td>{{ $book->name }}</td>
	        <td>{{ $book->detail }}</td>
	        <td>
                <form action="" method="POST">
                    <a class="btn btn-info" href="">Show</a>
                    <a class="btn btn-primary" href="">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>
            
   
@stop

