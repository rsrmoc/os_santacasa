<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <div style="text-align: center; padding-bottom: 15px; padding-top: 10px;">
 
        </div>
        
        <ul class="menu accordion-menu">
                        
            <li class="{{ (Route::current()->getName() == 'home') ? 'active' : null }}"><a href="{{ route('home') }}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span> <p>Inicial</p></a></li>
 

            <li class="droplink "><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-folder-open"></span><p>Tabelas</p><span class="arrow"></span></a>
                <ul class="sub-menu"> 
                        <li class=""><a href="{{ route('condominios-listar') }}"><p>Condomínios</p> </a>  </li> 
                </ul> 
            </li>


            <li class="{{ (Route::current()->getName() == 'controle-listar') ? 'active' : null }}"><a href="{{route('controle-listar')}}" class="waves-effect waves-button"><span class="menu-icon   glyphicon glyphicon-barcode"></span><p>Boletos</p></a></li>

            <li class={{ (Route::current()->getName() == 'clientes-listar') ? 'active' : null }}><a href="{{route('clientes-listar')}}" class="waves-effect waves-button"><span class="menu-icon   fa fa-users"></span><p>Clientes</p></a></li>

            <li class={{ (Route::current()->getName() == 'negociacoes-listar') ? 'active' : null }}><a href="{{route('negociacoes-listar')}}" class="waves-effect waves-button"><span class="menu-icon   fa fa-comment"></span><p>Negociações</p></a></li>
 
               
        </ul>
        
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->