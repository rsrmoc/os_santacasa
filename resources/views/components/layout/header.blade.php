<div class="navbar">
    <div class="navbar-inner">
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="logo-box">
            <a href="#" class="logo-text"><img src="{{ asset('assets\images\logo_rp.png') }}" style="    width: 155px;  "></a>
        </div><!-- Logo Box -->

        <div class="topmenu-outer">
            <div class="top-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/" class="waves-effect waves-button waves-classic">Cadastro</a>
                    </li>

                    <li>
                        <a href="{{ route('home') }}" class="waves-effect waves-button waves-classic">Home</a>
                    </li>

                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                <span class="user-name">{{ ucfirst(strtolower(request()->user()->nm_usuario)) }} <i class="fa fa-angle-down"></i></span>
                                <img class="img-circle avatar" src="{{ asset('assets/images/user.png') }}" width="40" height="40" alt="">
                            </a>

                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation">
                                    <a href="{{ route('usuarios-listar') }}">
                                        <i class="fa fa-users"></i> Usuários
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="{{ route('logout') }}">
                                        <i class="fa fa-sign-out m-r-xs"></i>Sair
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('logout') }}" class="log-out waves-effect waves-button waves-classic">
                                <span><i class="fa fa-sign-out m-r-xs"></i>Sair</span>
                            </a>
                        </li>
                    @endauth
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
        </div>
    </div>
</div><!-- Navbar -->
<style>
    .center{ text-align: center; }
    .right{ text-align: right; }
    .left{ text-align: left; }
    .red{ color: red; }
    .error{ color: red; }
</style>
