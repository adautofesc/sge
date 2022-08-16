@extends('layout.app')
@section('pagina')
<style>
    label{
        font-size: 10pt;
    }

    .table{
        margin-top:30px;
        
    }
    .table th{
        font-weight: 500%;
    }
</style>
<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Controle de Uso Livre</h3>
            <p class="title-description">Cadastro de utilização dos espaços do PID</p>
        </div>
        <div class="col-md-6 text-xs-right">
           
            <div class="action dropdown show">
                <button class="btn  btn-sm rounded-s btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">  <i class="fa fa-ellipsis-v title"></i> </button>
                <div class="dropdown-menu show" aria-labelledby="dropdownMenu1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: -120px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                    <a class="dropdown-item" href="/uso-livre/gerenciar">Minhas entradas</a>
                    <a class="dropdown-item" href="/relatorios/uso-livre">Relatório</a>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section">
 @include('inc.errors')
 @include('uso-livre.modal-confirma-baixa')
 @include('uso-livre.modal-confirma-exclusao')
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Atendimentos em aberto &nbsp;&nbsp;</p>

                       
                    </div>
                </div>

                <div class="card-block">
                    <div class="pull-right form-group">
                        <select name="selected_items" class="form-control" onchange="lote(this.value)">
                            <option value="0">Com os selecionados</option>
                            <option value="concluir">Finalizar acesso</option>
                            <option value="excluir">Excluir</option>
                        </select>
                    </div>
                    <div></div>
                    <table class="table table-striped table-condensed" >
                    
                        <thead >
                            
                            <th><!--<input type="checkbox" id="all" class="checkbox" onclick="marcardesmarcar(this);">-->
                                <label class="item-check">
                                    <input type="checkbox" class="checkbox" onclick="marcardesmarcar(this);">
                                    <span></span>
                                </label> 
                            </th>
                            <th><small>Início</small></th>
                            <th><small>Pessoa</small></th>

                            <th><small>Opções</small></th>
                            
                        </thead>
                    
                        <tbody>
                            @foreach($uso_livre as $item)
                            <tr>
                                <td>
                                    <label class="item-check">
                                        <input type="checkbox" class="checkbox" name="uso_livre" value="{{$item->id}}">
                                        <span></span>
                                    </label> 
                                </td>
                                <td>{{substr($item->hora_inicio,0,5)}}</td>
                                <td>{{$item->getUsuario()}}</td>
                                <td class="pull-right">
                                    <a href="#" title="Terminar acesso"  data-toggle="modal" data-target="#modal-concluir-atendimento" onclick="selecionar('{{$item->id}}')"><i class="fa fa-caret-square-o-down"></i></a>&nbsp;
                                    <a href="#" title="Excluir acesso"  data-toggle="modal" data-target="#modal-excluir-atendimento" onclick="selecionar('{{$item->id}}')"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            
                            
                        </tbody>
                    </table>
                    
                                   
                </div>     
            </div>
        </div> 
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Novo atendimento</p>
                    </div>
                </div>
                <div class="card-block">
                    <form method="POST" onsubmit="return submete(this)">
                     
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Pessoa </label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control boxed" name="nome" id="search" placeholder="Comece por aqui mesmo para não cadastrados" required> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <ul class="item-list" id="listapessoas"></ul>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Local </label>
                            <div class="col-sm-10"> 
                                <select name="local" class="form-control" placeholder="selecione">
                                 
                                 <option value="0">Selecione</option>
                                 

                                  
                                  @foreach($locais as $local)
                                  @if(session('local') && session('local')==$local->id_local)
                        
                                  <option value="{{$local->id_local}}" selected="selected">{{$local->local}}</option>
                                  @else
                                  <option value="{{$local->id_local}}">{{$local->local}}</option>
                                  @endif
                                  @endforeach
                  
                                </select>
                            </div>
                          
                          </div>
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label text-xs-right text-secondary">
                              Data</label>
                          <div class="col-sm-4"> 
                            <input type="date" class="form-control boxed" name="data" value="{{date('Y-m-d')}}" required>  
                              
                          </div>
                       
                          <label class="col-sm-2 form-control-label text-xs-right text-secondary">Horário</label>
                          <div class="col-sm-4"> 
                            <input type="time" class="form-control boxed" name="inicio" id="hora" title="Selecione a pessoa para o horário ser preenchido automaticamente" required> 
                          </div>
                        
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Atividade</label>
                            <div class="col-sm-9"> 
                                <select name="atividade" class="form-control" placeholder="selecione">
                                  
                                  
                                  <option value="comunicação" title="Enviar e-mails, fazer chamadas ou conversar">Comunicação</option>
                                  <option value="estudo" title="Ralizar trabalhos escolares">Estudo</option>
                                  <option value="recreação" title="Jogar ou usar Redes sociais" selected>Recreação</option>
                                  <option value="serviço público" title="Acessar algum serviço público - agenda Poupatempo, Detran, Gov.br">Serviço público</option>
                                  <option value="trabalho" title="Criar currículo, pesquisar vagas de emprego ou algo relacionado a trabalho">Trabalho</option>
                                  
                  
                                </select>
                            </div>
                          
                          </div>
                        <div class="form-group row">
                          <div class="col-sm-9 offset-sm-2">
                            <input type="hidden" name="pessoa" id="pessoa" value="">
                            <button class="btn btn-info" type="submit" name="btn" >Iniciar</button> 
                            <button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
                            
                            @csrf
                          </div>
                        </div>
                      </form>

                   
    
                
                </div>   
            </div>
        </div> 
        
        

    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript">
    var item = '';

  $(document).ready(function() 
      {
        $("#dia").change(function() {
          $.get("{{asset('agenda-atendimento/')}}"+"/"+$("#dia").val())
            .done(function(data) 
            {
              $("#horarios").html("");
              if(!Array.isArray(data))
                $("#horarios").html("<option>"+data+"</option>");
              else
                if(data.length == 0)
                  $("#horarios").html("<option>Nenhum horário disponível</option>");
                else{
                  $.each(data, function(key, val){
                    var option = document.createElement("option");
                    option.text = val;
                    option.value = val;
                    $("#horarios").append(option);
                  });


                }

              
            });
        });
        $("#search").keyup(function() {
 
            //Assigning search box value to javascript variable named as "name".

            var name = $('#search').val();
            $("#pessoa").val('');
            $("#nascimento").val('');
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
                                        +'<a href="#" onclick="escolhePessoa(\''+val.id+'\',\''+val.nome+'\')">'
                                            +val.numero+' - '+val.nascimento+' - '+val.nome
                                        +'</a>'
                                        +'</li>';
                        

                        });
                        namelist+='<li class=" hidden-sm-down "><a href="/pessoa/cadastrar" class="badge badge-pill badge-primary" style="text-decoration: none; color: white;"> <i class="fa fa-plus"></i> Cadastrar </a></li>';
                        //console.log(namelist);
                        $("#listapessoas").html(namelist).show();

                    });

            }

         });


   });

