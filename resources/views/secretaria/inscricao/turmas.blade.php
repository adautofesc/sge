 @extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Nova Matrícula</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$pessoa->nome}}</h3>
</div>
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Esta é sua programação atual: </h3>
    </div>
   <!-- Tab panes -->
    <div class="row">
     
        <div class="col" >
            <div class="title">Seg.</div>
            @foreach($turmas as $turma)
            @if(in_array('seg',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}" >Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Ter.</div>
            @foreach($turmas as $turma)
            @if(in_array('ter',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}" >Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
            
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Qua.</div>
            @foreach($turmas as $turma)
            @if(in_array('qua',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Qui.</div>
            @foreach($turmas as $turma)
            @if(in_array('qui',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Sex.</div>
            @foreach($turmas as $turma)
            @if(in_array('sex',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="title">Sab.</div>
            @foreach($turmas as $turma)
            @if(in_array('sab',$turma->dias_semana))
            <div class="box-placeholder turma{{$turma->id}}">Turma {{$turma->id}} das {{$turma->hora_inicio}} ~ {{$turma->hora_termino}} - {{ $turma->disciplina===null? $turma->curso->nome : $turma->curso->nome.' - '.$turma->disciplina->nome}} em {{$turma->local->sigla}} com <small>{{$turma->professor->nome_simples}}</small></div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<div class="card card-block">
    <!-- Nav tabs -->
    <div class="card-title-block">
        <h3 class="title"> Itens escolhidos </h3>
    </div>
    <!-- Tab panes -->
    <div class="row">
        <div class="col-xl-12" id="itens_escolhidos" > 
           
        </div>
            
        
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
var itens;
$(document).ready(function(){
    listar(itens=0);

});
function addItem(turma){
    var itensAtuais=itens.toString().split(',');
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

    $('#turmas').load('{{asset('/secretaria/turmas-disponiveis')}}/'+itens_atuais+'{{$str_turmas}}/0');
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
</script>



@endsection