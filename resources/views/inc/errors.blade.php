@if($errors->any())
    @foreach($errors->all() as $erro)
        <div class="alert alert-warning" >
                <button type="button" class="close" data-dismiss="alert" >×</button>       
                <p class="modal-title"><i class="fa fa-circle"></i> {{$erro}}</p>
        </div>
    @endforeach
@endif



<!-- nesse caso basta colocar ->with('success','mensagem') no código -->
@if ($message = Session::get('success'))
        <div class="alert alert-success" >
                <button type="button" class="close" data-dismiss="alert" >×</button> 
                <p class="modal-title"><i class="fa fa-fa-thumbs-o-up"></i> {{$message}}</p>
        </div>
  	
@endif
@if ($message = Session::get('info'))	
<div class="alert alert-info" >
        <button type="button" class="close" data-dismiss="alert" >×</button> 
        <p class="modal-title"><i class="fa fa-info-circlep"></i> {{$message}}</p>
</div>
  	
@endif
@if ($message = Session::get('warning'))	
<div class="alert alert-warning" >
        <button type="button" class="close" data-dismiss="alert" >×</button> 
        <p class="modal-title"><i class="fa fa-warning"></i> {{$message}}</p>
</div>
  	
@endif
@if ($message = Session::get('danger'))	
<div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" >×</button> 
        <p class="modal-title"><i class="fa fa-times-circle"></i> {{$message}}</p>
</div>
  	
@endif


