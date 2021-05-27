@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Departamento de Secretaria da FESC</h3>
            <p class="title-description">Olá, suas opções estão disponíveis abaixo.</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Pessoas</p>
                    </div>
                </div>
                <div class="card-block">
                    @if(isset($pessoa))
                    <div>
                        <a href="/secretaria/atender/{{$pessoa}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Retomar Atendimento</a>
                    </div>
                    @else
                    <div>
                        <a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Retomar Atendimento</a>
                    </div>
                    @endif
                    <div>
                        <a href="/secretaria/pre-atendimento" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Novo Atendimento</a>
                    </div>
                    <div>
                        <a href="/pessoa/cadastrar" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-user "></i>
                        &nbsp;&nbsp;Cadastrar Pessoa</a>
                    </div>
                    <div>
                        <a href="/pessoa/listar" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-group"></i>
                        &nbsp;&nbsp;Lista de Cadastrados</a>
                    </div>
                    
                    <!--
                    <div>
                        <div>
                            <input type="text" name="matricula" size="21" placeholder="Consultar matrícula">
                            <input type="submit" name="send" value="Buscar">
                        </div>
                    </div>
                -->

                </div>                
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Turmas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{route('turmas')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Liberação de Matrículas</a>
                    </div>
                    
                       
                    
                    <div>
                        <a href="/relatorios/turmas" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-plus-circle "></i>
                        &nbsp;&nbsp;Relatórios</a>
                    </div>
                    <div>
                        <a href="{{asset('turmas/importar')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-file-text "></i>
                        &nbsp;&nbsp;Importar alunos de planilha</a>
                    </div>
                    <div class="input-group input-group-sm">
                          <input type="text" class="form-control" placeholder="Código da turma" id="turma" maxlength="10" size="2">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="abreTurma();">Consultar</button>
                          </span>
                    </div><!-- /input-group -->
                
                </div>                
            </div>
        </div>
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Documentos</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="{{asset('/pessoa/atestado/listar')}}" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Lista de atestados</a>
                    </div>
                    <div>
                        <a href="secretaria/upload" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-archive "></i>
                        &nbsp;&nbsp;Enviar documentos em lote</a>
                    </div>
                    <div>
                        <a href="secretaria/processar-documentos" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Processa documentos enviados por FTP para pasta temporária">
                        <i class=" fa fa-cogs "></i>
                        &nbsp;&nbsp;Processar documentos</a>
                    </div>
                    <div>
                        <a href="#" class="btn btn-secondary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-arrow-right "></i>
                        &nbsp;&nbsp;Solicitações Bolsas</a>
                    </div>

            
                
                </div>                
            </div>
        </div> 

    </div>
    <!-- ******************************************************************************************************-->
    <div class="row">
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Matrículas</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/secretaria/matricula/ativar_matriculas_em_espera" class="btn btn-danger-outline col-xs-12 text-xs-left" title="Ativar matriculas que estao em espera. Necessita de credencial.">
                        <i class=" fa fa-play-circle "></i>
                        &nbsp;&nbsp;Ativar Matrículas</a>
                    </div>
                    <div>
                        <a href="/secretaria/matricula/uploadglobal/1/1/0/0" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-files-o"></i>
                        &nbsp;&nbsp; Enviar termos digitalizados</a>
                    </div>
                    <div>
                        <a href="/documentos/formularios/desistencia.pdf" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-file-text"></i>
                        &nbsp;&nbsp; Termo de desistência</a>
                    </div>
                     <div class="input-group input-group-sm">
                          <input type="text" class="form-control" id="matricula" placeholder="Códigos separados por vírgula" maxlength="10">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" onclick="abreMatricula();">Consultar</button>
                          </span>
                    </div><!-- /input-group -->
            
                
                </div>                
            </div>
        </div> 
        <div class="col-md-4 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Ferramentas de Gerenciamento EAD</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/secretaria/alunos" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Mostra alunos inscritos nas turmas EAD">
                        <i class=" fa fa-play-circle "></i>
                        &nbsp;&nbsp;Controle de E-mails e Teams</a>
                    </div>
                    <div>
                        <a href="/secretaria/alunos-cancelados" class="btn btn-primary-outline col-xs-12 text-xs-left" title="Mostra alunos a serem cancelados nas turmas EAD">
                        <i class=" fa fa-play-circle text-danger"></i>
                        &nbsp;&nbsp;Cancelamentos de E-mails e Teams</a>
                    </div>
                    <div>
                        <a href="https://admin.microsoft.com" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-files-o"></i>
                        &nbsp;&nbsp; Administração Office365 (usuários)</a>
                    </div>
                    <div>
                        <a href="https://admin.teams.microsoft.com/" target="_blank" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class="fa fa-file-text"></i>
                        &nbsp;&nbsp; Administração Teams</a>
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
            location.href = '/turmas/'+$("#turma").val();
        else
            alert('Ops, faltou o código da turma');
    }
    function abreMatricula(){
        if($("#matricula").val()!='')
            location.href = '/secretaria/matricula/'+$("#matricula").val();
        else
            alert('Ops, faltou o código da turma');
    }
</script>
@endsection