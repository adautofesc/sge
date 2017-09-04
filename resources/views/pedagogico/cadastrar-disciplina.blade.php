@extends('layout.app')
@section('pagina')

  <div class="title-block">
                        <h3 class="title"> Adicionar nova disciplina <span class="sparkline bar" data-type="bar"></span> </h3>
                    </div>
                    <form name="item" method="POST">
                     {{csrf_field()}}
                        <div class="card card-block">
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nome
								</label>
								<div class="col-sm-10"> 
									<input type="text" class="form-control boxed" name="nome" placeholder=""> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Programa
								</label>
								<div class="col-sm-10"> 
									<select class="c-select form-control boxed" name="programa">
										<option selected>Selecione um programa</option>
										<option value="EMG">EMG</option>
										<option value="PID">PID</option>
										<option value="UATI">UATI</option>
										<option value="UNIT">UNIT</option>
									</select> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Descrição
								</label>
								<div class="col-sm-10"> 
									<textarea rows="4" class="form-control boxed" name="desc"></textarea> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Nº de vagas
								</label>
								<div class="col-sm-4"> 
									<input type="text" class="form-control boxed" name ="vagas" placeholder=""> 
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-2 form-control-label text-xs-right">
									Carga horária
								</label>
								<div class="col-sm-4"> 
									<input type="text" class="form-control boxed" name="carga" placeholder="Horas"> 
								</div>
							</div>
							
							
                                
							<div class="form-group row">
								<div class="col-sm-10 col-sm-offset-2">
									<button class="btn btn-primary" type="submit" name="btn" value="1">Cadastrar</button> 
									<button class="btn btn-secondary" type="submit" name="btn" value="2">Cadastrar próxima</button> 
									
									<!-- 
									<button type="submit" class="btn btn-primary"> Cadastrar</button> 
									-->
								</div>
		                   </div>
                        </div>
    </form>
@endsection;