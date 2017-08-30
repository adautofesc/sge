<aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <div class="brand">
                                <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div> SGE2 <i>FESC</i></div>
                        </div>
                        <nav class="menu">
                            <ul class="nav metismenu" id="sidebar-menu">
                                <li  class="active">
                                    <a href="{{asset('/')}}"> <i class="fa fa-home"></i> Home </a>
                                </li>
                                <!-- Futuro módulo de Admin
                                <li>
                                    <a href="" > <i class="fa fa-th-large"></i> Administração <i class="fa arrow"></i> </a>
                                    <ul>
                                        <li> <a href="cursos.php">Acesso ao sistema</a> </li>
                                        <li> <a href="#"> Compras </a> </li>
                                        <li> <a href="#"> Licitações </a> </li>
                                        <li> <a href="#"> Patrimônio </a> </li>
                                        <li> <a href="disciplinas.php">Processos</a> </li>
                                        <li> <a href="#">Relações</a> </li>
                                        <li> <a href="#"> Solicitações </a> </li>
                                        <li> <a href="#"> Patrimônio </a> </li>

                                    </ul>
                                </li>
                                -->
                                <li>
                                    <a href=""> <i class="fa fa-th-large"></i> Secretaria <i class="fa arrow"></i> </a>
                                    <ul>
                                        
                                    	<li> <a href="{{asset('secretaria/atender')}}">Atendimento</a> </li>

                                        <li> <a href="{{asset("/pessoa/cadastrar")}}">Cadastrar usuário</a> </li>
                                        <li> <a href="{{asset('/pessoa/listar')}}">Lista de usuários</a> </li>
                                        <li> <a href="#">Turmas Abertas	</a> </li>
										<li> <a href="#">Matrículas</a> </li>
                                                             
                                        
                                    </ul>
                                </li>
                                <li>
                                    <a href=""> <i class="fa fa-th-large"></i> Institucional <i class="fa arrow"></i> </a>
                                    <ul>
                                        <li> <a href="#">	Cursos</a> </li>
                                        <li> <a href="#"> Disciplinas </a> </li>
                                        <li> <a href="#"> Unidades </a> </li>
                                        <li> <a href="#"> Salas </a> </li>
                                        <li> <a href="#"> Ocupação </a> </li>
    	
                                    </ul>
                                </li>
                                <!--
                                <li>
                                    <a href=""> <i class="fa fa-th-large"></i> Manutenção<i class="fa arrow"></i> </a>
                                    <ul>
                                        <li> <a href="cursos.php">Chamados</a> </li>

                                    </ul>
                                </li>
                                -->
                                <li>
                                    <a href=""> <i class="fa fa-bar-chart"></i>Pedagógico <i class="fa arrow"></i> </a>
                                    <ul>
                                    	<li> <a href="#">Turmas Ativas</a> </li>
										<li> <a href="#">Nova Turma</a> </li>
                                    </ul>
                                </li>
                                 <li>
                                    <a href=""> <i class="fa fa-users"></i> Pessoas <i class="fa arrow"></i> </a>
                                    <ul>
                                        <li> <a href="{{asset('/pessoa/listar')}}">Lista</a></li>
                                        <li> <a href="{{asset('/pessoa/cadastrar')}}">Adicionar</a></li>
                                        <li> <a href="{{asset('/admin/listarusuarios')}}">Usuários sistema</a></li>
                                    <!--
                                        <li> <a href="./pessoas.php?relacao=adm">Administrativo</a></li>
                                        <li> <a href="./pessoas.php?relacao=alu">Alunos</a></li>
                                        <li> <a href="./pessoas.php?relacao=doc">Docentes</a></li>
                                        <li> <a href="./pessoas.php?relacao=ope">Operacional</a></li>
                                        <li> <a href="./pessoas.php?relacao=par">Parceiros</a></li>
                                        <li> <a href="./pessoas.php?relacao=ter">Terceirizados</a></li>-->
                                    </ul>
                                </li>
                                <li>
                                    <a href=""> <i class="fa fa-usd"></i>Financeiro <i class="fa arrow"></i> </a>
                                    <ul>
                                    	<li> <a href="charts-flot.html">Caixa</a> </li>
                                        <li> <a href="charts-flot.html">Emissão de boleto</a> </li>
                                        <li> <a href="charts-morris.html">	Situação cadastral	</a> </li>
										<li> <a href="charts-morris.html">Relação bancária </a> </li>
										<li> <a href="charts-morris.html"> Descontos </a> </li>
										<li> <a href="charts-morris.html"> 	Bolsas </a> </li>
										<li> <a href="charts-morris.html"> 	Relatórios</a> </li>
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