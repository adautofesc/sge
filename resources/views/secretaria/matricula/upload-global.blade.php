@extends('layout.app')
@section('titulo')Upload de arquivo de retorno @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Upload de Termo{{$objeto}}</h3>
            <p class="title-description">Envie os arquivos assinados para arquivamento digital</p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-10 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Escolha um{{$qnde==0?' ou vários arquivos':''}}.</p>
                    </div>
                </div>
                <div class="card-block">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="objeto" value="{{$valor}}">
                        <input type="hidden" name="tipo" value="{{$tipo}}">
                        <input type="hidden" name="operacao" value="{{$operacao}}">
                        <input type="hidden" name="qnde" value="{{$qnde}}">
                        <div class="form-group row"> 
                            <label class="col-sm-1 form-control-label text-xs-right">
                                Arquivo
                            </label>
                            <div class="col-sm-11">  
                                <input type="file" required="true" accept=".pdf" {!! $qnde==0?'multiple="true" name="arquivos[]"':'name="arquivos"'!!}  class="form-control boxed" > 
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group row"> 
                            <label class="col-sm-1 form-control-label text-xs-right">
                                
                            </label>
                            <div class="col-sm-11"> 
                                <input class="btn btn-primary" type="submit"> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
