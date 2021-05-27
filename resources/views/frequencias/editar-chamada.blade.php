@extends('layout.app')
@section('titulo')Edição de aula @endsection

@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="/">Início</a></li>
  <li class="breadcrumb-item"><a href="/docentes">Docente</a></li>
<li class="breadcrumb-item"><a href="/docentes/frequencia/listar/{{$turma->id}}">Frequência</a></li>

 
</ol>


  <div class="title-block">
        <h3 class="title"> <i class=" fa fa-edit"></i> Edição de Aula Digital</h3>
  <small>Turma {{$turma->id.' - '.$turma->getNomeCurso()}}</small>

    </div>
    <form name="item" method="POST">
	 {{csrf_field()}}
	
        <div class="card card-block">
        	
        @include('inc.errors')
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="nome">
					Aula
				</label>
				
				<div class="col-sm-2"> 
				<input type="date" name="data" value="{{$aula->data->format('Y-m-d')}}">
						<!-- {{$aula->data->format('d/m/Y')}}-->
						<input type="hidden" name="aula" value="{{$aula->id}}">
				</div>
				
				
				
			</div>
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right">Alunos Presentes </label>
				
				<div class="col-sm-10"> 
						<div class="item-col fixed pull-right">
								<a href="?filtrar=todas" class="btn btn-sm btn-secondary" style="margin-top:-5rem;" title="Mostra alunos pendentes, cancelados e transferidos"> Visualizar ocultos </a>
							</div>
						<div class="item-col fixed item-col-check">
								<label class="item-check">
								<input type="checkbox" class="checkbox" onclick="marcardesmarcar(this);">
								<span><small>Todos</small></span>
								</label> 
							</div>
							
					@foreach($turma->inscricoes as $inscricao)
					<div style="height:3rem;border-top: 1px solid #ccc; padding-top:1rem;">
						<label class="item-check">
						<input class="checkbox" type="checkbox" name="aluno[]" value="{{$inscricao->pessoa->id}}" {{in_array($inscricao->pessoa->id,$frequencias)?'checked':false}}>
						@if($inscricao->status!= 'regular')
						<span ><small class="text-danger">({{$inscricao->status}})</small> {{$inscricao->pessoa->nome}}</span>
						@else 
						<span>{{$inscricao->pessoa->nome}}</span>
						@endif
						</label>
					</div>
					@endforeach
				</div>
					
			</div>
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="conteudo">
					Conteúdo
				</label>
				<div class="col-sm-10"> 
				<textarea class="form-control boxed" id="conteudo" name="conteudo" maxlength="300" rows="4" placeholder="Escreva aqui o resumo do conteúdo de sua aula.">@if(isset($conteudo->valor)){{$conteudo->valor}}@endif</textarea>
				
				</div>
			</div>

			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="ocorrencia">
					Ocorrência
				</label>
				<div class="col-sm-10"> 
					<textarea class="form-control boxed" id="ocorrencia" name="ocorrencia" maxlength="300" rows="4" placeholder="Aponte aqui ocorrências como atrasos ou saída antecipada de alunos.">@if(isset($ocorrencia->valor)){{$ocorrencia->valor}}@endif</textarea>
				</div>
			</div>
	

			
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">&nbsp;</label>
				
				<div class="col-sm-5">
					<input type="hidden" name="turma" value="{{$turma->id}}">
					<input type="hidden" name="filtrar" value="{{isset($_GET['filtrar'])?$_GET['filtrar']:'regulares'}}">
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
	<br>
	<div class="title-block">
		<h3 class="title"> <i class=" fa fa-check-square-o"></i> Aulas anteriores</h3>
	</div>

	<div class="card card-block">
		
		<table class="table table-striped table-condensed">
                    
			<thead>
				<th>Data/Opç.</th>
				<th>Resumo/Ocorrência</th>
			</thead>
					
			
			<tbody>
				@foreach($anteriores as $aula_anterior)
				<tr>
					<td>
					{{$aula_anterior->data->format('d/m/Y')}}<br>
						
						<a href="/docentes/frequencia/editar-aula/{{$aula_anterior->id}}" title="Editar dados"><i class=" fa fa-edit"></i></a>
						&nbsp;
						<a href="#" title="Apagar aula" onclick="apagarAula('{{$aula_anterior->id}}','{{$aula_anterior->data->format('d/m/Y')}}')"><i class=" fa fa-trash"></i></a>
					</td>
					<td>
						{{$aula_anterior->conteudo}} <br>
						{{$aula_anterior->ocorrencia}} 
					</td>
				</tr>
				@endforeach
			
			</tbody>

		</table>

	</div>
	
@endsection
@section('scripts')
<script>
function marcardesmarcar(campo){
	$(".checkbox").each(
		function(){
			$(this).prop("checked", campo.checked)
		}
	);
}
function apagarAula(id,data){
	if(confirm("Deseja mesmo apagar a aula do dia "+data+" ?"))
		
		$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/services/excluir-aulas",
        data: { id }
        
    })
	.done(function(msg){
		location.reload(true);
	})
    .fail(function(msg){
        alert('falha ao apagar aula');
    });
}
</script>
@endsection