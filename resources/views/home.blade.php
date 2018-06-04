@extends('layout.app')
@section('pagina')

<div class="title-block">
    <div class="row">
        <div class="col-md-6">
            <h3 class="title">Bem vindo !!!</h3>
            <p class="title-description">{{ $dados['data']}}</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Departamentos disponíveis:</p>
                    </div>
                </div>
                <div class="card-block">
                    <div>
                        <a href="/administrativo/" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-bar-chart-o "></i>
                        &nbsp;&nbsp;Administrativo</a></div>
                    <div>
                        <a href="/docentes/" class="btn btn-primary-outline col-xs-12 text-xs-left">
                        <i class=" fa fa-th-large "></i>
                        &nbsp;&nbsp;Docentes</a></div>
                    <div><a href="/financeiro" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-usd"></i>&nbsp;&nbsp;Financeiro</a></div>
                    <div><a href="/gestaopessoal" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-users"></i>&nbsp;&nbsp;Gestão Pessoal</a></div>
                    <div><a href="/pedagogico" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-th-list"></i>&nbsp;&nbsp;Pedagógico</a></div>
                    <div>
                        <a href="{{asset("/secretaria")}}" class="btn btn-primary-outline col-xs-12 text-xs-left"><i class="fa fa-stack-overflow"></i>&nbsp;&nbsp;Secretaria</a>
                    </div>
 
                </div>
            </div> 


        </div>
        <div class="col-md-5 center-block">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title" style="color:white">Atualizações do sistema</p>
                    </div>
                </div>
                <div class="card-block">

                    <div class="text-xs-left">
                        <ul>
                            <li><i class="fa fa-flask"></i> Trabalhando na finalização de turmas e intergração com chamada digital em planilha do Google </li>
                            <li><i class="fa fa-bug"></i> 23/05 - corrigido cadastro e alteração de turmas: não exibia disciplinas em cursos de apenas uma disciplina</li>
                            <li><i class="fa fa-asterisk"></i> 23/05 - Adicionados filtros na listagem de turmas no setor secretário</li>
                            <li><i class="fa fa-asterisk"></i> 21/05 - Adicionados filtros na listagem de turmas no setor pedagógico</li>
                            <li><i class="fa fa-asterisk"></i> 14/05 - Adicionada ferramenta de rematrícula .</li>
                            <li><i class="fa fa-bug"></i> 11/05 - Corrigida edição de pessoa.</li>
                        </ul>
                    </div>
 
                </div>
            </div> 


        </div>
    </div>
</section>

@endsection