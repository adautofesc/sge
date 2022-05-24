@extends('layout.app')
@section('titulo') Inscrição em dívida ativa @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Inscrição em dívida ativa</h3>
            <p class="title-description">Geração e download da remessa</p>
        </div>
    </div>
</div>
<section class="section">
    @include('inc.errors')
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card">
                
                <div class="card-block">
                    <p><small>{{ceil($boletos->currentPage()*100/$boletos->lastPage())}}% processado...</small> </p>
                
             
                    <div>
                        <a href="{{asset('/financeiro/boletos/remessa/download')}}/{{$arquivo}}"  class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-cloud-download "></i>
                        &nbsp;&nbsp;Fazer download do arquivo</a>
                    </div>

                    
                    <div>
                        <a href="{{asset('financeiro/divida-ativa')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-list "></i>
                        &nbsp;&nbsp;Gerenciador de Dívida Ativa</a>
                    </div>
                    

                </div>
            </div>
        </div>

    </div>
</section>

@endsection