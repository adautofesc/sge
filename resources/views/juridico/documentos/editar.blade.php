@extends('layout.app')
@section('pagina')
@include('inc.errors')
 <div class="title-block">
    <h3 class="title">Edição de modelo de documento</h3>
</div>
<form id="item" method="POST">
{{csrf_field()}}
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Tipo
			</label>
			<div class="col-sm-10"> 
				<select name="tipo_documento" class="c-select form-control boxed" required="true">
					<option value="Termo de matrícula" {{($documento->tipo_documento =='Termo de matrícula'?'selected':false)}}>Termo de matrícula </option>
					<option value="Contrato" {{($documento->tipo_documento =='Contrato'?'selected':false)}}>Contrato</option>
					<option value="Cessão de Imagem" {{($documento->tipo_documento =='Cessão de Imagem'?'selected':false)}}>Cessão de Imagem</option>
					<option value="Atestado de matrícula" {{($documento->tipo_documento =='Atestado de matrícula'?'selected':false)}}>Atestado de matrícula</option>
				</select> 
				
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Tipo de Objeto
			</label>
			<div class="col-sm-10"> 
				<select name="tipo_objeto" class="c-select form-control boxed" required="true">
					
					<option value="Aluno" {{($documento->tipo_objeto =='Aluno'?'selected':false)}}>Aluno</option>
					<option value="Turma" {{($documento->tipo_objeto =='Turma'?'selected':false)}}>Turma</option>
					<option value="Curso" {{($documento->tipo_objeto =='Curso'?'selected':false)}}>Curso</option>
					<option value="Programa" {{($documento->tipo_objeto =='Programa'?'selected':false)}}>Programa</option>
					<option value="Parceria" {{($documento->tipo_objeto =='Parceria'?'selected':false)}}>Parceria</option>
					<option value="Global" {{($documento->tipo_objeto =='Global'?'selected':false)}}>Global</option>	
				</select> 
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Objeto
			</label>
			<div class="col-sm-10"> 
				<input type="number" class="form-control boxed" value="{{$documento->objeto}}" name='objeto' >   
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Conteúdo:
			</label>
            <div class="col-sm-10">
				<div class="wyswyg">
					<div class="toolbar"> 
						<span class="ql-format-group">
							<select title="Size" class="ql-size">
								<option value="10px">Pequeno</option>
								<option value="13px" selected>Normal</option>
								<option value="18px">Grande</option>
								<option value="32px">Enorme</option>
							</select>
						</span>
						<span class="ql-format-group">
							<span title="Bold" class="ql-format-button ql-bold"></span>
							<span class="ql-format-separator"></span>
							<span title="Italic" class="ql-format-button ql-italic"></span> 
							<span class="ql-format-separator"></span> 
							<span title="Underline" class="ql-format-button ql-underline"></span>                                            <span class="ql-format-separator"></span> <span title="Strikethrough" class="ql-format-button ql-strike"></span> </span> <span class="ql-format-group">
							<select title="Text Color" class="ql-color">
								<option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)" selected></option>
								<option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
								<option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
								<option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
								<option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
								<option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
								<option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
								<option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)"></option>
								<option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
								<option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
								<option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
								<option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
								<option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
								<option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
								<option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
								<option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
								<option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
								<option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
								<option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
								<option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
								<option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
								<option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
								<option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
								<option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
								<option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
								<option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
								<option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
								<option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
								<option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
								<option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
								<option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
								<option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
								<option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
								<option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
								<option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
							</select>
							<span class="ql-format-separator"></span> 
							<select title="Background Color" class="ql-background">
								<option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)"></option>
								<option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
								<option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
								<option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
								<option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
								<option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
								<option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
								<option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)" selected></option>
								<option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
								<option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
								<option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
								<option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
								<option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
								<option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
								<option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
								<option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
								<option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
								<option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
								<option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
								<option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
								<option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
								<option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
								<option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
								<option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
								<option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
								<option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
								<option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
								<option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
								<option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
								<option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
								<option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
								<option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
								<option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
								<option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
								<option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
							</select> 
						</span> 
						<span class="ql-format-group">
							<span title="List" class="ql-format-button ql-list"></span> 
							<span class="ql-format-separator"></span> 
							<span title="Bullet" class="ql-format-button ql-bullet"></span> 
							<span class="ql-format-separator"></span> 
							<select title="Text Alignment" class="ql-align">
								<option value="left" label="Left" selected></option>
								<option value="center" label="Center"></option>
								<option value="right" label="Right"></option>
								<option value="justify" label="Justify"></option>
							</select> 
						</span>
						<span class="ql-format-group"></span>
					</div>
					<!-- Create the editor container -->
			 		<div id="conteudo" class="editor ql-container ql-snow">
			 			{!! html_entity_decode($documento->conteudo)!!}
			 		</div>
			 		<input type="hidden" id="campo_conteudo" name="content">
				</div>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right"></label>
			<div class="col-sm-10 col-sm-offset-2"> 
				<button type="button" name="btn" onclick="enviar();" class="btn btn-primary">Cadastrar</button>
				<button type="submit" name="btn" value="2" class="btn btn-secondary">Cadastrar e adicionar mais um</button>
				<button type="submit" name="btn" value="3" class="btn btn-secondary">Cancelar</button>
				<!--
				<button type="submit" class="btn btn-primary">Cadastrar e escolher disciplinas obrigatórias</button> 
				-->
			</div>
       </div>
    </div>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		console.log("ok");
	});

	function enviar(){
		
		$('#campo_conteudo').val($('#conteudo').html());
		
		document.forms[0].submit();


	}





	


</script>


@endsection