@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Ficha técnica {{$ficha->id}}<span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')

    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa 
			</label>
			<div class="col-sm-6"> 
				{{$ficha->getPrograma()}}
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
				Requisitos
			</label>
			<div class="col-sm-6"> 
				{{$ficha->requisitos}}
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
				&nbsp;
			</label>
			<div class="col-sm-10 col-sm-offset-2">
				<button type="cancel" name="btn" value="1" class="btn btn-primary" onclick="history.back(2)">Voltar</button> 
			</div>
       </div>
    </div>

        
@endsection
@section('scripts')

@endsection