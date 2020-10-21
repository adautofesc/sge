@extends('layout.app')
@section('titulo')Edição dos conteúdos das aulas @endsection

@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="/">Início</a></li>
  <li class="breadcrumb-item"><a href="/docentes">Docente</a></li>
<li class="breadcrumb-item"><a href="/docentes/frequencia/preencher/{{$turma->id}}">Frequência</a></li>
<li class="breadcrumb-item"><a href="/docentes/frequencia/conteudos/{{$turma->id}}">Conteúdos</a></li>

 
</ol>


  	<div class="title-block">
        <h3 class="title"> <i class=" fa fa-check-square-o"></i> Edição Conteudos</h3>
  		<small>Turma {{$turma->id.' - '.$turma->getNomeCurso()}}</small>
    </div>
    <form name="item" method="POST">
	 {{csrf_field()}}
	
        <div class="card card-block">
        	
        @include('inc.errors')
			
				
			@foreach($aulas as $aula)
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right" for="conteudo">
					{{$aula->data->format('d/m/Y')}}
				</label>
				<div class="col-sm-10"> 
				<textarea class="form-control boxed" id="conteudo" name="conteudo[{{$aula->id}}]" maxlength="300" rows="4" placeholder="Escreva aqui o resumo do conteúdo de sua aula.">{{$aula->valor}}</textarea>
				
				</div>
			</div>
			@endforeach

			
	

			
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">&nbsp;</label>
				
				<div class="col-sm-5">
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