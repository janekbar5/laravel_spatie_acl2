@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script src="{{asset('js/app.min.js')}}"></script>

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

	
	
	
	
<div class="row">

	<div class="col-lg-12">
           <div id="gallery-images">
				<div id="response"> </div>
					 <ul>
					 @foreach($book->imagesBack as $image)
					 <li id="{{ $image->id }}">
					 	<img class="delete-img" src="/img/red-delete-button.png" onclick="deleteArticle({{ $image->id }})"/>
						<a href="{{ url($image->file_path) }}" target="_blank">
						 	<img src="{{ url('/gallery/images/thumbs_240/' . $image->file_name) }}" />
						 </a>		 
					 </li>
					 @endforeach
					 </ul>
		</div>
	</div>
</div>
    
    ////////////////////////////////////////
                    <div class="row">
                            <div class="col-md-12">
                                    <form class="dropzone" id="addImages" action="{{url('books/do-upload')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="book_id" value="{{ $book->id }}" />
                                    <div class="dz-message" data-dz-message><span>Click here, or drag and drop to upload images</span></div>
                                    </form>

                            </div>
                    </div>

    <!--<form action="{{ route('books.update',$book->id) }}" method="POST"> -->
    {!! Form::open(['method' => 'POST', 'route' => ['books.update',$book->id]]) !!}   
    	@csrf
        


         <div class="row">
             
             
             
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Name:</strong>
		            <input type="text" name="name" value="{{ $book->name }}" class="form-control" placeholder="Name">
		        </div>
		    </div>
             
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Detail:</strong>
		            <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $book->detail }}</textarea>
		        </div>
		    </div>
             
                ...{{ $category }}
                
                    <div class="col-xs-12 col-sm-12 col-md-12">
                     <div class="form-group">
                        <label for="City">Choose Category</label>
                        <select name="category_id" class="form-control">
                                      
                          @if (isset($categories))
                          <option value ="">Choose Category</option>  
                            @foreach ($categories as $cat)
                            <option value ="{{$cat->id}}" @if ($cat->id === $book->category_id) selected="selected" @endif>{{ $cat->name }} </option>
                             
                             @endforeach
                         @endif
                      </select>
                      </div>  
                    </div>
                
               
             
		</div>


     {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}


@endsection