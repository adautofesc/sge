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

    </p>
</div>
@include('inc.errors')
<section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="subtitle-block">
                <h3 class="subtitle"> Alunos inscritos </h3>
            </div>
            <div class="card sameheight-item">     
                <div class="card-block">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-xs-12 text-xs">
                            <div class="title-block ">
                                <p class="title-description"> Relação: </p>
                                <br>
                                <ol>
                                    @foreach($inscricoes as $inscricao)
                                    <li>
                                        <button class="btn btn-danger btn-sm" title="Remover esta pessoa da turma" onclick="remover('{{$inscricao->id}}')">
                                            X
                                        </button>
                                        {{$inscricao->pessoa->nome}} 
                                    </li>
                                    @endforeach
                                </ol>
                               
                                
                            </div>

                        </div>
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