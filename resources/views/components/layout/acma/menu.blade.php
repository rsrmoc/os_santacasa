<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <div style="text-align: center; padding-bottom: 15px; padding-top: 10px;">

        </div>

        <ul class="menu accordion-menu">

            <li class="{{ (Route::current()->getName() == 'home') ? 'active' : null }}"><a href="{{ route('home') }}" class="waves-effect waves-button"><span class="menu-icon fa fa-line-chart"></span> <p>Resumo</p></a></li>

            <li class={{ (Route::current()->getName() == 'chamados-listar') ? 'active' : null }}><a href="{{ route('chamados-listar') }}" class="waves-effect waves-button"><span class="menu-icon   fa fa-tags"></span><p>Chamados</p></a></li>

            <li class="{{ (Route::current()->getName() == 'chamados-suporte') ? 'active' : null }}"><a href="{{ route('chamados-suporte') }}" class="waves-effect waves-button"><span class="menu-icon   fa fa-tty"></span><p>Suporte</p></a></li>

            <li class={{ (Route::current()->getName() == 'chamados-projetos') ? 'active' : null }}><a href="{{ route('chamados-projetos') }}" class="waves-effect waves-button"><span class="menu-icon   fa fa-pencil-square-o"></span><p>Projetos</p></a></li>

        </ul>

    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->
