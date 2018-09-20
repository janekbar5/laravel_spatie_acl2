@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Vehicle</h2>{{ $user_id }}
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href=""> Back</a>
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


    
     {!! Form::open(['method' => 'POST', 'route' => ['vehicles.store']]) !!}    
    	@csrf


        <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Title:</strong>
		            <input type="text" name="title" class="form-control" placeholder="Title">
		        </div>
		    </div>
             
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Description:</strong>
		            <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
		        </div>
		    </div>
             
                    
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="City">Choose Make</label>
                        <select name="make_id" id="make_id" class="form-control">
                          <option value ="">Choose Make</option>  
                            @foreach ($makes as $make)
                            <option value ="{{$make->id}}" >{{ $make->title }} </option>
                             @endforeach
                      </select>
                    </div> 
                    </div>
             
             
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="City">Choose Model</label>
                        <select name="model_id" id="model_id" class="form-control">  
                          <option value ="">Choose Make</option>  
                            
                         </select>
                      </div> 
                    </div> 
		   
            </div>


    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>	
<script>
////////////////////////////////////////////CDD    
    
       
$('#make_id').change(function(e){    
    $.ajax
    ({ 
        url: '/model/getmodel',
        data: {make_id: $('#make_id').val(),"_token": "{{ csrf_token() }}"},
        type: 'post',
        success: function(data)
        {
            $('#model_id').html(data);
        }
    });
});


////////////////////////////////////
</script>
@endsection