@extends('layout.app')
@section('pagina')
<div class="title-block">
    <h3 class="title"> Confirmação de horários de matrícula</h3>
</div>

@include('inc.errors')
<div class="subtitle-block">
    <h3 class="subtitle"><small>De: </small> {{$pessoa->nome_simples}}</h3>
</div>



<form name="item" method="POST" action="gravar">
    <input type="hidden" name="pendente" value="false">

@foreach($turmas as $turma)

@endforeach
@foreach($cursos as $curso)

 <div class="card card-primary" id="{{$curso->id}}">
                <div class="card-header">
                    <div class="header-block"><!--
                    <a href="#" title="Remover" onclick="rmItem('{{$curso->id}}');"><span class="fa fa-times" style="color: white"></span></a>-->
                    <p class="title" style="color:white"> {{$curso->nome}}</p> 

                    </div>
                </div>


<div class="card card-block">
    @if(count($curso->turmas)>1)
        
        <div class="title-block center">

            @foreach($curso->turmas as $turma)

            <div class="subtitle-block">
                <strong>Disciplina</strong> {{$turma->disciplina->nome}} - <strong>Turma</strong> {{$turma->id}}<br/>
                <strong>Prof.</strong> {{$turma->professor->nome_simples}}<br/>
                <strong>Local</strong> {{$turma->local->nome}}<br/>
                <strong>Início:</strong> {{$turma->data_inicio}} <strong>Término</strong> {{$turma->data_termino}}<br/>
                <strong>Dia(s): </strong>{{implode(', ',$turma->dias_semana)}} <strong> Horários:</strong> {{$turma->hora_inicio}} às {{$turma->hora_termino}}

            </div>
            @endforeach

        </div>
    @else

        <div class="title-block center">
            <h3 class="title"> Turma: {{$curso->turmas->first()->id}}</h3>
        </div>            
            <strong>Prof.</strong> {{$curso->turmas->first()->professor->nome_simples}}<br/>
            <strong>Local</strong> {{$curso->turmas->first()->local->nome}}<br/>
            <strong>Início:</strong> {{$curso->turmas->first()->data_inicio}} <strong>Término</strong> {{$curso->turmas->first()->data_termino}}<br/>

            <strong>Dia(s): </strong>{{implode(', ',$curso->turmas->first()->dias_semana)}} <strong> Horários:</strong> {{$curso->turmas->first()->hora_inicio}} às {{$curso->turmas->first()->hora_termino}}
    @endif

        <input type="hidden" name="pessoa" value="{{$pessoa->id}}" >

</div>
</div>

@endforeach
<input type="hidden" name="turmas" value="{{$turmas_str}}">
{{ csrf_field() }}



                    
                        <div class="card card-block">
                            
                            
                            
                                
                            <div class="form-group row">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit"  class="btn btn-primary">Confirmar Matrícula</button> 
                                    <a href="{{asset('/secretaria/atender')}}" class="btn btn-secondary">Cancelar</a> 
                                    <!-- 
                                    <button type="submit" class="btn btn-primary"> Cadastrar</button> 
                                    -->
                                </div>

                           </div>
                        </div>
                    </form>
@endsection
