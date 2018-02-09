@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Relação de Matrículas</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle">{{$nome}}</h3>
</div>

@foreach($matriculas as $matricula)
@if($matricula->status=='ativa')
<div class="card card-success">
  <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> Matrícula: {{$matricula->id}} Realizada em {{date('d/m/Y - H:i ', strtotime($matricula->created_at))}}.
@elseif($matricula->status=='pendente')
<div class="card card-warning"> 
  <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> !!! Pendente !!! Matrícula: {{$matricula->id}} Realizada em {{date('d/m/Y - H:i ', strtotime($matricula->created_at))}}. 
@elseif($matricula->status=='cancelada')
<div class="card card-danger"> 
  <div class="card-header">
        <div class="header-block">
        <p class="title" style="color:white"> !!! Cancelada !!! Matrícula: {{$matricula->id}} Realizada em {{date('d/m/Y - H:i ', strtotime($matricula->created_at))}}. - 
@endif

    
        @if(count($matricula->inscricoes)>0) 
        {{$matricula->inscricoes->first()->turma->curso->nome}}
        @else
        Nenhuma inscrição para essa matrícula
        @endif
        </p>
        </div>
    </div>

    <div class="card-block">
      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Insc.</th>
                <th scope="col">Curso/Disciplina</th>
                <th scope="col">Professor</th>
                <th scope="col">Dia(s)</th>
                <th scope="col">Horário</th>
                <th scope="col">Local</th>
                <th scope="col">Inicio</th>
                <th scope="col">Opção</th>

              </tr>
            </thead>
            <tbody>
          @if(count($matricula->inscricoes)>0) 
          @foreach($matricula->inscricoes as $inscricao)
          @if($inscricao->status!='cancelado')
          <tr>
          @else
          <tr class="text-danger">
          @endif
            <td scope="row" title="Número da inscrição" >{{$inscricao->id}}</td>
            @if($inscricao->turma->disciplina==null)
            <td>{{$inscricao->turma->curso->nome}}</td>
            @else
            <td>{{$inscricao->turma->disciplina->nome}}</td>
            @endif
            <td>{{$inscricao->turma->professor->nome_simples}}</td>
            <td>{{implode(', ',$inscricao->turma->dias_semana)}}</td>
            <td>{{$inscricao->turma->hora_inicio}}/{{$inscricao->turma->hora_termino}}</td>
            <td>{{$inscricao->turma->local->sigla}}</td>
            <td>{{$inscricao->turma->data_inicio}}</td>
            <td><a href=# class="btn btn-danger-outline col-xs-12" onclick="remover('{{$inscricao->id}}')" title="Cancelar Atividade"> X </a></td>
          </tr>
         
          @endforeach
          @endif
        </tbody>
        </table>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3"><a href="{{asset('/secretaria/matricula/editar/').'/'.$matricula->id}}" class="btn btn-primary-outline col-xs-12">Editar</a></div>
        <div class="col-md-3"><a href="{{asset('/secretaria/matricula/termo/').'/'.$matricula->id}}" target="_blank" class="btn btn-info-outline col-xs-12">Imprimir Termo</a></div>
        <div class="col-md-3"><a href="#" onclick="cancelar({{$matricula->id}});" class="btn btn-warning-outline col-xs-12" title="Cancelar Matrícula">Cancelar Matrícula</a></div>
        <div class="col-md-3"><a href="{{asset('/secretaria/matricula/nova')}}" class="btn btn-success-outline col-xs-12">Adicionar disciplinas</a></div>
      </div>

    </div>
</div>
@endforeach

@endsection
@section('scripts')
<script>
  function remover(inscricao){
    if(confirm('Tem certeza que deseja cancelar esta inscrição?'))
        window.location.replace("{{asset('secretaria/matricula/inscricao/apagar')}}/"+inscricao);
  }
  function cancelar(matricula){
    if(confirm('Tem certeza que deseja cancelar esta matrícula?'))
        window.location.replace("{{asset('/secretaria/matricula/cancelar/')}}/"+matricula);
  }
</script>
@endsection