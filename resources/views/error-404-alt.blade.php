@extends('layout.app')
@section('pagina')
<div class="error-card">
    <div class="error-title-block">
        <h1 class="error-title">
            @if(isset($error))
            {{$error['id']}}</h1>
        <h2 class="error-sub-title"> {{$error['desc']}}</h2>
            @endif
    </div>
    <div class="error-container">
        <p>Procurando algum recurso?</p>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group"> <input type="text" class="form-control"> <span class="input-group-btn">
    <button class="btn btn-primary" type="button">Procurar</button>
  </span> </div>
            </div>
        </div> <br> <a class="btn btn-primary" href="{{asset('/')}}"><i class="fa fa-angle-left"></i> Voltar ao Painel</a> </div>
</div>
@endsection