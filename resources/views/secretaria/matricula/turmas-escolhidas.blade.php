@foreach($turmas as $turma)
<div class="col-xl-12" ><a href="#" title="Remover" onclick="rmItem({{$turma->id}});"><span class="fa fa-times alert-danger"></span></a> {{implode($turma->dias_semana,', ')}} - {{$turma->hora_inicio}} às {{$turma->hora_termino}} - <small>{{$turma->curso->nome}} Prof. {{$turma->professor->nome_simples}}</small> </div>
@endforeach
<div class="title">&nbsp;</div>
<div class="title">Total: R$ {{$valor}}</div>