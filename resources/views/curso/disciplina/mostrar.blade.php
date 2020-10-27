@extends('layout.app')
@section('pagina')
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="/">Início</a></li>
	<li class="breadcrumb-item"><a href="/cursos">Cursos</a></li>
	<li class="breadcrumb-item"><a href="/cursos/disciplinas">Disciplinas</a></li>
<li class="breadcrumb-item">Disciplina {{$disciplina->id}}</li>
   
</ol>
@include('inc.errors')
@if(isset($disciplina->id))
  <div class="title-block">
                        <h3 class="title"> Dados da disciplina <span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <form name="item" method="POST">
                     {{csrf_field()}}
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nome
								</label>
								<div class="col-sm-8"> 
									{{$disciplina->nome}}
								</div>
								<div class="col-xs-2 text-xs-right">                                        
									<a href="{{asset('/cursos/disciplinas/editar').'/'.$disciplina->id}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
									   </div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Programa
								</label>
								<div class="col-sm-10"> 
									{{$disciplina->programa->nome}}
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Descrição
								</label>
								<div class="col-sm-10"> 
									{{$disciplina->desc}}
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nº de vagas
								</label>
								<div class="col-sm-4"> 
									{{$disciplina->vagas }}
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Carga horária
								</label>
								<div class="col-sm-4"> 
									{{ $disciplina->carga}}
								</div>
							</div> 
							
                        </div>
    </form>
@endif
@endsection