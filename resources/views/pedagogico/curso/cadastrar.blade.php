@extends('layout.app')
@section('pagina')
@include('inc.errors')
 <div class="title-block">
    <h3 class="title">Cadastrando novo curso / atividade.</h3>
</div>
<form name="item" method="POST">
{{csrf_field()}}
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nome
			</label>
			<div class="col-sm-10"> 
				<input type="text" class="form-control boxed" name="nome" placeholder="" maxlength="150"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa
			</label>
			<div class="col-sm-10"> 
				<select name="programa" class="c-select form-control boxed">
					<option  selected>Selecione um programa</option>
					@foreach($programas as $programa)
					<option value="{{$programa->id}}">{{$programa->nome}}</option>
					@endforeach
					
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Descrição
			</label>
			<div class="col-sm-10"> 
				<textarea rows="4" class="form-control boxed" name="desc" maxlength="300"></textarea> 
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga horária
			</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control boxed" name="carga" placeholder="Horas"> 
			</div>
				<label class="col-sm-2 form-control-label text-xs-right">
				Vagas
			</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control boxed" name="vagas" placeholder="Vagas sugeridas"> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					 <span class="input-group-addon">R$</span>
					 <input type="text" class="form-control" name="valor" placeholder="" style="text-align: right"> 
					  
				</div>
			</div>
		</div>
		

        <div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">Requisitos obrigatórios</label>
            <div class="col-sm-10"> 
            	@foreach($requisitos as $requisito)
				<div>
					<label>
					<input class="checkbox" type="checkbox" name="requisito[]" value="{{$requisito->id}}">
					<span>{{$requisito->nome}}</span>
					</label>
				</div>
				@endforeach
        	</div>
                
        </div>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<button type="submit" name="btn"  value="1" class="btn btn-primary">Cadastrar</button>
				<button type="submit" name="btn" value="2" class="btn btn-secondary">Cadastrar e adicionar mais um</button>
				<button type="submit" name="btn" value="3" class="btn btn-secondary">Cadastrar e vincular disciplinas</button>
				<!--
				<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
				-->
			</div>
       </div>
    </div>
</form>
@endsection