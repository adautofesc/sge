@extends('layout.app')
@section('titulo')Upload de arquivo de retorno @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Upload de arquivo de retorno</h3>
            <p class="title-description">Envio de arquivos gerados pelo banco de boletos pagos</p>
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
                        <p class="title" style="color:white">Escolha um ou vários arquivos.</p>
                    </div>
                </div>
                <div class="card-block">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group row"> 
                            <label class="col-sm-1 form-control-label text-xs-right">
                                Arquivo
                            </label>
                            <div class="col-sm-11">  
                                <input type="file" required="true" accept=".pdf" multiple="true" name="arquivos[]" class="form-control boxed"  placeholder="" > 
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
