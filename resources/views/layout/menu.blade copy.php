<aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <div class="brand">
                                <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div>SGE <i>FESC</i></div>
                        </div>
                        @if(unserialize(Session('recursos_usuario'))->contains('recurso','18'))
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control boxed rounded-s" name="data" placeholder="Nome, RG ou CPF" value="">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary rounded-s btn-sm" type="submit" title="Filtrar resultados">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        @endif
                        <nav class="menu">
                            <ul class="nav metismenu" id="sidebar-menu">
                                <li  class="active">
                                    <a href="{{asset('/')}}"> <i class="fa fa-home"></i> Home </a>
                                </li>
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','18'))
                                <li  >
                                    <a href=""> <i class="fa fa-stack-overflow"></i> Atendimento </a>
                                    <ul>
                                        <li>
                                                
                                        <a href="{{asset('/secretaria')}}"> <i class="fa fa-home"></i> Home </a>
                                        </li>
                                        <li>
                                        <a href="{{asset('secretaria/pre-atendimento')}}"> <i class="fa fa-asterisk"></i> Novo atendimento</a>
                                        </li>
                                        @if(session('pessoa_atendimento'))
                                        <li>
                                        <a href="{{asset('secretaria/atender').'/'.session('pessoa_atendimento')}}"> <i class="fa fa-arrow-right"></i> Retomar atendimento</a>
                                        </li>
                                        @endif
                                    
                                    </ul>
                                </li>
                                @endif
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','12'))
                                <li  >
                                    <a href="{{asset('/administrativo')}}"> <i class="fa fa-bar-chart-o"></i> Administração </a>
                                </li>
                    
                                <li  >
                                        <a href=""> <i class="fa fa-calendar"></i> Agendamento de salas </a>
                                        <ul>
                                            <li>
                                                <a href="/agendamento-salas"> <i class="fa fa-home"></i> Agenda</a>
                                            </li>
                                            
                                            <li>
                                                <a href="#" title="Eventos de somente um dia"><i class="fa fa-calendar-o icon"></i>&nbsp;Eventos </a>
                                            </li>
                           
                                            <li>
                                                <a href="#"><i class="fa fa-edit icon"></i> Inscrições em eventos</a>
                                            </li>

                                        </ul>
                                    </li>
                                <li  >
                                    <a href=""> <i class="fa fa-home"></i> Institucional </a>
                                    <ul>
                                        <li>
                                        <a href="#"> <i class="fa fa-home"></i> Bairros </a>
                                        </li>
                                        <li>
                                            <a href="{{asset('/administrativo/locais')}}"> <i class="fa fa-home"></i> Unidades/Salas</a>
                                        </li>
                                        <li>
                                            <a href="#"> <i class="fa fa-home"></i> Mapas/Dados</a>
                                        </li>
                                        <li>
                                            <a href="#"> <i class="fa fa-home"></i> Telefones/Contatos</a>
                                        </li>
                
                                    </ul>
                                </li>
                                @endif
                                 @if(unserialize(Session('recursos_usuario'))->contains('recurso','21'))
                                <li  >
                                    <a href="{{asset('/bolsas/liberacao')}}"> <i class="fa fa-heart"></i> Bolsas </a>
                                </li>
                                @endif
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','22'))
                                <li  >
                                    <a href="{{asset('/dev')}}"> <i class="fa fa-flask"></i> Desenvolvimento </a>
                                </li>
                                @endif
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','13'))
                                <li  >
                                    <a href="{{asset('/docentes')}}"> <i class="fa fa-th-large"></i> Docentes </a>
                                </li>
                                @endif
                                
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','24'))
                                <li  >
                                    <a href="{{asset('/financeiro')}}"> <i class="fa fa-usd"></i> Financeiro </a>
                                </li>
                                @endif
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','15'))
                                <li  >
                                    <a href="{{asset('/gestaopessoal')}}"> <i class="fa fa-users"></i> Gestão Pessoal </a>
                                </li>
                                @endif
                            
                                <li  >
                                    <a href="{{asset('/juridico')}}"> <i class="fa fa-bookmark"></i> Jurídico </a>
                                </li>
                        
                                @if(unserialize(Session('recursos_usuario'))->contains('recurso','17'))
                                <li  >
                                    <a href="{{asset('/pedagogico')}}"> <i class="fa fa-th-list"></i> Turmas </a>
                                </li>
                                
                                @endif
                                <li  >
                                    <a href=""> <i class="fa fa-home"></i> Turmas </a>
                                        <ul>
                                            <li>
                                                <input type="text" size="5" style="margin-left:50px;"><button>Consultar</button>
                                            </li>
                                            <li>
                                                <a href="{{asset('/administrativo/locais')}}"> <i class="fa fa-home"></i> Listar</a>
                                            </li>
                                            <li>
                                                <a href="#"> <i class="fa fa-home"></i> Cadastrar</a>
                                            </li>
                                            <li>
                                                <a href="#"> <i class="fa fa-home"></i> Relatórios</a>
                                            </li>
                    
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