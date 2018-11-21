@extends('layout.app')
@section('titulo')Cadastro de atestado @endsection
@section('pagina')

<div class="title-search-block">
    <div class="title-block">
        <h3 class="title">Alun{{$pessoa->getArtigoGenero($pessoa->genero)}}: {{$pessoa->nome}} 
            @if(isset($pessoa->nome_resgistro))
                ({{$pessoa->nome_resgistro}})
            @endif
           
        </h3>
        <p class="title-description"> <b> Cod. {{$pessoa->id}}</b> - Tel. {{$pessoa->telefone}} </p>
    </div>
</div>
@include('inc.errors')
<form name="item" method="post" enctype="multipart/form-data">
{{csrf_field()}}
    <div class="card card-block">
    	<div class="subtitle-block">
            <h3 class="subtitle"><i class=" fa fa-medkit "></i> Cadastro de Atestado Médico. </h3>
        </div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Emissão
			</label>
			<div class="col-sm-3"> 
				<input type="date" class="form-control boxed" name="emissao" placeholder="" > 
			</div>
		</div>
		<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Arquivo
            </label>
            <div class="col-sm-6">  
                <input type="file" accept=".pdf" name="arquivo" class="form-control boxed"  placeholder="" maxlength="150"> 
            </div>
        </div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
                <button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
			</div>
       </div>
    </div>
</form>
@endsection