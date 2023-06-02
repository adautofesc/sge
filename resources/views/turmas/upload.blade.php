@extends('layout.app')
@section('titulo')Importação de arquivos de turma @endsection
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-7">
            <h3 class="title">Envio de arquivo para importação</h3>
            <p class="title-description">Preencha as turmas automaticamente com a importação de arquivo.</p>
        </div>
    </div>
</div>
@include('inc.errors')
<section class="section">
    <div class="row">
        <div class="col-md-10 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Escolha um arquivo</p>
                    </div>
                </div>
                <div class="card-block">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group row"> 
                            
                            <div class="col-sm-12">  
                                <h5>Instruções Gerais</h5>
                                <div>Aqui pode-se importar de uma planilha XLSX os alunos diretamente para suas turmas, seguindo o modelo que pode ser baixado no botão "Baixar modelo" abaixo. <strong>Ocorreram mudanças no arquivo em 06/2023</strong></div>
                                <div>Endereços menores que 5 caracteres e sem CEP não são cadastrados</div>
                                <div>Após enviar o arquivo os dados poderão ser revisados antes da gravação.</div>
                                <br>
                            </div>
                        </div>
                        <div class="form-group row"> 
                            <label class="col-sm-1 form-control-label text-xs-right">
                                Arquivo
                            </label>
                            <div class="col-sm-11">  
                                <input type="file" required="true" accept=".xlsx" name="arquivo" class="form-control boxed"  placeholder="" maxlength="150"> 
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group row"> 
                            <label class="col-sm-1 form-control-label text-xs-right">
                                
                            </label>
                            <div class="col-sm-11"> 
                                <input class="btn btn-primary" type="submit">
                                <a href="/download/importador_alunos_sge.xlsx" class="btn btn-primary-outline"><i class="fa fa-download"></i> Baixar modelo</a> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
