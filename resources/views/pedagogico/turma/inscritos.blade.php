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


   
@endsection
