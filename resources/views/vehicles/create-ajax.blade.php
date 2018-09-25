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


    



<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Basic Details</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
               <form method="POST" id="Register">
                        {{ csrf_field() }}
                        
                        
                    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Title:</strong>
		            <input type="text" name="title" class="form-control" placeholder="Title">
                            <span class="text-danger">
                                <strong id="title-error"></strong>
                            </span>
		        </div>
		    </div>
             
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Description:</strong>
		            <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
                            <span class="text-danger">
                                <strong id="description-error"></strong>
                            </span>
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
                         <span class="text-danger">
                                <strong id="make_id-error"></strong>
                            </span>
                    </div> 
                    </div>
             
             
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="City">Choose Model</label>
                        <select name="model_id" id="model_id" class="form-control">  
                          <option value ="">Choose Make</option>  
                            
                         </select>
                        <span class="text-danger">
                                <strong id="model_id-error"></strong>
                            </span>
                      </div> 
                    </div> 
                        
                        
		   <div class="row">
                            <div class="col-xs-12 text-center">
                              <label for="City">Click create to upload images</label>
                              <button type="button" id="submitForm" class="btn btn-primary btn-prime white btn-flat">Create</button>
                            </div>
                   </div>
                </form>     
              </div>
              <!-- /.tab-pane -->
              
              <!-- /.tab-pane -->
             
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>    
    
    <style>
       
    </style>

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


//////////////////////////////////////////form
    $('#submitForm').on('click', function(){
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $( '#title-error' ).html( "" );
        $( '#description-error' ).html( "" );
        $( '#make_id-error' ).html( "" );
        $( '#model_id-error' ).html( "" );

        $.ajax({
            url:'/vehicles/create_ajax',
            type:'POST',
            data:formData,
            success:function(data) {
                console.log(data);
                if(data.errors) {
                    if(data.errors.title){
                        $( '#title-error' ).html( '<div class="alert alert-danger alert-dismissible">'+data.errors.title[0]+'</div>' );
                    }
                    if(data.errors.description){
                        $( '#description-error' ).html( '<div class="alert alert-danger alert-dismissible">'+data.errors.description[0]+'</div>' );
                    }
                    if(data.errors.make_id){
                        $( '#make_id-error' ).html( '<div class="alert alert-danger alert-dismissible">'+data.errors.make_id[0]+'</div>' );
                    }
                     if(data.errors.model_id){
                        $( '#model_id-error' ).html( '<div class="alert alert-danger alert-dismissible">'+data.errors.model_id[0]+'</div>' );
                    }
                }
                if(data.success) {
                    $(location).attr('href', '/vehicles/edit_ajax/'+data.token);                    
                }
            },
        });
    });

</script>
@endsection