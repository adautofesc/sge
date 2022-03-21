@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-11">
            <h3 class="title">Departamento Pedagógico da FESC</h3>
            <p class="title-description">Cursos, Turmas e Projetos</p>
        
                @if(in_array('1',$programas))
                <span  class="badge badge-pill badge-danger">UNIT</span>
                @endif

                @if(in_array('2',$programas))
                <span  class="badge badge-pill badge-info">PID</span>
                @endif

                @if(in_array('3',$programas))
                <span  class="badge badge-pill badge-warning">UATI</span>
                @endif

                @if(in_array('4',$programas))
                <span  class="badge badge-pill badge-info">EMG</span>
                @endif

                @if(in_array('12',$programas))
                <span  class="badge badge-pill badge-success">CE</span>
                @endif
            
            
        </div>
        <div class="col-md-1 text-right">
            
        </div>

    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Turmas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div class="input-group input-group-sm">
                          <input type="text" class="form-control" placeholder="Código da turma" id="turma" maxlength="10" size="2">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="abreTurma();">Consultar</button>
                          </span>
                    </div><!-- /input-group -->
                    <div>
                        <a href="/turmas/listar" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bookmark "></i>
                        &nbsp;&nbsp;Listar</a>
                    </div>
                    <!--
                    <div>
                        <a href="{{route('turmas.cadastrar')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Cadastrar</a>
                    </div>
                     -->
                                       
                                   
                </div>
            </div>  
        </div>
        
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Docentes</p>
                    </div>
                </div>
                <div class="card-block">
                     <div>
                         <ul>
                             @foreach($professores as $professor)
                             <li><a href="/docentes/{{$professor->id}}">{{$professor->nome_simples}}</a></li>
                             @endforeach
                         </ul>
                    </div>

                </div>
            </div>  
        </div>


        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Relatórios</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/relatorios/turmas" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o"></i>
                        &nbsp;&nbsp;Relatório de turmas</a>
                        <a href="/relatorios/carga-docentes" class="btn btn-primary-outline col-xs-12 text-xs-left">
                            <i class=" fa fa-file-text-o"></i>
                            &nbsp;&nbsp;Relatório de educadores</a>
                    </div>

                </div>
            </div>  
        </div>
    </div>

</section>

@endsection
@section('scripts')
<script type="text/javascript">
    function abreTurma(){
        if($("#turma").val()!='')
            location.href = '/turmas/dados-gerais/'+$("#turma").val(),'Mostrar Turma';
        else
            alert('Ops, faltou o código da turma');
    }
</script>
@endsection