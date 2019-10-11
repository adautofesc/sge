<aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <div class="brand">
                                <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div>SGE <i>FESC</i></div>
                        </div>



                      
                        <nav class="menu">
                            <ul class="nav metismenu" id="sidebar-menu">
                                <li class="active" >
                                    <a href="{{asset('/')}}"> <i class="fa fa-home"></i> Home </a>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Atendimento </a>
                                    <ul>
                                        <li ><a href="{{asset('/secretaria/pre-atendimento')}}"> <i class="fa fa-angle-right"></i> Novo atendimento </a></li>
                                        @if(session('pessoa_atendimento'))
                                        <li ><a href="{{asset('/secretaria/atender/'.session('pessoa_atendimento'))}}"> <i class="fa fa-angle-right"></i> Continuar atendimento </a></li>
                                        @endif
                                        <li ><a href="{{asset('/pessoa/cadastrar')}}"> <i class="fa fa-angle-right"></i> Cadastrar nova pessoa </a></li>
                                        <li ><a href="{{asset('/pessoa/biometria')}}"> <i class="fa fa-angle-right"></i> Cadastrar biometria </a></li>
                                        <li ><a href="{{asset('/pessoa/foto')}}"> <i class="fa fa-angle-right"></i> Cadastrar foto </a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Almoxarife </a>
                                    <ul>
                                        <li >  <a href="{{asset('/almoxarife')}}"> <i class="fa fa-angle-right"></i> Itens </a>   </li>
                                        <li >  <a href="{{asset('/almoxarife')}}"> <i class="fa fa-angle-right"></i> Estoque </a> </li>
                                        <li >  <a href="{{asset('/almoxarife')}}"> <i class="fa fa-angle-right"></i> Entrada </a> </li>
                                        <li >  <a href="{{asset('/almoxarife')}}"> <i class="fa fa-angle-right"></i> Saída </a>   </li>
                                        <li >  <a href="{{asset('/almoxarife')}}"> <i class="fa fa-angle-right"></i> Relatórios </a>   </li>
                                    </ul>
                                </li>


                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Agendamento de salas </a>
                                    <ul>
                                        <li > <a href="{{asset('/agendamento-salas')}}"> <i class="fa fa-angle-right"></i> Agenda de salas </a> </li>
                                        <li > <a href="{{asset('/eventos')}}"> <i class="fa fa-angle-right"></i> Eventos/locações </a></li>
                                        <li > <a href="{{asset('/eventos/inscricoes')}}"> <i class="fa fa-angle-right"></i> Inscrições em eventos </a> </li>
                                    </ul>
                                </li>


                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Boletos </a>
                                    <ul>
                                        <li>
                                            <a href="#"> <i class="fa fa-angle-right"></i> Cobranças </a>
                                            <ul>
                                                <li><a href="/financeiro/relatorios/cobranca-sms">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Gerar SMS</a></li>
                                                <li><a href="/financeiro/relatorios/cobranca-xls">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Gerar Planilha</a></li>
                                                <li><a href="#" title="XML para envio aos correios">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Gerar XML</a></li>
                                                <li><a href="#">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Gerar PDF</a></li> 
                                            </ul>
                                        </li>
                                        <li > <a href="{{asset('/financeiro/boletos/informacoes')}}"> <i class="fa fa-angle-right"></i> Dados do Boleto </a></li>   
                                        <li > <a href="{{asset('/financeiro/carne/gerar')}}"> <i class="fa fa-angle-right"></i> Gerar Carnês </a>   </li>
                                        <li >   
                                            <a href=""> <i class="fa fa-angle-right"></i> Remessas </a>
                                            <ul>
                                                <li><a href="/financeiro/boletos/remessa/gerar" title="cuidado que ele gera de imediato">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Gerar Arquivo</a></li>
                                                <li><a href="/financeiro/boletos/remessa/listar-arquivos">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Arquivos Gerados</a></li>
                                                <li><a href="#">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                              
                                            </ul>
                                        </li>
                                        <li >   
                                            <a href=""> <i class="fa fa-angle-right"></i> Retornos </a>
                                            <ul>
                                                <li><a href="/financeiro/boletos/retorno/upload">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Enviar Arquivos</a></li>
                                                <li><a href="/financeiro/boletos/retorno/arquivos">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Processar Arquivos</a></li>
                                                <li><a href="/financeiro/boletos/retorno/processados">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Arquivos Processados</a></li>
                                                <li><a href="/financeiro/boletos/retorno/com-erro">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Arquivos com Erro</a></li>
                                                <li><a href="#">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                                
                                            </ul>
                                        </li>
                                        <li>
                                            <a href=""> <i class="fa fa-angle-right"></i> Relatórios </a>
                                            <ul>
                                                <li><a href="#">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> A receber</a></li>
                                                <li><a href="/financeiro/relatorios/boletos">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Atrasados</a></li>
                                                <li><a href="#">&nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"><i class="fa fa-angle-right"></i> </i> Pagos</a></li> 
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Bolsas de estudos</a>
                                    <ul>
                                        <li><a href="/juridico/bolsas/liberacao"> <i class="fa fa-angle-right"></i> </i> Listagem </a></li>
                                        <li><a href="/relatorios/bolsas/"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                        
                                    </ul>
                                </li> 
                                
                                
                                
                                <li>
                                    <a href="" class="text-white"> <i class="fa fa-angle-right"></i> Compras </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Cotaçoes</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Licitações </a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Empenhos</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Caixa pequeno</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>  
                                    </ul>
                                </li>
                                
                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Comunicação </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Avisos</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Email institucional</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Lista telefônica</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Portarias/Resoluções</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Contratos </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Cadastrar</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Cursos </a>
                                    <ul>
                                        <li><a href="/pedagogico/cursos"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="/pedagogico/cadastrarcurso"> <i class="fa fa-angle-right"></i> </i> Cadastrar</a></li>
                                        <li><a href="/pedagogico/disciplinas"> <i class="fa fa-angle-right"></i> </i> Disciplinas</a></li>
                                        <li><a href="/pedagogico/cursos/requisitos"> <i class="fa fa-angle-right"></i> </i> Requisitos</a></li>
                                    </ul>
                                </li>


                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Dívida ativa </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Refis</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Inscrições</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Livros</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Documentos </a>
                                    <ul>
                                        <li><a href="/pessoa/atestado/listar"> <i class="fa fa-angle-right"></i> </i> Atestados</a></li>
                                        <li><a href="/juridico/bolsas/liberacao"> <i class="fa fa-angle-right"></i> </i> Bolsas</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Cancelamentos</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Inscrições</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Matrículas</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Enviar documentos</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Processar documentos</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Eventos </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Cadastrar</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Inscrições</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Institucional </a>
                                    <ul>
                                          
                                        <li><a href="/administrativo/locais"> <i class="fa fa-angle-right"></i> </i> Unidades</a></li>
                                        <li><a href="/administrativo/locais"> <i class="fa fa-angle-right"></i> </i> Salas</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Mapas</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Telefones</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Dados técnicos</a></li>
                                    
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Matrículas </a>
                                    <ul>
                                    
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Dados</a></li>  
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Cadastrar</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Ferramentas</a></li>
                                    
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Parcerias</a>
                                    <ul>
                                          
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                        
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Patrimônio </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Objetos</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Movimentação</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatório</a></li>
                                    </ul>
                                </li>


                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Processos </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Movimentação</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatório</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Protocolos </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Listagem</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Movimentação</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatório</a></li>
                                    </ul>
                                </li>


                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Servidores </a>
                                    <ul>
                                            <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relações Institucionais</a></li>
                                            <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Dados Administrativos</a></li>
                                            <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatório de Frequencia</a></li>
                                            <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Holerite Online</a></li>
                                            <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Jornadas de trabalho</a></li>
                                            <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Turmas </a>
                                    <ul>
                                        <li><a href="/pedagogico/turmas"> <i class="fa fa-angle-right"></i> </i> Painel 1</a></li>
                                        <li><a href="/secretaria/turmas"> <i class="fa fa-angle-right"></i> </i> Painel 2</a></li>
                                        <li><a href="/pedagogico/turmas/cadastrar"> <i class="fa fa-angle-right"></i> </i> Cadastro</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Concluintes</a></li>
                                        <li><a href="/pedagogico/turmas/importar"> <i class="fa fa-angle-right"></i> </i> Importar alunos</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Valores</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Folheto PDF com vagas</a></li>
                                        <li><a href="/relatorios/turmas"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                        
                                    </ul>
                                </li>
                                <li>
                                    <a href=""> <i class="fa fa-angle-right"></i> Uso Livre </a>
                                    <ul>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Painel</a></li>
                                        <li><a href="#"> <i class="fa fa-angle-right"></i> </i> Relatórios</a></li>
                                    </ul>
                                </li>














                            </ul>
                              
                        </nav>
                    </div>




















                    <footer class="sidebar-footer">
                        <ul class="nav metismenu" id="customize-menu">
                            <li>
                                <ul>
                                    <li class="customize">
                                        <div class="customize-item">
                                            <div class="row customize-header">
                                                <div class="col-xs-4"> </div>
                                                <div class="col-xs-4"> <label class="title">Fixo</label> </div>
                                                <div class="col-xs-4"> <label class="title">Estatico</label> </div>
                                            </div>
                                            <div class="row hidden-md-down">
                                                <div class="col-xs-4"> <label class="title">Menu:</label> </div>
                                                <div class="col-xs-4"> <label>
    				                        <input class="radio" type="radio" name="sidebarPosition" value="sidebar-fixed" >
    				                        <span></span>
    				                    </label> </div>
                                                <div class="col-xs-4"> <label>
    				                        <input class="radio" type="radio" name="sidebarPosition" value="">
    				                        <span></span>
    				                    </label> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4"> <label class="title">Topo:</label> </div>
                                                <div class="col-xs-4"> <label>
    				                        <input class="radio" type="radio" name="headerPosition" value="header-fixed">
    				                        <span></span>
    				                    </label> </div>
                                                <div class="col-xs-4"> <label>
    				                        <input class="radio" type="radio" name="headerPosition" value="">
    				                        <span></span>
    				                    </label> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4"> <label class="title">Rodapé:</label> </div>
                                                <div class="col-xs-4"> <label>
    				                        <input class="radio" type="radio" name="footerPosition" value="footer-fixed">
    				                        <span></span>
    				                    </label> </div>
                                                <div class="col-xs-4"> <label>
    				                        <input class="radio" type="radio" name="footerPosition" value="">
    				                        <span></span>
    				                    </label> </div>
                                            </div>
                                        </div>
                                        <div class="customize-item">
                                            <ul class="customize-colors">
                                                <li> <span class="color-item color-red" data-theme="red"></span> </li>
                                                <li> <span class="color-item color-orange" data-theme="orange"></span> </li>
                                                <li> <span class="color-item color-green active" data-theme=""></span> </li>
                                                <li> <span class="color-item color-seagreen" data-theme="seagreen"></span> </li>
                                                <li> <span class="color-item color-blue" data-theme="blue"></span> </li>
                                                <li> <span class="color-item color-purple" data-theme="purple"></span> </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <a href=""> <i class="fa fa-cog"></i> Personalize </a>
                            </li>
                        </ul>
                    </foter>
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>