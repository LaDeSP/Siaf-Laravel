<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('painel.dashboard') }}"><img src="{{ asset('assets/img/Siaf-logo.png') }}" width="130"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('painel.dashboard') }}"><img src="{{ asset('assets/img/siaf.png') }}" width="40"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menus</li>
            <li class="{{ Request::route()->getName() == 'painel.dashboard' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.dashboard') }}"><i><img src="{{ asset('assets/img/inicio.png') }}" alt="logo" width="25"></i><span>Início</span></a></li>
            <li class=""><a class="nav-link" href="#"><i><img src="{{ asset('assets/img/vendas.png') }}" alt="logo" width="25"></i> <span>Vendas</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i><img src="{{ asset('assets/img/estoque.png') }}" alt="logo" width="25"></i> <span>Estoque</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Estoque Plantio</a></li>
                    <li><a class="nav-link" href="#">Estoque não plantio</a></li>
                </ul>
            </li>
            <li class=""><a class="nav-link" href=""><i><img src="{{ asset('assets/img/plantio.png') }}" alt="logo" width="25"></i> <span>Plantio</span></a></li>
            <li class=""><a class="nav-link" href=""><i><img src="{{ asset('assets/img/manejo.png') }}" alt="logo" width="25"></i> <span>Manejo</span></a></li>
            <li class="dropdown {!! (Request::is('painel/produto')|| Request::is( 'admin/user/create') || Request::is( 'admin/usersdeleted') ? ' active' : '' )!!}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i><img src="{{ asset('assets/img/propriedade.png') }}" alt="logo" width="25"></i> <span>Propriedade</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'painel.produto.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.produto.index')}}">Produtos</a></li>
                    <li><a class="nav-link" href="#">Talhões</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i><img src="{{ asset('assets/img/financeiro.png') }}" alt="logo" width="25"></i> <span>Financeiro</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#">Investimento</a></li>
                    <li><a class="nav-link" href="#">Depesa</a></li>
                </ul>
            </li><li class=""><a class="nav-link" href=""><i class="fa fa-users"></i> <span>Calendário</span></a></li>
            </li><li class=""><a class="nav-link" href=""><i><img src="{{ asset('assets/img/relatorio.png') }}" alt="logo" width="22"></i> <span>Relatório</span></a></li>
            <li class=""><a class="nav-link" href=""><i><img src="{{ asset('assets/img/manual.png') }}" alt="logo" width="25"></i> <span>Manual</span></a></li>
        </ul>
    </aside>
</div>