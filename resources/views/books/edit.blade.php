@extends('layouts.app')




@section('content')




    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Bike</h2>
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
					 	
                                              
						<a href="{{ url($image->file_path) }}" target="_blank">
						 	<img src="{{ url('/gallery/images/thumbs_240/' . $image->file_name) }}" width="100"/>
                                                </a><br>
                                                 <button class="btn" data-value="{{ $image->id }}">DELETE</button>
					 </li>
					 @endforeach
					 </ul>
		</div>
	</div>
</div>
    
    
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

<script>



var baseUrl = "{{url('/')}}";


Dropzone.options.addImages={
	
	maxFilesize:200,
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
	$(imageList).append('<li id="' + imageId + '" class="ui-sortable-handle"><a href="' + imageSrc + '"><img src="' + imageSrc + '"></a><br><button class="btn" data-value="'+imageId+'">DELETE</button></li>');
	}
}

$(document).ready(function(){
//console.log('Document is ready');
});



////////////////////////////////////////////////////////////DELETE IMG
$('.btn').click(function(e){

    //var book_id = $(this).parent().data('id');
    var book_id = $(this).data("value");

    $.ajax
    ({ 
        url: '/images/deleteimg/'+book_id,
        data: {"bookID": book_id},
        type: 'post',
        success: function(result)
        {
            $('.modal-box').text(result).fadeIn(700, function() 
            {
                setTimeout(function() 
                {
                    $('.modal-box').fadeOut();
                }, 2000);
            });
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
					type:'POST',			        
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