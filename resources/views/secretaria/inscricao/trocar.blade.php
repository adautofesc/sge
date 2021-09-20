@extends('layout.app')
@section('titulo')Transferência de turma. @endsection
@section('pagina')
<div class="title-block">
    <h3 class="title"> Transferencia de turma da inscrição {{$inscricao->id}} <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
		<p>Abaixo estão listadas turmas do mesmo curso, abertas e que ainda possuem vagas.</p>
 <!--
		<div class="form-group row"> 

			<label class="col-sm-2 form-control-label text-xs-right">
				Transferir para turma: 
			</label>
			<div class="col-sm-10"> 
				<div class="input-group">
					@if(count($turmas)>1)
					<span class="input-group-addon"><i class="fa fa-exchange"></i></span>
					<select class="form-control boxed"  name="turma" required>
						@foreach($turmas as $turma)
							@if(isset($turma->disciplina->id))
							<option value="{{$turma->id}}">{{$turma->id.' - '.implode(', ',$turma->dias_semana).' das '.$turma->hora_inicio.' as '.$turma->hora_termino. ' - '.$turma->local->nome.' ---- '.$turma->disciplina->nome}}</option>
		
							@else
							<option value="{{$turma->id}}">{{$turma->id.' - '.implode(', ',$turma->dias_semana).' das '.$turma->hora_inicio.' as '.$turma->hora_termino.' - '.$turma->local->nome.' ---- '.$turma->curso->nome}}</option>
							@endif

						
						@endforeach


				

					</select>
					@else
					<b>Nenhuma turma compatível</b>
					@endif

					
				</div>
			</div>
		</div>
	-->
	<div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">Turma</label>
            <div class="col-sm-10"> 
                
                <div>
                	<small>
					@if(count($turmas)>1)
						@foreach($turmas as $turma)
								
							<label>
							<input class="radio" type="radio" name="turma" value="{{$turma->id}}" {{($turma->vagas-$turma->matriculados)<=0?'disabled="True"':''}}>
							@if(isset($turma->disciplina->id))
								<span>{{$turma->id.' - '.implode(', ',$turma->dias_semana)
								.' das '.$turma->hora_inicio
								.' as '.$turma->hora_termino. ' - '
								.$turma->local->nome
								.' - '.$turma->disciplina->nome
								.'. Vagas: '.($turma->vagas-$turma->matriculados)
								}}</span>
							@else
								<span>{{$turma->id.' - '.implode(', ',$turma->dias_semana)
								.' das '.$turma->hora_inicio
								.' as '.$turma->hora_termino
								.' - '.$turma->local->nome
								.' - '.$turma->curso->nome
								.' - '.$turma->professor->nome_simples
								.'. Vagas: '.($turma->vagas-$turma->matriculados)
								}}</span>
							@endif
							</label><br>
						@endforeach
					@endif 
                    <label>
                    	<input class="radio" type="radio" name="turma" value="0">
                    	<span> Outra: </span><input type="number" name="turma_alternativa" placeholder="Código da turma">
                    </label></br>
                	</small>
                </div>
            </div>        
        </div>
		

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Motivo 
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="motivo" required>
					<option value="1">1 - Horário incompatível</option>
					<option value="2">2 - Disciplina não correspondeu as expectativas</option>
					<option value="3">3 - Atividade muito intensa</option>
					<option value="4">4 - Problemas com o professor</option>
				</select> 
			</div>
		</div>       
		<div class="form-group row">
			<label class="col-sm-2"></label>
			<div class="col-sm-10 col-sm-offset-2">
				<input type="hidden" name="inscricao" value="{{$inscricao->id}}">
				<button type="submit" name="btn"  class="btn btn-primary">Salvar</button>
                <button type="reset" name="btn"  class="btn btn-primary">Restaurar</button>
                <button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);return false;">Cancelar</button>
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
    {{csrf_field()}}
</form>
        
@endsection 