@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Agenda de atendimentos</h3>
            <p class="title-description">Bora atender esse povo?</p>
        </div>
    </div>
</div>
<section class="section">
 @include('inc.errors')
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Lista de horários agendados hoje. &nbsp;&nbsp;</p>

                       
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
                            @foreach($agendamentos as $agendamento)
                                
                           
                            
                            <tr class="row">
                                <td class="col-sm-1 col-xs-1">{{substr($agendamento->horario,0,5)}}</td>
                                <td class="col-sm-9 col-xs-9">{{ $agendamento->pessoa_obj->nome}}</td>
                                                     
                            
                                <td class="col-sm-2 col-xs-2">
                                    
                                        <a href="#" onclick="alterar({{$agendamento->id}},'atendido')" title="Confirmar atendimento">       
                                            <i class=" fa fa-check-square-o text-success "></i></a>
                                        &nbsp;
                                        <a href="#" onclick="alterar({{$agendamento->id}},'faltou')" title="Declarar não comparecimento">       
                                            <i class=" fa fa-thumbs-o-down text=warning "></i></a>
                                        &nbsp;
                                        <a href="#" onclick="alterar({{$agendamento->id}},'cancelado')" title="Cancelar agendamento">       
                                            <i class=" fa fa-times-circle text-danger "></i></a>
                                        &nbsp;
                                         
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    
                                   
                </div>     
            </div>
        </div> 
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Opções</p>
                    </div>
                </div>
                <div class="card-block">
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="#"> Listas de Frequência Anteriores</a>
                    </div>
                -->
                <div class="form-group row"> 
                        <label class="col-sm-4 control-label">Visualizar outra data</label>
                        <div class="col-sm-4 ">
                            
                            <input type="date" class="form-control" readonly>
                        </div>
                        
                    </div>
              
                  
                </div>   
            </div>
        </div>
        
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Criar novo agendamento</p>
                    </div>
                </div>
                <div class="card-block">
                    <form method="POST">
                     
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Nome da pessoa </label>
                            <div class="col-sm-9"> 
                                <input type="text" class="form-control boxed" name="nome" id="search" required> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-2">
                                <ul class="item-list" id="listapessoas"></ul>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Nascimento</label>
                            <div class="col-sm-4"> 
                                <input type="text" class="form-control boxed" name="nascimento" id="nascimento" placeholder="dd/mm/aaaa" required> 
                            </div>
                            <label class="col-sm-2 form-control-label text-xs-right text-secondary">Gênero</label>
                            <div class="col-sm-4"> 
                                
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="M" >
                                        <span>Masc</span>
                                    </label>
                                    <label>
                                        <input class="radio" name="genero" type="radio" value="F">
                                        <span>Fem</span>
                                    </label>
                                    
                                
                            </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label text-xs-right text-secondary">Escolha uma data </label>
                          <div class="col-sm-4"> 
                                
                              <input type="date" class="form-control boxed" name="dia" id="dia" min="{{date('Y-m-d')}}" max="{{$final}}" required> 
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 form-control-label text-xs-right text-secondary">Horário </label>
                          <div class="col-sm-4"> 
                              <select name="horario" id="horarios" class="form-control">
                                <option>Selecione uma data</option>
                
                              </select>
                          </div>
                        
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-9 offset-sm-2">
                            <input type="hidden" name="pessoa" id="pessoa" value="">
                            <button class="btn btn-info" type="submit" name="btn" >Agendar</button> 
                            <button type="reset" name="btn"  class="btn btn-secondary">Limpar</button>
                            <button type="cancel" name="btn" class="btn btn-secondary" onclick="history.back(-1);return false;">Cancelar</button>
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
                                        +'<a href="#" onclick="escolhePessoa(\''+val.id+'\',\''+val.nome+'\',\''+val.nascimento+'\')">'
                                            +val.numero+' - '+val.nascimento+' - '+val.nome
                                        +'</a>'
                                        +'</li>';
                        

                        });
                        //console.log(namelist);
                        $("#listapessoas").html(namelist).show();

                    });

            }

         });


   });


function escolhePessoa(id,nome,nascimento){
    $("#search").val(nome);
    $("#nascimento").val(nascimento);
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
 </script>   
@endsection