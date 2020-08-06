@if($errors->any())
    @foreach($errors->all() as $erro)
        <div class="alert alert-danger" onload="console.log('pau')">
                <button type="button" class="close" data-dismiss="alert" >×</button>       
                <p class="modal-title"><i class="fa fa-warning"></i> {{$erro}}</p>
        </div>
    @endforeach
@endif


@if(isset($erros_bd) !=0)
    @foreach($erros_bd as $erro)
        <p class="alert alert-danger text-center .alert-dismissible">{{ $erro }}</p>
    @endforeach
@endif


@if(isset($dados['alert_danger']) && $dados['alert_danger']!='')
	@foreach($dados['alert_danger'] as $erro)
        <p class="alert alert-danger text-center .alert-dismissible">{{ $erro }}</p>
  	@endforeach
@endif

@if(isset($dados['alert_warning']) && $dados['alert_warning']!='')
	@foreach($dados['alert_warning'] as $erro)
        <p class="alert alert-warning text-center .alert-dismissible">{{ $erro }}</p>
  	@endforeach
@endif

@if(isset($dados['alert_info']) && $dados['alert_info']!='')
	@foreach($dados['alert_info'] as $erro)
        <p class="alert alert-info text-center .alert-dismissible">{{ $erro }}</p>
  	@endforeach
@endif
@if ($message = Session::get('success'))	
        <p class="alert alert-success text-center alert-dismissible">{{ $message }}</p>
  	
@endif





@if(isset($pessoa->alert_sucess) && $pessoa->alert_sucess!='')
        <p class="alert alert-success text-center alert-dismissible">{{ $pessoa->alert_sucess }}</p>
@endif
@if(isset($pessoa->alert_danger) && $pessoa->alert_danger!='')
        <p class="alert alert-danger text-center .alert-dismissible">{{ $pessoa->alert_danger }}</p>
@endif

@if(isset($pessoa->alert_warning) && $pessoa->alert_warning!='')
        <p class="alert alert-warning text-center .alert-dismissible">{{ $pessoa->alert_warning }}</p>
@endif

@if(isset($pessoa->alert_info) && $pessoa->alert_info !='')
        <p class="alert alert-info text-center .alert-dismissible">{{ $pessoa->alert_info }}</p>
@endif