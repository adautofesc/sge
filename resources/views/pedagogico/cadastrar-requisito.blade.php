@extends('layout.app')
@section('pagina')

  <div class="title-block">
        <h3 class="title"> Adicionar novo requisito </h3>
    </div>
    <form name="item" method="POST">
     {{csrf_field()}}
        <div class="card card-block">
			<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right">
					Nome
				</label>
				<div class="col-sm-10"> 
					<input type="text" class="form-control boxed" name="nome" maxlength="150" placeholder=""> 
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">
					&nbsp;
				</label>
				<div class="col-sm-10 col-sm-offset-2">
					<button class="btn btn-primary" type="submit" name="btn" value="1">Cadastrar</button> 
					<button class="btn btn-secondary" type="submit" name="btn" value="2">Cadastrar próximo</button> 
					
					<!-- 
					<button type="submit" class="btn btn-primary"> Cadastrar</button> 
					-->
				</div>
           </div>
        </div>
    </form>
@endsection