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
              <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
              <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
              <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> 
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
                              <button type="button" id="submitForm" class="btn btn-primary btn-prime white btn-flat">Create</button>
                            </div>
                        </div>
                </form>     
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                The European languages are members of the same family. Their separate existence is a myth.
                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                in their grammar, their pronunciation and their most common words. Everyone realizes why a
                new common language would be desirable: one could refuse to pay expensive translators. To
                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                words. If several languages coalesce, the grammar of the resulting language is more simple
                and regular than that of the individual languages.
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                like Aldus PageMaker including versions of Lorem Ipsum.
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>    
    


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
                        $( '#title-error' ).html( data.errors.title[0] );
                    }
                    if(data.errors.description){
                        $( '#description-error' ).html( data.errors.description[0] );
                    }
                    if(data.errors.make_id){
                        $( '#make_id-error' ).html( data.errors.make_id[0] );
                    }
                     if(data.errors.model_id){
                        $( '#model_id-error' ).html( data.errors.model_id[0] );
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