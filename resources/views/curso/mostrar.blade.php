@extends('layout.app')
@section('pagina')
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="/">Início</a></li>
	<li class="breadcrumb-item"><a href="/cursos">Cursos</a></li>
	<li class="breadcrumb-item">Curso {{$curso->id}}</li>
   
</ol>
@include('inc.errors')

@if(isset($curso->id))
  <div class="title-block">
                        <h3 class="title"> Dados do Curso / Atividade<span class="sparkline bar" data-type="bar"></span> </h3>
                        
                    </div>
                    <form name="item" method="POST">
                     {{csrf_field()}}
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nome
								</label>
								<div class="col-sm-8"> 
									{{$curso->nome}}
								</div>
								<div class="col-xs-2 text-xs-right">                                        
                           	 <a href="{{asset('/cursos/editar').'/'.$curso->id}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
                       			</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Programa
								</label>
								<div class="col-sm-10"> 
									{{$curso->programa->nome}} 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Descrição
								</label>
								<div class="col-sm-10"> 
									{{$curso->desc}} 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nº de vagas
								</label>
								<div class="col-sm-4"> 
									{{$curso->vagas }}
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Carga horária
								</label>
								<div class="col-sm-4"> 
									{{ $curso->carga}}
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Disciplinas
								</label>
								<div class="col-sm-4"> 
									@if(isset($curso->disciplinas))
									<a href="{{ asset("/cursos/disciplinas/vincular").'/'.$curso->id}}" class="btn btn-secondary rounded-s btn-sm" > Modificar Disciplinas</a>
									<ul>
									@foreach($curso->disciplinas as $disciplina)
										<li>{{ $disciplina->nome}}</li>
									@endforeach
									</ul>
									@else
									<a href="{{ asset("/cursos/disciplinas/vincular").'/'.$curso->id}}" class="btn btn-secondary rounded-s btn-sm" > Adicionar Disciplina(s)</a>
									@endif
									
								</div>
							</div>

							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Requisitos
								</label>
								<div class="col-sm-4"> 
									
									
									@if(isset($curso->requisitos))
										<a href="{{ asset("cursos/requisitos/requisitosdocurso/").'/'.$curso->id}}" class="btn btn-secondary rounded-s btn-sm" >Modificar Requisitos</a>
										<ul>
									@foreach($curso->requisitos as $requisito)

										<li> {{ $requisito->requisito->nome}}</li>
									@endforeach
										</ul>
									@else
										<a href="{{ asset("cursos/requisitos/requisitosdocurso/").'/'.$curso->id}}" class="btn btn-secondary rounded-s btn-sm" >Adicionar Requisito(s)</a>
									@endif
									
								</div>
							</div>
                        </div>
    </form>
@endif
@endsection