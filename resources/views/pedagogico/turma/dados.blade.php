 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title">Turma {{$turma->id}} - 
        @if(!empty($turma->disciplina->nome))
            {{$turma->disciplina->nome}} / 
        @endif
        {{$turma->curso->nome}}

    </h3>
    <p class="title-description">
        @foreach($turma->dias_semana as $dia)
            {{ucwords($dia)}}, 
        @endforeach
        das {{$turma->hora_inicio}} às {{$turma->hora_termino}} - 
        Prof(a). {{$turma->professor->nome_simples}}
        <br>
        <i class="fa fa-{{$turma->icone_status}} icon"></i> Status: {{$turma->status}} . Início em {{$turma->data_inicio}} Término em {{$turma->data_termino}}
    </p>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-7 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Alunos inscritos</p>
                    </div>
                </div>

                <div class="card-block">
                   <ol>
                        @foreach($inscricoes as $inscricao)
                        <li>
                            <small>
                            <a hrfe="#" class="btn btn-danger btn-sm" title="Remover esta pessoa da turma" onclick="remover('{{$inscricao->id}}')">
                                <i class=" fa fa-times text-white"></i>
                            </a>
                            <a href="{{asset('/secretaria/atender').'/'.$inscricao->pessoa->id}}" target="_blank" class="btn btn-success btn-sm" title="Abrir tela de atendimento desta pessoa">
                                
                            
                             <b>{{$inscricao->pessoa->nome}}</b></a> 
                             Tel.
                             @foreach($inscricao->telefone as $telefone)
                                 {{$telefone->valor}} |
                                <!-- {{\App\classes\Strings::formataTelefone($telefone->valor)}} | -->
                             @endforeach
                             

                             <small>Cod.{{$inscricao->pessoa->id}} </small>
                         </small>
                        </li>
                        @endforeach
                    </ol>
                    <a href="/turma/{{$turma->id}}"> Acessar turma pelo pedagógico.</a>

                    
                </div>     
            </div>
        </div> 
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Frequência</p>
                    </div>
                </div>
                <div class="card-block">
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;<a href="#"> Listas de Frequência Anteriores</a>
                    </div>
                -->
                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="/lista/{{$turma->id}}" >Lista em branco</a>
                    </div>
                    
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;
                        <a href="/chamada/{{$turma->id}}/0/url" >Frequência digital</a>
                        <a href="/chamada/{{$turma->id}}/1/url"> 1 </a>
                        <a href="/chamada/{{$turma->id}}/2/url"> 2 </a>
                        <a href="/chamada/{{$turma->id}}/3/url"> 3 </a>
                        <a href="/chamada/{{$turma->id}}/4/url"> 4 </a>
                        <a href="/chamada/{{$turma->id}}/0/rel" title="Atualizar"> <i class=" fa fa-refresh"></i> </a>
                        <!--
                        <a href="/chamada/{{$turma->id}}/0/pdf" title="Imprimir"> <i class=" fa fa-print"></i> </a>
                    -->
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        @if(isset($turma->disciplina->id))
                            &nbsp;&nbsp;<a href="/plano/{{$turma->professor->id}}/1/{{$turma->disciplina->id}}" title="Plano de ensino">Plano de ensino</a>
                        @else
                            &nbsp;&nbsp;<a href="/plano/{{$turma->professor->id}}/0/{{$turma->curso->id}}" title="Plano de ensino">Plano de ensino</a>
                        @endif
                    </div>
                    <!--
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitação de equipamentos
                    </div>
                    <div>
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitação de sala de aula extra
                    </div>
                -->
                
                </div>   
            </div>
        </div>
        
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Formulários</p>
                    </div>
                </div>
                <div class="card-block">

                    <div>
                        <i class=" fa fa-arrow-right "></i> 
                        &nbsp;&nbsp;<a href="#" target="_blank" title="Formulário de definição de Turmas e horários">Nenhum documento cadastrado</a>
                    </div>
                  
    
                
                </div>   
            </div>
        </div> 

    </div>
</section>
<br>
<div class="subtitle-block">
    <h3 class="subtitle"> Adicionar Aluno </h3>
</div>
<form name="item" method="POST">
    {{csrf_field()}}
    <div class="card card-block">
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                Nome
            </label>
            <div class="col-sm-8"> 
                <input type="search" id="search"  class="form-control boxed" placeholder="Você pode digitar numero, nome, RG e CPF"> 

                <input type="hidden" id="id_pessoa" name="id_pessoa">
            </div>
            <div class="col-sm-2"> 
                <button class="btn btn-primary" onclick="enviar()">Adicionar</button>
                
            </div>
           
        </div>
        
        <div class="form-group row"> 
            <label class="col-sm-2 form-control-label text-xs-right">
                 
            </label>
            <div class="col-sm-8"> 
                 <ul class="item-list" id="listapessoas">
                 </ul>

                
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
function enviar(){
    event.preventDefault();
    if(!$('#id_pessoa').val()>0){
        alert('Escolha uma pessoa na lista de nomes encontrados.');
        return false;
    }
    if(confirm('Tem certeza que deseja cadastrar esta pessoa na turma?')){
        $('form').submit();
    }
    else
        return false;

}
function remover(inscricao){
    if(confirm('Tem certeza que deseja remover esta inscrição?'))
        window.location.replace("{{asset('secretaria/matricula/inscricao/apagar')}}/"+inscricao);
}

</script>



@endsection