function selecionar(id){
    item = id;
    $('input[name="usuarios_conclusao"]').val(id);
    const d = new Date()
    let hora = (d.getHours()).toString();
    let minuto = '' + d.getMinutes();
    
    if(hora < 10)
        hora = "0" + hora;
    if(minuto < 10)
        minuto = "0" + minuto;
    $("#encerramento").val(hora + ':' + minuto);
}
function lote(acao){
    selecionar('');
    let itens =   $('input[name="uso_livre"]:checked');
    itens.each(function(i){
        item = item+$(this).val()+';';      
    })
    $('input[name="usuarios_conclusao"]').val(item);
    if(itens.length>0 && item != ''){
        if(acao == 'concluir')
            $('#modal-concluir-atendimento').modal('show');
        if(acao == 'excluir')
            $('#modal-excluir-atendimento').modal('show');
    }
    else{
        $('#error').html('Selecione ao menos um item');
        $('#error').show('slow');
        setTimeout(function() {
            $("#error").hide("slow")		
            }, 3000);	
    }
        

}
function modificarAtendimento(acao){
    $.get("{{asset('/uso-livre/')}}/"+acao+"/"+item)
            .done(function(data) 
            {
              window.location.replace('/uso-livre');
            })
            .fail(function(){
                console.log('Falha ao solicitar '+acao);
            })
  

}
function escolhePessoa(id,nome){
    const d = new Date()
    let hora = (d.getHours()).toString();
    let minuto = '' + d.getMinutes();
    
    if(hora < 10)
        hora = "0" + hora;
    if(minuto < 10)
        minuto = "0" + minuto;
    console.log(minuto);
    $("#hora").val(hora + ':' + minuto);
    $("#search").val(nome);
    $("#pessoa").val(id);
    $("#listapessoas").html("");

}

function marcardesmarcar(campo){
	$("input:checkbox").each(
		function(){
			$(this).prop("checked", campo.checked)
		}
	);
}

 

function alterar(id,acao){
    if(confirm("Confirmar alteração do status do horário?")){
    $.get("{{asset('/agendamento/alterar')}}"+"/"+id+"/"+acao)
            .done(function(data) 
            {
              window.location.replace('/agendamento');
            });
  }
}

function submete(form){
    horario = $('#horarios option').filter(':selected').val();
    if(horario == 'Nenhum horário disponível' || horario == 'Fim de semana' || horario == 'Dia não letivo'){
        alert('Horário inválido');
        return false;
    }
    else
        return true;
}
 </script>   
@endsection