<header class="header">

    <!-- Barras do menu mobile -->
    <div class="header-block header-block-collapse hidden-lg-up">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>

    <!-- Campo de pesquisa de recurso 
    <div class="header-block header-block-search hidden-sm-down">
        <form role="search">
            <div class="input-container"> <i class="fa fa-search"></i> <input type="search" placeholder="Em construção">
                <div class="underline"></div>
            </div>
        </form>
    </div>-->


    <!-- Barra de navegação onde fica o nome de usuario e as notificações -->
    <div class="header-block header-block-nav">
        <ul class="nav-profile">

            <!-- Notificações -->
            <li class="notifications new">
                <a href="" data-toggle="dropdown"> <i class="fa fa-bell-o"></i> <sup>
      <span class="counter">0</span>
    </sup> </a>
                <div class="dropdown-menu notifications-dropdown-menu">
                    <ul class="notifications-container">
                        <!--
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/faces/3.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p> <span class="accent">Zack Alien</span> pushed new commit: <span class="accent">Fix page load performance issue</span>. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/faces/5.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p> <span class="accent">Amaya Hatsumi</span> started new task: <span class="accent">Dashboard UI design.</span>. </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="" class="notification-item">
                                <div class="img-col">
                                    <div class="img" style="background-image: url('assets/faces/8.jpg')"></div>
                                </div>
                                <div class="body-col">
                                    <p> <span class="accent">Andy Nouman</span> deployed new version of <span class="accent">NodeJS REST Api V3</span> </p>
                                </div>
                            </a>
                        </li>-->
                    </ul>
                    <footer>
                        <ul>
                            <li>
                                <a href="/notificacoes">
                                    <small> Ver tudo </small>
                                </a> 
                            </li>
                        </ul>
                    </footer>
                </div>
            </li>

            <!-- Menu de perfil -->
            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="img" style="background-image: url('https://thesocialmediamonthly.com/wp-content/uploads/2015/08/photo.png')"> </div> 
                    <span class="name"> {{Auth::user()->username}}</span> 	
                </a>

                <!-- lista de itens do menu -->
                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="{{asset('/pessoa/mostrar/'.Auth::user()->pessoa)}}"> <i class="fa fa-user icon"></i> Perfil </a>
                    <!--
                    <a class="dropdown-item" href="#"> <i class="fa fa-bell icon"></i> Notificações </a>-->
                    <a class="dropdown-item" href="{{asset('/').'trocarminhasenha'}}"> <i class="fa fa-gear icon"></i> Alterar senha </a>
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off icon"></i> Sair </a>
                </div>
            </li>
        </ul>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</header>