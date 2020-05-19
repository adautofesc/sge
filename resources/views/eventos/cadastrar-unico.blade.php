@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Cadastro de novo evento <span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="form_evento" id="form_evento" method="POST">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Evento
			</label>
			<div class="col-sm-8"> 
				<div class="input-group">				
					<input type="text" class="form-control boxed" name="nome" placeholder="Título do evento (max 200 caracteres)" maxlength="200" > 
				</div>
			</div>
		</div>
		<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right">
					Responsável
				</label>
				<div class="col-sm-8"> 
					<input type="search" id="search"  class="form-control boxed" placeholder="Você pode digitar numero, nome, RG e CPF" required> 
	
					<input type="hidden" id="id_pessoa" name="responsavel" >
					<ul class="item-list" id="listapessoas">
					</ul>
				</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
					Data
			</label>
			<div class="col-sm-3"> 
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
					<input type="date" class="form-control boxed" name="data_inicio" placeholder="dd/mm/aaaa" required> 
				</div>
			</div>
		</div>
		<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right">
					Início
				</label>
				<div class="col-sm-2"> 
					<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>  
						<input type="time" class="form-control boxed" name="h_inicio" required> 
					</div>
				</div>
				<label class="col-sm-1 form-control-label text-xs-right">
					Termino
				</label>
				<div class="col-sm-2"> 
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 
						<input type="time" class="form-control boxed" name="h_termino"  required> 
					</div>
				</div>
			</div>
		<div class="form-group row"> 
				
			<label class="col-sm-2 form-control-label text-xs-right">
				Local
			</label>
			<div class="col-sm-3"> 
				<select class="c-select form-control boxed" name="local" onchange="carregarSalas(this.value)" >
						<option value="84">Fesc Campus1</option>
					@if(isset($locais))
					@foreach($locais as $local)
					<option value="{{$local->id}}">{{$local->nome}}</option>
					@endforeach
					@endif
				</select> 
			</div>
			<label class="col-sm-1 form-control-label text-xs-right">
					Sala
				</label>
				<div class="col-sm-3"> 
					<select class="c-select form-control boxed" name="sala" id="select_sala" required >
						<option>Selecione uma sala</option>
						@if(isset($salas))
						@foreach($salas as $sala)
						<option value="{{$sala->id}}">{{$sala->nome}}</option>
						@endforeach
						@endif
					</select> 
				</div>
		</div>
		
		
		
		<div class="form-group row"> 
				<label class="col-sm-2 form-control-label text-xs-right">
					Descrição
				</label>
				<div class="col-sm-8"> 
					<div class="input-group">
						
						<textarea class="form-control boxed" name="descricao"></textarea>
					</div>
				</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Auto inscrição?
			</label>
			<div class="col-sm-8"> 
				<div class="input-group">
					
					<label><input class="radio" name="autoinsc" value="sim" type="radio"><span>Sim</span></label>
					<label><input class="radio" name="autoinsc" value="nao" type="radio"><span>Não</span></label>
				</div>
			</div>
		</div>



        
		<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">
				&nbsp;<input type="hidden" name="tipo" value="{{$tipo}}"/>
					</label>
			<div class="col-sm-10 col-sm-offset-3">
					<button class="btn btn-primary" type="button" name="btn" onclick="event.preventDefault(); validar();" value="1">Salvar</button> 
					<!-- <button class="btn btn-primary" type="submit" name="btn" value="2">Salvar e adicionar mais</button> -->
					<button type="reset" name="btn"  class="btn btn-primary">Limpar</button>
                	<button type="cancel" name="btn" class="btn btn-primary" onclick="history.back(-2);">Cancelar</button>
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
$(document).ready(function() 
    {
 
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
 
   $("#search").keyup(function() {
 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#search').val();
       $('#id_pessoa').val('');
       var namelist="";

 
       //Validating, if "name" is empty.
 
       if (name == "") {
 
           //Assigning empty value to "display" div in "search.php" file.
 
           $("#listapessoas").html("");
 
       }
 
       //If name is not empty.
 
       else {
 
           //AJAX is called.
            $.get("{{asset('pessoa/buscarapida/')}}"+"/"+name)
                .done(function(data) 
                {
                    $.each(data, function(key, val){
                        namelist+='<li class="item item-list-header hidden-sm-down">'
                                    +'<a href="#" onclick="adicionar(\''+val.id+'\',\''+val.nome+'\')">'
                                        +val.numero+' - '+val.nascimento+' - '+val.nome
                                    +'</a>'
                                  +'</li>';
                    

                    });
					namelist+='<li><a href="/pessoa/cadastrar" class="btn btn-success-outline btn-sm btn-rounded"><i class="fa fa-plus"></i> CADASTRAR</a></li>'
                    //console.log(namelist);
                    $("#listapessoas").html(namelist).show();



                });

                /*
                <option value="324000000000 Adauto Junior 10/11/1984 id:0000014">
                    <option value="326500000000 Fulano 06/07/1924 id:0000015">
                    <option value="3232320000xx Beltrano 20/02/1972 id:0000016">
                    <option value="066521200010 Ciclano 03/08/1945 id:0000017">
                    */
            
            
 
       }
 
    });
 
});
function adicionar(id,nome){
    $('#id_pessoa').val(id);
    $('#search').val(nome);
    $("#listapessoas").html("");

}
function carregarSalas(local){
	var salas;
	$("#select_sala").html('<option>Sem salas disponíveis</option>');
	$.get("{{asset('api/salas-locaveis-api/')}}"+"/"+local)
		.done(function(data) 
		{
			$.each(data, function(key, val){
				salas+='<option value="'+val.id+'">'+val.nome+'</option>';
			});
			//console.log(namelist);
			$("#select_sala").html(salas);
		});
				 
}
function validar(){
	if($('input[name=nome]').val()==''){
		alert('Nome do evento vazio.');
		return false;
	}
	if($('#id_pessoa').val() == '' ){
		alert('Selecione uma pessoa da lista de cadastrados ou cadastre uma nova.');
		return false;
	}
	
	document.getElementById("form_evento").submit();
	return true;
	
		
}



</script>


@endsection