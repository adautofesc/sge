@extends('layout.app')
@section('pagina')

<form name="item" method="POST">

    <div class="title-block">
        <h3 class="title"> Edição de dados Clínicos<span class="sparkline bar" data-type="bar"></span> </h3>
    </div>
    @include('inc.errors')
    <div class="subtitle-block">
        <h3 class="subtitle"> 
        @if(isset($dados['nome']))
        	{{$dados['nome']}}
        
        </h3>
    </div>
    <div class="card card-block">
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
                <div class="col-sm-8"> 
                    <input type="text" class="form-control boxed" placeholder="Motora, visual, auditiva, etc. Se não tiver, não preencha." name="necessidade_especial" value="{{$dados['necessidade_especial']}}"  maxlength="150"> 
                </div>
        </div>
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
                <div class="col-sm-8"> 
                    <input type="text" class="form-control boxed" placeholder="Digite os medicamentos de uso contínuo da pessoa. Se não tiver, não preencha." maxlength="150" name="medicamentos" value="{{$dados['medicamentos_continuos']}}"> 
                </div>
        </div>
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
                <div class="col-sm-8"> 
                    <input type="text" class="form-control boxed" placeholder="Digite alergias ou reações medicamentosas. Se não tiver, não preencha." maxlength="150" name="alergias" value="{{$dados['alergias']}}"> 
                </div>
        </div>
        <div class="form-group row"> 
                <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
                <div class="col-sm-8"> 
                    <input type="text" class="form-control boxed" placeholder="Se não tiver, não preencha." maxlength="150" name="doenca_cronica" value="{{$dados['doenca_cronica']}}"> 
                </div>
        </div>
        <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right"></label>
                                <div class="col-sm-10 col-sm-offset-2"> 
                                    <input type="hidden" name="pessoa" value="{{$dados['id']}}">
                                    <button type="submit" name="btn_sub" value='1' class="btn btn-primary">Salvar</button>
                                   
                                   
                                    {{ csrf_field() }}
                                </div>
                    </div>
    </div>
                    
                        
              
</form>

@endif

@endsection