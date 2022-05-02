<aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <div class="brand">
                                <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span></div>SGE <i>FESC</i></div>
                        </div>
                        <nav class="menu">
                            <ul class="nav metismenu" id="sidebar-menu">
                                <li  class="active">
                                    <a href="{{asset('/')}}"> <i class="fa fa-home"></i> Home </a>
                                </li>
                                @if(in_array('18', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/agendamento')}}"> <i class="fa fa-clock-o"></i> Agendamentos </a>
                                </li>
                                <li>
                                    <a href="{{asset('/pessoa/atestado/listar')}}"> <i class="fa fa-medkit"></i> Atestados </a>
                                </li>
                                @endif
                                @if(in_array('12', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/administrativo')}}"> <i class="fa fa-bar-chart-o"></i> Administração </a>
                                </li>
                                @endif
                                @if(in_array('23', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/boletos')}}"> <i class="fa fa-barcode"></i> Boletos Vencidos </a>
                                </li>
                                @endif
                                @if(in_array('21', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/bolsas/liberacao')}}"> <i class="fa fa-heart"></i> Bolsas </a>
                                </li>
                                @endif
                                @if(in_array('22', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/dev')}}"> <i class="fa fa-flask"></i> Desenvolvimento </a>
                                </li>
                                @endif
                                @if(in_array('13', Auth::user()->recursos))
                                <li  >
                                    <a href="/docentes/"> <i class="fa fa-th-large"></i> Docente </a>
                                </li>
                                @endif
                                
                                @if(in_array('13', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/planos-ensino')}}"> <i class="fa fa-location-arrow"></i> Planos de ensino </a>
                                </li>
                                @endif
                                
                                @if(in_array('24', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/financeiro')}}"> <i class="fa fa-usd"></i> Financeiro </a>
                                </li>
                                @endif
                                @if(in_array('15', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/gestaopessoal')}}"> <i class="fa fa-users"></i> Gestão Pessoal </a>
                                </li>
                                @endif
                            
                                <li  >
                                    <a href="{{asset('/juridico')}}"> <i class="fa fa-bookmark"></i> Jurídico </a>
                                </li>
                        
                                @if(in_array('17', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/pedagogico')}}"> <i class="fa fa-th-list"></i> Pedagógico </a>
                                </li>
                                @endif
                                @if(in_array('18', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/secretaria')}}"> <i class="fa fa-stack-overflow"></i> Secretaria </a>
                                 </li>
                                <li>
                                    <a href="{{asset('secretaria/pre-atendimento')}}"> <i class="fa fa-asterisk"></i> Novo atendimento</a>
                                </li>
                                @if(session('pessoa_atendimento'))
                                <li>
                                    <a href="{{asset('secretaria/atender').'/'.session('pessoa_atendimento')}}"> <i class="fa fa-arrow-right"></i> Retomar atendimento</a>
                                </li>
                                @endif

                                        
                                <li>
                                    <a href="{{route('turmas')}}"> <i class="fa fa-arrow-right"></i> Turmas </a>
                                </li>
                                    
                                    
                                
                                @endif
                                @if(in_array('28', Auth::user()->recursos))
                                <li  >
                                    <a href="{{asset('/uso-livre')}}"> <i class="fa fa-desktop"></i> Uso Livre </a>
                                </li>
                                @endif
                                
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
                    </footer>
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>