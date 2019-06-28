@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento Pedagógico da FESC</h3>
            <p class="title-description">Cursos, Turmas e Projetos</p>
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
                        <a href="{{route('turmas')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bookmark "></i>
                        &nbsp;&nbsp;Listar</a>
                    </div>
                    <div>
                        <a href="{{route('turmas.cadastrar')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Cadastrar</a>
                    </div>
                    <div>
                        <a href="{{route('turmas.expiradas')}}" class="btn btn-danger-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-minus-square "></i>
                        &nbsp;&nbsp;Encerrar Expiradas</a>
                    </div> 
                                       
                                   
                </div>
            </div>  
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Cursos / Atividades</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/pedagogico/cadastrarcurso')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Cadastrar</a>
                    </div>
                    <div>
                        <a href="{{asset('pedagogico/cursos')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-toggle-right  "></i>
                        &nbsp;&nbsp;Cursos/atividades</a></div>
                    
                    <div>
                        <a href="{{asset('pedagogico/disciplinas')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-toggle-down "></i>
                        &nbsp;&nbsp;Disciplinas</a>
                    </div>
                    <div>
                        <a href="{{asset('pedagogico/cursos/requisitos')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-check-square-o "></i>
                        &nbsp;&nbsp;Requisitos</a>
                    </div>
                    <div>
                        <p class="btn btn-secondary col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text-o "></i>
                        &nbsp;&nbsp;Projetos</p>
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
                        <a href="#" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-table "></i>
                        &nbsp;&nbsp;Em construção</a>
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
            window.open('/turma/'+$("#turma").val(),'Mostrar Turma');
        else
            alert('Ops, cadê o código da turma?');
    }
</script>
@endsection