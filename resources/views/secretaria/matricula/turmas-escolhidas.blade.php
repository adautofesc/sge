@foreach($turmas as $turma)
<div class="col-xl-12" >{{implode($turma->dias_semana,', ')}} - {{$turma->hora_inicio}} às {{$turma->hora_termino}} - <small>{{$turma->curso->nome}} Prof. {{$turma->professor->nome_simples}}</small> <a href="#" onclick="rmItem({{$turma->id}});">remover</a></div>
@endforeach
<div class="title">&nbsp;</div>
<div class="title">Total: R$ {{$valor}}</div>