@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title">Lista completa de notificações</h3>
      
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-12 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Geral</p>
                    </div>
                </div>
                <div class="card-block">
                   @foreach($notificacoes as $notificacao)
                    <div>
                        <a href="#" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;{{$notificacao->created_at}} - {{$notificacao->tipo}} - {{$notificacao->dado}} {{$notificacao->valor}} </a>
                    </div>
                    @endforeach
                   
                    
                </div>
            </div>
        </div>
       
        
    </div>
</section>

@endsection