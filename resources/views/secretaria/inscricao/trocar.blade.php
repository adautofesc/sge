@extends('layout.app')
@section('titulo')Transferência de turma. @endsection
@section('pagina')
<div class="title-block">
    <h3 class="title"> Transferencia de turma da inscrição {{$inscricao->id}} <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
		<p>Abaixo estão listadas turmas do mesmo curso, abertas e que ainda possuem vagas.</p>
 
		<div class="form-group row"> 

			<label class="col-sm-2 form-control-label text-xs-right">
				Transferir para turma: 
			</label>
			<div class="col-sm-10"> 
				<div class="input-group">
					@if(count($turmas)>1)
					<span class="input-group-addon"><i class="fa fa-exchange"></i></span>
					<select class="form-control boxed"  name="matricula" required>
						@foreach($turmas as $turma)
							@if(isset($turma->disciplina->id))
							<option>{{$turma->id.' - '.implode(', ',$turma->dias_semana).' das '.$turma->hora_inicio.' as '.$turma->hora_termino. ' ---- '.$turma->disciplina->nome}}</option>
		
							@else
							<option>{{$turma->id.' - '.implode(', ',$turma->dias_semana).' das '.$turma->hora_inicio.' as '.$turma->hora_termino. ' ---- '.$turma->curso->nome}}</option>
							@endif
						
						@endforeach

				

					</select>
					@else
					<b>Nenhuma turma compatível</b>
					@endif

					
				</div>
			</div>
		</div>
		            
		<div class="form-group row">
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