<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('painel.dashboard') }}"><img src="{{ asset('assets/img/Siaf-logo.png') }}" width="130"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menus</li>
            <li class="{{ Request::route()->getName() == 'painel.dashboard' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.dashboard') }}"><i class="fa fa-columns"></i> <span>Início</span></a></li>
            <li class=""><a class="nav-link" href="#"><i class="fa fa-heartbeat"></i> <span>Vendas</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Estoque</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Estoque Plantio</a></li>
                    <li><a class="nav-link" href="#">Estoque não plantio</a></li>
                </ul>
            </li>
            <li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Plantio</span></a></li>
            <li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Manejo</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Propriedade</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Produtos</a></li>
                    <li><a class="nav-link" href="#">Talhões</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Financeiro</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Investimento</a></li>
                    <li><a class="nav-link" href="#">Depesa</a></li>
                </ul>
            </li><li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Calendário</span></a></li>
            </li><li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Relatório</span></a></li>
            <li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Manual</span></a></li>
            <li class="menu-header">Users</li>
            <li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Users</span></a></li>
        </ul>
    </aside>
</div>