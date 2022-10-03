@extends('layout.app')
@section('pagina')

<div class="title-block">
	<h3 class="title">Relação Institucional <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
<form method="POST">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-left">
				Qual o cargo ocupado por <strong>"{{$nome}}"</strong> neste momento na FESC?
			</label>
			<div class="col-sm-2"> 
				<select name="cargo" class="form-control form-control-sm">
					<option>Nenhum</option>
					<option value="Administrador">Administrador</option>
					<option value="Advogado">Advogado</option>
					<option value="Auxiliar Administrativo">Auxiliar Administrativo</option>
					<option value="Aprendiz">Aprendiz</option>
					<option value="Assistente">Assistente</option>
					<option value="Chefia">Chefia</option>
					<option value="Contador">Contador</option>
					<option value="Coordenador de Programa">Coordenador de Programa</option>
					<option value="Diretor">Diretor Pedagógico</option>
					<option value="Diretor">Diretor Administrativo</option>
					<option value="Educador">Educador</option>
					<option value="Educador de Parceria">Educador de parceria</option>
					<option value="Estagiário">Estagiário</option>
					<option value="Gestor">Gestor</option>
					<option value="Operacional">Operacional</option>
					<option value="Parceiro">Parceiro</option>
					<option value="Presidente">Presidente</option>
					<option value="Prestador de serviço">Prestador de serviço</option>
					<option value="Técnico">Técnico</option>
				</select>
			</div>

		</div>
		
	
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-left">
				
			</label>
			<div class="col-sm-8"> 
				{{ csrf_field() }}
				<input type="hidden" name="pessoa" value="{{$id}}">
				<button type="submit" name="btn_sub" value='3'  class="btn btn-primary">Salvar Informação</button>
				
			
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
		</div>
		
    </div>
</form>
@endsection
