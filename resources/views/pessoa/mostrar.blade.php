@extends('layout.app')
@section('pagina')

<!-- ********************************************************************************** tab -->
 <div class="title-block">
    <h3 class="title">Visualização de informações<span ></span> </h3>
</div> @include('inc.errors')  
 @if(isset($pessoa['id']))
<div class="subtitle-block">
    <h3 class="subtitle"><small>Dados de: </small> {{$pessoa['nome']}}</h3>
</div>


    <section class="section">
    <div class="row ">
        <div class="col-xl-12">
            <div class="card sameheight-item">
                <div class="card-block">
                    <!-- Nav tabs     sameheight-container(row)  -->
                    
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item"> <a href="" class="nav-link active" data-target="#geral" data-toggle="tab" aria-controls="geral" role="tab">Dados Gerais</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#academicos" aria-controls="academicos" data-toggle="tab" role="tab">Acadêmicos</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#clinicos" aria-controls="clinicos" data-toggle="tab" role="tab">Clínicos</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#contato" aria-controls="contato" data-toggle="tab" role="tab">Contato</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#financeiros" aria-controls="financeiros" data-toggle="tab" role="tab">Financeiros</a> </li>
                        <li class="nav-item"> <a href="" class="nav-link" data-target="#obs" aria-controls="obs" data-toggle="tab" role="tab">Obs</a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs-bordered">

                        <!-- Geral ****************************************************************************************** -->
                        <div class="tab-pane fade in active" id="geral">

                            
                                <div class="row"> 
                                    <div class="col-xs-10">
                                        <a href="pessoas_add.php" class="btn btn-secondary btn-sm rounded-s"> Adicionar dependente </a>
                                        <a href="pessoas_add.php" class="btn btn-secondary btn-sm rounded-s"> Adicionar responsável</a>
                                        <a href="pessoas_add.php" class="btn btn-secondary btn-sm rounded-s"> Adicionar responsável financeiro</a>                                         
                                    </div>                                           
                                    <div class="col-xs-2 text-xs-right">                                        
                                        <a href="{{asset('/pessoa/editar/geral').'/'.$pessoa['id']}}" class="btn btn-primary btn-sm rounded-s"> Editar </a>
                                    </div>
                                </div>  


                                <section class="card card-block">
                                <div class="form-group row">
        
                                    <label class="col-sm-2 form-control-label text-xs-right">Nascimento</label>
                                    <div class="col-sm-3">
                                        {{$pessoa['nascimento']}} ({{$pessoa['idade']}} anos)
                                    </div>
                                    @if(isset($pessoa['telefone']))
                                    <label class="col-sm-2 form-control-label text-xs-right">Telefone</label>
                                    <div class="col-sm-3"> 
                                        {{$pessoa['telefone']}}
                                    </div>
                                    @endif
                                </div>                                   
                                <div class="form-group row"> 
                                    <label class="col-sm-2 form-control-label text-xs-right">Gênero</label>
                                    <div class="col-sm-10"> 
                                        {{$pessoa['genero']}}
                                    </div>
                                </div>
                                @if(isset($pessoa['nome_registro']))
                                <div class="form-group row"> 
                                    <label class="col-sm-2 form-control-label text-xs-right">Nome Registro</label>
                                    <div class="col-sm-10"> 
                                        {{$pessoa['nome_registro']}}
                                    </div>
                                </div>    
                                @endif    
                                <div class="form-group row">
                                     @if(isset($pessoa['rg']))
                                    <label class="col-sm-2 form-control-label text-xs-right">RG</label>
                                    <div class="col-sm-3"> 
                                        {{$pessoa['rg']}}
                                    </div>
                                    @endif
                                    @if(isset($pessoa['cpf']))
                                    <label class="col-sm-2 form-control-label text-xs-right">CPF</label>
                                    <div class="col-sm-3"> 
                                        {{ $pessoa['cpf'] }}
                                    </div>
                                    @endif                                  
                                </div> 
                                <div class="form-group row">
                                     @if(isset($pessoa['username']))
                                    <label class="col-sm-2 form-control-label text-xs-right">Usuário</label>
                                    <div class="col-sm-3"> 
                                        {{$pessoa['username']}} <a href="{{asset('/pessoa/redefinir-senha/'.$pessoa['id']) }}" class="btn btn-primary btn-sm rounded-s"> Ver Credenciais </a>
                                    </div>                                 
                                    
                                    <label class="col-sm-2 form-control-label text-xs-right">Senha</label>
                                    <div class="col-sm-3"> 
                                        <a href="{{asset('/pessoa/acesso-recursos/'.$pessoa['id']) }}" class="btn btn-secondary btn-sm rounded-s"> Redefinir senha </a>

                                    </div>
                                    @else
                                    <label class="col-sm-3 form-control-label text-xs-right">Acesso ao sistema</label>
                                    <div class="col-sm-3"> 
                                        <a href="{{asset('/pessoa/cadastraracesso/').'/'.$pessoa['id']}}" class="btn btn-primary btn-sm rounded-s"> Cadastrar usuário </a>
                                    </div>
                                    @endif                                  
                                </div> 
                                @if(count($pessoa['dependentes']))
                                <div class="form-group row"> 
                                    <label class="col-sm-2 form-control-label text-xs-right">Dependentes</label>
                                    <div class="col-sm-10"> 
                                        @foreach($pessoa['dependentes'] as $dependente)
                                        <a href="{{asset('/pessoa/mostrar/'.$dependente->valor)}}" target="_blank">{{$dependente->nome}}</a>
                                        <a href="{{asset('/pessoa/remover-dependente/'.$dependente->valor) }}" class="btn btn-secondary btn-sm rounded-s"> Remover </a><br>
                                        @endforeach
                                    </div>
                                </div>    
                                @endif 
                                @if(isset($pessoa['responsavel']))
                                <div class="form-group row"> 
                                    <label class="col-sm-2 form-control-label text-xs-right">Responsável:</label>
                                    <div class="col-sm-10"> 
                                        <a href="{{asset('/pessoa/mostrar/'.$pessoa->responsavel)}}" target="_blank">{{$pessoa['nomeresponsavel']}}</a>
                                        <a href="{{asset('/pessoa/remover-responsavel/'.$pessoa->responsavel) }}" class="btn btn-secondary btn-sm rounded-s"> Remover </a>

                                    </div>
                                </div>    
                                @endif 
                                @if(isset($pessoa['responsavel_financeiro']))
                                <div class="form-group row"> 
                                    <label class="col-sm-2 form-control-label text-xs-right">Responsável Financeiro</label>
                                    <div class="col-sm-10"> 
                                        <a href="{{asset('/pessoa/mostrar/'.$pessoa->responsavel_financeiro)}}" target="_blank">{{$pessoa['nomeresponsavel_financeiro']}}</a>
                                        <a href="{{asset('/pessoa/remover-responsavel-financeiro/'.$pessoa->responsavel_financeiro) }}" class="btn btn-secondary btn-sm rounded-s"> Remover </a>
                                    </div>
                                </div>    
                                @endif 
                                <div class="form-group row"> 
                                    <label class="col-sm-2 form-control-label text-xs-right">
                                        Histórico de atendimento:
                                    </label>
                                    <div class="col-sm-10">

                                       
                                        {{$pessoa['cadastro']}}
                                       
                                    </div>
                                </div>     
                            </section>
                        </div>


                        <!-- Acadêmicos ************************************************************************************* -->
                        <div class="tab-pane fade" id="academicos">

                            <section class="card card-block">
                            Sem dados para exibir neste momento
                            </section>
                        </div>


                        <!-- // Contato *********************************************************************************** -->
                        <div class="tab-pane fade" id="contato">
                            <div class="row"> 
                                    <div class="col-xs-6">
                                        <a href="pessoas_add.php" class="btn btn-secondary btn-sm rounded-s"> Adicionar Informação </a>
                                        <a href="pessoas_add.php" class="btn btn-secondary btn-sm rounded-s"> Vincular endereço</a>                                        
                                    </div>                                           
                                    <div class="col-xs-6 text-xs-right">                                        
                                        <a href="pessoas_add.php" class="btn btn-primary btn-sm rounded-s"> Editar </a>
                                    </div>
                                </div> 


                          <section class="card card-block">
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">E-mail</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['email']))
                                     {{ $pessoa['email'] }}
                                    @endif                                    
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone alternativo</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['telefone_alternativo']))
                                     {{ $pessoa['telefone_alternativo'] }}
                                    @endif 
                                </div>
                                <label class="col-sm-2 form-control-label text-xs-right">Telefone de um contato</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['telefone_contato']))
                                     {{ $pessoa['telefone_contato'] }}
                                    @endif 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Logradouro</label>
                                <div class="col-sm-10"> 
                                    @if(isset($pessoa['logradouro']))
                                     {{ $pessoa['logradouro'] }}
                                    @endif 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Número</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['end_numero']))
                                     {{ $pessoa['end_numero'] }}
                                    @endif 
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">Complemento</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['end_complemento']))
                                     {{ $pessoa['end_complemento'] }}
                                    @endif 
                                    
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Bairro</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['bairro']))
                                     {{ $pessoa['bairro'] }}
                                    @endif 
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">CEP</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['cep']))
                                     {{ $pessoa['cep'] }}
                                    @endif 
                                </div>  
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label text-xs-right">Cidade</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['cidade']))
                                     {{ $pessoa['cidade'] }}
                                    @endif 
                                </div>  
                                <label class="col-sm-2 form-control-label text-xs-right">Estado</label>
                                <div class="col-sm-4"> 
                                    @if(isset($pessoa['estado']))
                                     {{ $pessoa['estado'] }}
                                    @endif 
                                </div>  
                            </div>

                          </section> 
                        </div>

                        <!-- Clinicos *********************************************************************************** -->
                    
                        <div class="tab-pane fade" id="clinicos">
                            <div class="row"> 
                                    <div class="col-xs-6">
                                        <a href="pessoas_add.php" class="btn btn-primary btn-sm rounded-s"> Adicionar Atestado</a>
                                        <a href="pessoas_add.php" class="btn btn-secondary btn-sm rounded-s"> Adicionar Informação</a>
                                                                               
                                    </div>                                           
                                    <div class="col-xs-6 text-xs-right">                                        
                                        <a href="pessoas_add.php" class="btn btn-primary btn-sm rounded-s"> Editar </a>
                                    </div>
                                </div> 

                            <section class="card card-block">
                                    <div class="form-group row"> 
                                            <label class="col-sm-4 form-control-label text-xs-right">Necesssidades especiais</label>
                                            <div class="col-sm-8"> 
                                                @if(isset($pessoa['necessidade_especial']))
                                                {{ $pessoa['necessidade_especial'] }}
                                                @else
                                                <p>Não possui</p>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group row"> 
                                            <label class="col-sm-4 form-control-label text-xs-right">Medicamentos uso contínuo</label>
                                            <div class="col-sm-8"> 
                                                @if(isset($pessoa['medicamentos_continuos']))
                                                {{ $pessoa['medicamentos_continuos'] }}
                                                @else
                                                <p>Não possui</p>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group row"> 
                                            <label class="col-sm-4 form-control-label text-xs-right">Alergias</label>
                                            <div class="col-sm-8"> 
                                                @if(isset($pessoa['alergias']))
                                                {{ $pessoa['alergias'] }}
                                                @else
                                                <p>Não possui</p>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group row"> 
                                            <label class="col-sm-4 form-control-label text-xs-right">Doença crônica</label>
                                            <div class="col-sm-8"> 
                                                @if(isset($pessoa['doenca_cronica']))
                                                {{ $pessoa['doenca_cronica'] }}
                                                @else
                                                <p>Não possui</p>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="form-group row"> 
                                            <label class="col-sm-4 form-control-label text-xs-right">Atestados médicos</label>
                                            <div class="col-sm-8">
                                                01/02/2017 por Fulano Valido até 22/08/2017<br>
                                                01/02/2017 por Fulano Valido até 22/08/2017<br>
                                                01/02/2017 por Fulano Valido até 22/08/2017<br>
                                                01/02/2017 por Fulano Valido até 22/08/2017<br>


                                            </div>


                                     


                                    </div>
                           </section>
                     
                        </div>
                        <div class="tab-pane fade" id="financeiros">
                            <section class="card card-block">
                                <p>Sem dados no momento</p>
                            </section>

                         
                        </div>
                        <div class="tab-pane fade" id="obs">
                            <section class="card card-block">
                                @if(isset($pessoa['obs']))
                                    {{ $pessoa['obs'] }}
                                @else
                                    <p>Sem dados no momento</p>
                                @endif
                                

                            </section>
@endif
                         
                        </div>

                            
                        
                    </div>
                </div><!-- /.card-block -->
                
            </div><!-- /.card -->
            
        </div><!-- /.col-xl-6 -->
     
    </div><!-- /.row -->
</section>


@endsection