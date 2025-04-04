@extends('layout.app')
@section('pagina')

<div class="title-block">
	<h3 class="title"> Atendimento Geral<span class="sparkline bar" data-type="bar"></span> </h3>
</div>
@include('inc.errors')
<form name="item" method="post">
    <div class="card card-block">
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Nome
			</label>
			<div class="col-sm-8"> 
				<input type="search" id="search" name="nome"  class="form-control boxed" placeholder="Você pode digitar numero, nome, RG e CPF"> 

				<input type="hidden" name="id_pessoa">
				{{ csrf_field() }}
			</div>
		</div>
		
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				Atender: 
			</label>
			<div class="col-sm-8"> 
				 <ul class="item-list" id="listapessoas">
				 	@if(isset($pessoas))
					 	@foreach($pessoas as $pessoa)
					 		<li>
					 			{{$pessoa->numero}} - {{$pessoa->nascimento}} - {{$pessoa->nome}} |
					 			<a href="{{asset('secretaria/atender')}}/{{$pessoa->id}}">
					 				Atendimento simples	
 								</a>
 						

					 		</li>

					 	@endforeach
				 	@endif
				 </ul>

				
			</div>
		</div>
		<div class="form-group row"> 
			<label class="col-sm-2 form-control-label text-xs-right">
				
			</label>
			<div class="col-sm-8"> 
				<a href="{{ asset('/pessoa/cadastrar')}}" class="btn btn-primary">Cadastrar pessoa</a> 
			
				<!-- 
				<button type="submit" class="btn btn-primary"> Cadastrar</button> 
				-->
			</div>
		</div>
		
    </div>
</form>
@endsection
@section('scripts')
<script>
	$(document).ready(function() 
	{
 
   //On pressing a key on "Search box" in "search.php" file. This function will be called.
 
   $("#search").keyup(function() {
 
       //Assigning search box value to javascript variable named as "name".
 
       var name = $('#search').val();
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
 									+'<a href="{{asset('secretaria/atender')}}/'+val.id+'">'
 										+val.numero+' - '+val.nascimento+' - '+val.nome
 									+'</a>'
 								  +'</li>';
 					

 					});
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
</script>
@endsection