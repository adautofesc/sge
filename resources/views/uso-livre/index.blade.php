@extends('layout.app')
@section('pagina')
<style>
    label{
        font-size: 10pt;
    }
</style>
<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Controle de Uso Livre</h3>
            <p class="title-description">Cadastro de utilização dos espaços do PID</p>
        </div>
    </div>
</div>
<section class="section">
 @include('inc.errors')
    <div class="row">
        <div class="col-md-6 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Atendimentos em aberto &nbsp;&nbsp;</p>

                       
                    </div>
                </div>

                <div class="card-block">
                    
                    <table class="table table-striped table-condensed">
                    
                        <thead class="row">
                            <th class="col-sm-1 col-xs-1"><small>Horário</small></th>
                            <th class="col-sm-9 col-xs-9"><small>Pessoa</small></th>

                            <th class="col-sm-2 col-xs-2"><small>Opções</small></th>
                        </thead>
                    
                        <tbody>
                            
                            
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
                                <input type="text" class="form-control boxed" name="nome" id="search" required> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <ul class="item-list" id="listapessoas"></ul>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Local </label>
                            <div class="col-sm-4"> 
                                <select name="local" class="form-control">
                                  <option>Selecione um local</option>
                  
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