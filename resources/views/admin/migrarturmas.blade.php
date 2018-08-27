@extends('layout.app')
@section('pagina')
<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title"> Migração de cursos         
                    



                </h3>
                <p class="title-description"> Lista de Cursos e Atividades cadastradas em 2017 </p>
            </div>
        </div>
    </div>
    @include('inc.errors')
    
</div>
<form method="POST">
@if(isset($db_turmas) && count($db_turmas))
<div class="card items">
    {{csrf_field()}}
    <ol>
   @foreach($db_turmas as $turma_nvk)
   <li>
    <div>
        {{$turma_nvk->TurCod}}.{{$turma_nvk->CurDsc}}
        <br>
        {{$turma_nvk->TurDsc}} ({{$turma_nvk->LocCod}})- {{$turma_nvk->ProCod}}  
    </div>
    <select name="turma[{{$turma_nvk->TurCod}}]">

        <option value="0" selected >Selecione uma turma para migrar alunos</option>
        @foreach($nova as $turma)
        <option value="{{$turma->id}}">
            {{$turma->id}}.{{$turma->curso->nome}} - {{implode(',',$turma->dias_semana)}} - {{$turma->hora_inicio}} @ {{$turma->local->sigla}}
        </option>
        @endforeach

    </select>
    <br><br>
    </li>
    @endforeach
</div>
</ol>
<button type="submit">Avançar</button>



@else
<h3 class="title-description"> =( Nenhum curso encontrado. </p>
@endif
</h3>
</div>
</form>

@endsection
@section('scripts')
<script>

</script>
@endsection


