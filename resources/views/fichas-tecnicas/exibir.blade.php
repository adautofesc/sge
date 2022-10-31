@extends('layout.app')
@section('pagina')
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('fichas-tecnicas.modal-encaminhamento')
<div class="title-block">
    <h3 class="title"> Ficha Técnica #{{$ficha->id}}<span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')

    <div class="card card-block">
		<div class="subtitle-block">
			<h3 class="title">Descrição</h3>

		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Estado 
			</label>
			<div class="col-sm-6"> 
				{{$ficha->status}}
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa 
			</label>
			<div class="col-sm-6"> 
				{{$ficha->getPrograma()->nome}}
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Professor
			</label>
			<div class="col-sm-6"> 
				{{$ficha->getDocente();}}
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Curso/Atividade
			</label>
			<div class="col-sm-6"> 
				{{$ficha->curso}} 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Objetivo
			</label>
			<div class="col-sm-6"> 
				{{$ficha->objetivo}}
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Conteúdo Programático
			</label>
			<div class="col-sm-6"> 
				{{$ficha->conteudo}}
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Requisitos
			</label>
			<div class="col-sm-6"> 
				{{$ficha->requisitos}}
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Recursos necessários
			</label>
			<div class="col-sm-6"> 
				{{$ficha->materiais}}
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Dia(s) semana.
			</label>
			<div class="col-sm-6"> 
				{{$ficha->dias_semana}}
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Data Início
			</label>
			<div class="col-md-2">
				{{$ficha->data_inicio->format('d/m/y')}}
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Data Termino
			</label>
			<div class="col-md-2">
				{{$ficha->data_termino->format('d/m/y')}}
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Hora Início
			</label>
			<div class="col-md-2">
				{{$ficha->hora_inicio}}
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Hora Termino
			</label>
			<div class="col-md-2">
				{{$ficha->hora_termino}}
			</div>
		</div>

		<div class="form-group row"> 
			
			<label class="col-sm-2 form-control-label text-xs-right">
				Idade Minima
			</label>
			<div class="col-md-2">
				{{$ficha->idade_minima}}
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Idade Maxima
			</label>
			<div class="col-md-2">
				{{$ficha->idade_maxima}}
			</div>
		</div>
		<div class="form-group row"> 
			
			<label class="col-sm-2 form-control-label text-xs-right">
				Lotação Minima
			</label>
			<div class="col-md-2">
				{{$ficha->lotacao_minima}}
			</div>

			<label class="col-sm-2 form-control-label text-xs-right">
				Lotação Maxima
			</label>
			<div class="col-md-2">
				{{$ficha->lotacao_maxima}}
			</div>
		</div>
		

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga
			</label>
			<div class="col-md-2">
				{{$ficha->carga}}
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Periodicidade(t)
			</label>
			<div class="col-md-2">
				{{$ficha->periodicidade}}
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Local
			</label>
			<div class="col-sm-2"> 
				{{$ficha->getLocal()}}
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Sala
			</label>
			<div class="col-sm-2"> 
				{{$ficha->getSala()}} 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Valor
			</label>
			<div class="col-md-2">
				R$ {{$ficha->getValor()}}
			</div>
			
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Mais Informações
			</label>
			<div class="col-sm-6"> 
				{{$ficha->obs}}
			</div>
		</div>

		<div class="subtitle-block">
			<h3 class="title">Histórico</h3>

		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Ação
			</label>
			<div class="col-md-10">
				@foreach($dados as $dado)
				{{$dado->created_at->format('d/m/Y H:i')}} - {{$dado->conteudo}} @if(in_array('26', Auth::user()->recursos)) por {{$dado->getPessoa('nome_simples')}}@endif<br>
				@endforeach
			</div>
			
		</div>
		
		
		

            
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				&nbsp;
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				
				<button type="cancel" name="btn" value="1" class="btn btn-primary" onclick="history.back(2)">Voltar</button> 
				<a class="btn btn-primary" href="/fichas/editar/{{$ficha->id}}">Editar</a> 
				<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-encaminhar-ficha" title="Encaminhar ficha para..." >
					Encaminhar para ...
				</a>
				@if($ficha->status =='secretaria')
				<a class="btn btn-primary" href="/turmas/gerar-por-ficha/{{$ficha->id}}">Gerar turma</a> 
				@endif
				

			</div>
       </div>
    </div>

        
@endsection
@section('scripts')
<script>
	function encaminhar(id){
		depto = $("#depto").val();
		obs = $("#obs").val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			method: "POST",
			url: "/fichas/encaminhar",
			data: { id,depto,obs }
			
		})
		.done(function(msg){
			location.reload(true);
		})
		.fail(function(msg){
			alert('Falha ao encaminhar ficha: '+msg.statusText);
		});
	}
</script>

@endsection