@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Edição da Inscrição {{$inscricao->id}} <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
 
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Matricula
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-arrows"></i></span>
					<select class="form-control boxed"  name="matricula" required>

						@foreach($matriculas as $matricula)
							@if($matricula->id == $inscricao->matricula)
							<option selected="selected">{{$matricula->id}}</option>
							@else
							<option>{{$matricula->id}}</option>
							@endif
						@endforeach

					</select>

					
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