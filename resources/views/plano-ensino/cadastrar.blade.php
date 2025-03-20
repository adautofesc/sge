@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Novo Plano de Ensino <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="POST">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Programa 
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="programa" required>
					<option >Selecione um programa</option>
					@if(isset($programas))
					@foreach($programas as $programa)
					<option value="{{$programa->id}}">{{$programa->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Período
			</label>
			<div class="col-sm-3"> 
				<select class="c-select form-control boxed" name="periodo" required>
					@if(isset($semestres))
					
					@foreach($semestres as $semestre)
						<option value="{{$semestre->semestre.$semestre->ano}}">{{$semestre->semestre.'º Sem. '.$semestre->ano}}</option>
					@endforeach
					@endif
				</select> 
			</div>
			<label class="col-sm-2 form-control-label text-xs-right">
				Carga Horária
			</label>
			<div class="col-sm-1"> 
				<div class="input-group">
					 
					<input type="number" class="form-control boxed" name="carga" placeholder="" required> 
				</div>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Professor
			</label>
			<div class="col-sm-6"> 
				<select class="c-select form-control boxed" name="professor" required readonly>
					<option>Selecione um professor</option>
					@if(isset($professores))
					@foreach($professores as $professor)
					<option value="{{$professor->id}}">{{$professor->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Curso/Atividade
			</label>
			<div class="col-sm-6"> 
				<input type="text" class="form-control boxed" id="fcurso" name="curso" placeholder="Digite o nome do curso" required> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Habilidades gerais
			</label>
			<div class="col-sm-6"  > 
				<textarea rows="3" class="form-control" name="habilidades_gerais[]" maxlenght="300"></textarea><br>
				<div id="habilidadesGerais"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addHabilidadesGerais()">Adicionar Habilidade Geral</a>

			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Habilidades específicas
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="habilidades_especificas[]" maxlenght="300"></textarea><br>
				<div id="habilidadesEspecificas"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addHabilidadesEspecificas()">Adicionar habilidade específica</a>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Objetivos
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="objetivos[]" maxlenght="300"></textarea><br>
				<div id="objetivos"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addObjetivos()">Adicionar objetivo</a>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Conteúdo Programático
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="conteudos_programaticos[]" maxlenght="300"></textarea><br>
				<div id="cont_programa"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addContProgram()">Adicionar conteúdo programático</a>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Procedimentos de Ensino
			</label>
			<div class="col-sm-6"> 
				<input type="text" class="form-control" name="procedimentos_ensino[]" maxlenght="300"><br>
				<div id="proc_ensino"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addProcEnsino()">Adicionar procedimentos de ensino</a>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Instrumentos de avaliação
			</label>
			<div class="col-sm-6"> 
				<input type="text" class="form-control" name="instrumentos_avaliacao[]" maxlenght="300"><br>
				<div id="inst_avalia"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addInstAvalia()">Adicionar instrumentos de avaliação</a>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Bibliografia Básica
			</label>
			<div class="col-sm-6"> 
				<textarea rows="3" class="form-control" name="bibliografia[]" maxlenght="300" placeholder="SOBRENOME, Nome Abreviado. Título: subtítulo (se houver). Edição (se houver). Local de publicação: Editora, data de publicação da obra."></textarea><br>
				<div id="bibliografia"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addBibliografia()">Adicionar bibliografia</a>
			</div>
		</div>

		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Cronograma
			</label>
			<div class="col-sm-6"> 
				<span>Aula 1</span>
				<textarea rows="3" class="form-control" name="atividades[1]" maxlenght="300"></textarea>
				<input type="text" class="form-control" name="recursos[1]" placeholder="Recursos que serão utilizados na sua aula"><br>
				<div id="cronograma"></div>
				<a href="#" class="btn btn-sm btn-primary-outline" onclick="addAtividade()">Adicionar aula</a>
			</div>
		</div>
		
		
		

            
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" name="btn" value="1" class="btn btn-primary">Cadastrar</button> 
				<button type="submit" name="btn" value="2" href="disciplinas_show.php?" class="btn btn-secondary">Cadastrar a próxima</button> 
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
       </div>
    </div>
    {{csrf_field()}}
</form>
        
@endsection
@section('scripts')
<script type="text/javascript">
var aula = 1;
function addHabilidadesGerais(){
	var div = document.querySelector("#habilidadesGerais");
	var input = document.createElement('textarea');
	var bl = document.createElement('br');
	input.setAttribute('rows','3');
	input.setAttribute('name','habilidades_gerais[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};

function addHabilidadesEspecificas(){
	var div = document.querySelector("#habilidadesEspecificas");
	var input = document.createElement('textarea');
	var bl = document.createElement('br');
	input.setAttribute('rows','3');
	input.setAttribute('name','habilidades_especificas[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};
function addObjetivos(){
	var div = document.querySelector("#objetivos");
	var input = document.createElement('textarea');
	var bl = document.createElement('br');
	input.setAttribute('rows','3');
	input.setAttribute('name','objetivos[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};

function addContProgram(){
	var div = document.querySelector("#cont_programa");
	var input = document.createElement('textarea');
	var bl = document.createElement('br');
	input.setAttribute('rows','3');
	input.setAttribute('name','conteudos_programaticos[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};

function addProcEnsino(){
	var div = document.querySelector("#proc_ensino");
	var input = document.createElement('input');
	var bl = document.createElement('br');
	input.setAttribute('type','text');
	input.setAttribute('name','procedimentos_ensino[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};

function addInstAvalia(){
	var div = document.querySelector("#inst_avalia");
	var input = document.createElement('input');
	var bl = document.createElement('br');
	input.setAttribute('type','text');
	input.setAttribute('name','instrumentos_avaliacao[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};

function addBibliografia(){
	var div = document.querySelector("#bibliografia");
	var input = document.createElement('textarea');
	var bl = document.createElement('br');
	input.setAttribute('rows','3');
	input.setAttribute('placeholder','SOBRENOME, Nome Abreviado. Título: subtítulo (se houver). Edição (se houver). Local de publicação: Editora, data de publicação da obra.');
	input.setAttribute('name','bibliografia[]');
	input.setAttribute('maxlenght','300');
	input.setAttribute('class','form-control');
	div.appendChild(input);
	div.appendChild(bl);

};

function addAtividade(){
	aula++;
	var div = document.querySelector("#cronograma");
	var span = document.createElement('span');
	var tx_area = document.createElement('textarea');
	var input = document.createElement('input');
	var bl = document.createElement('br');
	span.innerHTML = 'Aula '+aula;
	tx_area.setAttribute('rows','3');
	tx_area.setAttribute('name','atividades['+aula+']');
	tx_area.setAttribute('maxlenght','300');
	tx_area.setAttribute('class','form-control');
	input.setAttribute('type','text');
	input.setAttribute('name','recursos['+aula+']');
	input.setAttribute('placeholder','Recursos que serão utilizados na sua aula');
	input.setAttribute('class','form-control');
	div.appendChild(span);
	div.appendChild(tx_area);
	div.appendChild(input);
	div.appendChild(bl);

};




</script>


@endsection