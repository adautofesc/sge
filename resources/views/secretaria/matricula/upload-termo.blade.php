@extends('layout.app')
@section('titulo')Upload de Termo de Matricula @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Upload de termo da matricula {{$matricula}}</h3>
            <p class="title-description">Após assinado, escanear o termo.</p>
        </div>
    </div>
</div>
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
                        <input type="hidden" name="matricula" value="{{$matricula}}"/>

                        
                        <div class="form-group row"> 
                            <label class="col-sm-1 form-control-label text-xs-right">
                                Arquivo
                            </label>
                            <div class="col-sm-11">  
                                <input type="file" required="true" accept=".pdf" name="arquivo" class="form-control boxed"  placeholder="" maxlength="150"> 
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
