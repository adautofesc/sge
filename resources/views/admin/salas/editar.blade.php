@extends('layout.app')
@section('titulo')Criando nova sala. @endsection
@section('pagina')
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="../../../../">Início</a></li>
  <li class="breadcrumb-item"><a href="../../../">Administrativo</a></li>
  <li class="breadcrumb-item"><a href="../../">Locais</a></li>
  <li class="breadcrumb-item"><a href="../">Salas</a></li>
 
</ol>


  <div class="title-block">
        <h3 class="title"> <i class=" fa fa-pencil "></i> Alteração dos dados da sala {{$sala->nome}} </h3>
        <small>Locais de atendimento & Parcerias</small>
    </div>
    <form name="item" method="POST">
	 {{csrf_field()}}
	
        <div class="card card-block">
        	
        @include('inc.errors')
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="nome">
					Identificação*
				</label>
				<div class="col-sm-2"> 
					<input type="text" class="form-control boxed" name="nome" id="nome" maxlength="30" required="required" placeholder="12 Audiório" value="{{$sala->nome}}"> 
				</div>
				<label class="col-sm-2 form-control-label text-xs-right" for="metragem">
					Tamanho
				</label>
				<div class="col-sm-2"> 
				<input type="text" class="form-control boxed" id="metragem" name="metragem" maxlength="20" placeholder="Em m²" value="{{$sala->metragem}}"> 
				</div>
				<label class="col-sm-2 form-control-label text-xs-right" for="capacidade">
					Capacidade
				</label>
				<div class="col-sm-2"> 
					<input type="text" class="form-control boxed" name="capacidade" id="capacidade" maxlength="200" placeholder="pessoas" value="{{$sala->capacidade}}" > 
				</div>
			</div>
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="obs">
					Observações
				</label>
				<div class="col-sm-10"> 
					<textarea class="form-control boxed" id="obs" name="obs" maxlength="300" rows="4" placeholder="Sala usada para tal coisa.">{{$sala->obs}}</textarea>
				
				</div>
			</div>
	
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="gps">
					Gps
				</label>
				<div class="col-sm-10"> 
				<input type="text" class="form-control boxed" id="gps" name="gps" maxlength="20" placeholder="URL da posição no Maps" value="{{$sala->posicaogps}}"> 
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">Atributos</label>
				<label class="col-sm-2 form-control-label ">
					<input type="checkbox" name="locavel" value="s" title="Estará disponível para locação?" {{$sala->locavel=='s'?'checked':''}}> 
					<span title="Estará disponível para locação?">Locavel?</span> 
					
				</label>
				<label class="col-sm-3 form-control-label ">
						<input type="radio" name="status" value="funcionando" {{$sala->status=='funcionando'?'checked':''}}> Ativa &nbsp; &nbsp;
						<input type="radio" name="status" value="parada" {{$sala->status=='parada'?'checked':''}}> Parada 
				</label>
				<div class="col-sm-5 text-xs-right">
					<input type="hidden" name="local" value="{{$sala->local}}"/>
					<input type="hidden" name="id" value="{{$sala->id}}"/>
					<button class="btn btn-primary" type="submit" name="btn" value="1">Salvar</button> 
					<button type="reset" name="btn"  class="btn btn-primary">Limpar</button>
                	<button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
					
					<!-- 
					<button type="submit" class="btn btn-primary"> Cadastrar</button> 
					-->
				</div>
           </div>
        </div>
    </form>
@endsection