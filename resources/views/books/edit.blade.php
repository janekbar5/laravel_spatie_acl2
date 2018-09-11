@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Book</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('books.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!--<form action="{{ route('books.update',$book->id) }}" method="POST"> -->
    {!! Form::open(['method' => 'POST', 'route' => ['books.update',$book->id]]) !!}   
    	@csrf
        


         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Title:</strong>
		            <input type="text" name="title" value="{{ $book->title }}" class="form-control" placeholder="Title">
		        </div>
		    </div>
             
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Description:</strong>
		            <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ $book->description }}</textarea>
		        </div>
		    </div>
             
                    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Category:</strong>
		            <input type="text" name="category_id" value="{{ $book->category_id }}" class="form-control" placeholder="Category">
		        </div>
		    </div>
             
		</div>


     {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}


@endsection