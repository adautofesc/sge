 @extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">

                <h3 class="title"> Nova matrícula </h3>

                <p class="title-description"> {{$pessoa->nome}}</p>
            </div>
        </div>
    </div>
</div>

@include('inc.errors')
<div class="card card-block">
    <div class="col-md-5">
        <div class="input-group input-group-lg" style="float:left;">
            <input type="text" class="form-control" name="busca" id ="busca" placeholder="Buscar por turma" onkeypress="enter(event)" title="Você pode procurar pelo código da turma, nome do curso/disciplina, nome do professor, sigla do programa ou dia da semana (os 3 primeiros caracteres).">
            <i class="input-group-addon fa fa-search" onclick="listar(itens)" style="cursor:pointer;"></i>
        </div>
    </div>
</div>

<div class="card card-block">
    <div class="card-title-block">
        <h5 class="title">Esta é sua programação atual: </h5>
        
    </div>
   @foreach(['seg','ter','qua','qui','sex','sab'] as $dia)
    <div class="row"> 
        <div class="col" >
            <div><strong> {{ucwords($dia)}}.</strong></div>
            @foreach($turmas as $turma)
            @if(in_array($dia,$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}" >
                Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>  
    </div>
    @endforeach
</div>
   
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Itens escolhidos </h3>
    </div>
    <!-- Tab panes -->
    <div class="row">
        <div class="col-xl-12" id="itens_escolhidos" > </div>
    </div>
</div>
                    
<form name="item" class="form-inline" method="post" action="./confirmacao">
	<section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block" id="turmas">
                    <!-- Nav tabs -->  
                    
                </div>
                <!-- /.card-block -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-xl-6 -->
        
        <!-- /.col-xl-6 -->
    </div>
</section>
<input type="hidden" name="atividades" value="" id="idatividades">
<input type="hidden" name="turmas_anteriores" value="{{$str_turmas}}">
<input type="hidden" name="pessoa" value="{{$pessoa->id}}">
<div class="card-block">
	<button type="submit" class="btn btn-primary" href="matricula_confirma_cursos.php">Avançar</button>
	
	<button type="reset" class="btn btn-secondary" onclick="recomecar();" >Limpar</button>
</div>
{{ csrf_field() }}
</form>
@endsection
@section('scripts')
<script>
var itens = '';
$(document).ready(function(){
    listar('0');

});
function addItem(turma){
    var itensAtuais=itens.split(',');
    for(var i=0; i<itensAtuais.length;i++){
        if(itensAtuais[i]==turma){
            return true;
            break;
        }
    }
    itens=itens+','+turma;
    listar(itens);

}
function rmItem(turma){
    var itensAtuais=itens.split(',');
    for(var i=0; i<itensAtuais.length;i++){
        if(itensAtuais[i]==turma){
            itensAtuais.splice(i,1);
            break;
        }
    }
    itens=itensAtuais.join();
    listar(itens);

}
function listar(itens_atuais){

    busca = $('#busca').val();
    console.log(busca);
    if(itens_atuais == '')
        itens_atuais = '0';

    $('#turmas').html('carregando...')
    $('#turmas').load('{{asset('/secretaria/turmas-disponiveis')."/".$pessoa->id}}/'+itens_atuais+'{{$str_turmas}}/'+busca);
    $('#itens_escolhidos').load('{{asset('/secretaria/turmas-escolhidas')}}/'+itens_atuais+'');
    $('#idatividades').val(itens_atuais);

    /*
    $.ajax({
    url:'{{asset('/secretaria/turmas-disponiveis')}}' +
        '/'+itens_atuais+'/0',
    type:'GET',
    success: function(data){
           $('#turmas').html(data);
           console.log(data);
        }
    });
    */
}
function recomecar() {
    // body...
    itens=0;
    listar(0);
}
function enter(e){
    if (e.which == 13 || e.keyCode == 13 || e.key == 13) {
        listar(itens);
    }

}
</script>



@endsection