@extends('layout.app')
@section('pagina')
@include('inc.errors')
@if(isset($curso->id))
 <div class="title-block">
    <h3 class="title"> Edição de curso</span> </h3>
 </div>
<form name="item" method="POST">
{{csrf_field()}}

    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nome
			</label>
			<div class="col-sm-10"> 
				<input type="text" class="form-control boxed" name="nome" value="{{$curso->nome}}" placeholder="" maxlength="150"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa
			</label>
			<div class="col-sm-10"> 
				<select name="programa" class="c-select form-control boxed">
					<option >Selecione um programa</option>
					@foreach($programas as $programa)
					@if($programa->sigla == $curso->programa->sigla)
					<option value="{{$programa->id}}" selected >{{$programa->nome}}</option>
					@else
					<option value="{{$programa->id}}" >{{$programa->nome}}</option>
					@endif
					@endforeach
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Descrição
			</label>
			<div class="col-sm-10"> 
				<textarea rows="4" class="form-control boxed" name="desc" maxlength="300">{{$curso->desc}}</textarea> 
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga horária
			</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control boxed" name="carga" value="{{$curso->carga}}" placeholder="Horas"> 
			</div>
				<label class="col-sm-2 form-control-label text-xs-right">
				Vagas
			</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control boxed" name="vagas" value="{{$curso->vagas}}" placeholder="Vagas sugeridas"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					 <span class="input-group-addon">R$</span>
					 <input type="text" class="form-control" name="valor" value="{{$curso->valor}}" placeholder="" style="text-align: right"> 
					  
				</div>
			</div>
		</div>
		

        <div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Requisitos</label>
            <div class="col-sm-10"> 
				@foreach($requisitos as $requisito)
				<div>
					<label>
					<input class="checkbox" type="checkbox" name="requisito" value="{{$requisito->id}}">
					<span>{{$requisito->nome}}</span>
					</label>
				</div>
				@endforeach
			</div>
                
        </div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<input type="hidden" name="id" value="{{$curso->id}}">
				<button type="submit" name="btn"  value="1" class="btn btn-primary">Gravar</button>
				<button type="reset" name="btn"  value="1" class="btn btn-primary">Cancelar</button>
			
				<!--
				<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
				-->
			</div>
       </div>
   </div>

</form>
@endif
@endsection