@extends('layouts.app')




@section('content')

 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit </h2>
                
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('vehicles.index') }}"> Back</a>
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
    
    
<div class="row">
	<div class="col-lg-12">
           //////////////
	</div>
</div>
    
    

    <br><br>
</div>
    
    
   


    
 <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Details</a></li>
              <li><a href="#tab_2" data-toggle="tab">Images</a></li>
              <li><a href="#tab_3" data-toggle="tab">Response</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                             <form method="POST" id="Register">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $vehicle->id }}" class="form-control" >
                        
                        <div class="form-group">
		            <strong>Name:</strong>
		            <input type="text" name="title" value="{{ $vehicle->title }}" class="form-control" placeholder="Name">
                            <span class="text-danger">
                                <strong id="title-error"></strong>
                            </span>
		        </div>
		    
             
		   
		        <div class="form-group">
		            <strong>Description:</strong>
		            <textarea class="form-control" style="height:150px" name="description" placeholder="Detail">{{ $vehicle->description }}</textarea>
                            <span class="text-danger">
                                <strong id="description-error"></strong>
                            </span>
		        </div>
                        
                        
                   <div class="form-group">
                        <label for="City">Choose Make</label>
                        <select name="make_id" id="make_id" class="form-control">
                                      
                          @if (isset($makes))
                          <option value ="">Choose Make</option>  
                            @foreach ($makes as $make)
                            <option value ="{{$make->id}}" @if ($make->id === $vehicle->make_id) selected="selected" @endif>{{ $make->title }} </option>
                             
                             @endforeach
                         @endif
                      </select>
                        <span class="text-danger">
                                <strong id="make_id-error"></strong>
                            </span>
                      </div> 
                  
                          
                        @if (isset($models))
                        <div class="form-group">
                        <label for="City">Choose Model</label>
                        <select name="model_id" id="model_id" class="form-control">  
                          <option value ="">Choose Make</option>  
                            @foreach ($models as $model)
                            <option value ="{{$model->id}}" @if ($model->id === $vehicle->model_id) selected="selected" @endif>{{ $model->title }} </option>                             
                            @endforeach
                         </select>
                        
                        <span class="text-danger">
                                <strong id="model_id-error"></strong>
                            </span>
                      </div>     
                        @else
                         <div class="form-group" id="model_id">
                             
                             <span class="text-danger">
                                <strong id="model_id-error"></strong>
                            </span>
                         </div>    
                        @endif
		
						
                        
		       <div class="form-group">
                        <label for="City">Choose Make</label>
                       {!! Form::select('tags[]', $tags, $currentTags, ['class' => 'form-control ', 'multiple', 'id' => 'tags_list']) !!}	
                        <span class="text-danger">
                                <strong id="make_id-error"></strong>
                            </span>
                      </div>    
                        
<link href=" https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" type="text/css">
  <script src="http://doccotton.test/js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>						
<script>
$('#tags_list').select2({
    placeholder: 'Choose a category',
    tags: true
});

</script>
                        
                        
                        <div class="row">
                            <div class="col-xs-12 text-center">
                              <button type="button" id="submitForm" class="btn btn-primary btn-prime white btn-flat">Save</button>
                            </div>
                        </div>
                    </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
               
                  
                <div class="row">
                      <div class="col-md-12">
                    <div id="gallery-images">
                        <div id="response"> </div>
                        <ul>
                        @foreach($vehicle->imagesBack as $image)
                        <li id="{{ $image->id }}">
                        <a href="{{ url($image->file_path) }}" >
                        <img src="{{ url('/gallery/images/thumbs_240/' . $image->file_name) }}" width="100"/>
                        </a><br>
                        <button class="btn_img_del" data-value="{{ $image->id }}">DELETE</button>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                    </div>
                 </div>
                  
                  
                <div class="row">  
                <div class="col-md-12">
                    <form class="dropzone" id="addImages" action="{{url('vehicles/do-upload')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" />
                    <div class="dz-message" data-dz-message><span>Click here, or drag and drop to upload images</span></div>
                    </form>

                </div>
                </div>
                  
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

	
	
	
	


   

<style>
.delete-img{
	width:30px;
	position:absolute;
	top:0px;
	left:70px;
	
	cursor:pointer;
	z-index: 1000;
}
#gallery-images ul li {
	position:relative;
list-style:none;
width:auto;
float:left;
border:solid 1px red;
}

#gallery-images ul li a img{
float:left;
width:100px;
}

#gallery-images ul li a:hover{
cursor: move;
}
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>	
<script>
    //////////////////////////////////////////form
    $('#submitForm').on('click', function(){
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $( '#title-error' ).html( "" );
        $( '#description-error' ).html( "" );
        $( '#make_id-error' ).html( "" );
        $( '#model_id-error' ).html( "" );

        $.ajax({
            url:'/vehicles/store_ajax',
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
                    $(location).attr('href', '/vehicles/index');                    
                }
            },
        });
    });
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
	




var baseUrl = "{{url('/')}}";


Dropzone.options.addImages={
	
	maxFilesize:2000,
	maxFiles: 5,
	acceptedFiles:'image/*,.jpeg,.jpg',
		success: function(file, response){
			if(file.status=='success'){
			handleDropzoneFileUpload.handleSuccess(response);
			}else{
			handleDropzoneFileError.handleSuccess(response);
			}
		}
};



		
		
var handleDropzoneFileUpload = {
	handleError:function(response){
	//console.log(response);
	alert('error');
	},
	handleSuccess:function(response){
	//alert('sucsess');
	//location.reload();
	
	var imageList = $('#gallery-images ul');
	var imageList = $('#gallery-images ul').addClass('ui-sortable');
	var imageSrc =  baseUrl + '/gallery/images/thumbs_240/' + response.file_name;
	var imageId =  response._id;
	$(imageList).append('<li id="' + imageId + '" class="ui-sortable-handle">\n\
                            <a href="' + imageSrc + '"><img src="' + imageSrc + '"></a><br>\n\
                            <button class="btn_img_del" data-value="'+imageId+'">DELETE</button>\n\
                            </li>');
	}
}

$(document).ready(function(){
//console.log('Document is ready');
});



////////////////////////////////////////////////////////////DELETE IMG
$('.btn_img_del').click(function(e){
    var image_id = $(this).data("value");
    $.ajax
    ({ 
        url: '/images/deleteimg/'+image_id,
        data: {"image_id": image_id},
        type: 'get',
        success: function(result)
        {
            //alert('done')
            $('#'+image_id).remove();
        }
    });
});
////////////////////////////////////////////////////////////ORDER
$(document).ready(function(){ 	

function slideout(){
setTimeout(function(){
$("#response").slideUp("slow", function () {
});
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#gallery-images ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			var token = $("#token").val();						
			var order = ''+$(this).sortable("toArray");
			    	$.ajax({
					url:'/images/changeImageOrder',
					type:'post',			        
					dataType:'json',
					data:{"_token": "{{ csrf_token() }}", order },
					success:function(data){
						//console.log(data);
				        //alert(data);
				    },error:function(){ 
				        //alert("error!!!!");
				    	//console.log(data);
				    }
				})														 
		}								  
		});
	});

});	

</script>	
    
@endsection