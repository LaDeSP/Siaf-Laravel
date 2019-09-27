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
            <li class="{{ Request::route()->getName() == 'painel.venda.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.venda.index')}}"><i><img src="{{ asset('assets/img/vendas.png') }}" alt="logo" width="25"></i> <span>Vendas</span></a></li>
            <li class="dropdown {!! (Request::is('painel/estoque/p/plantio')|| Request::is( 'painel/estoque/p/propriedade') ? ' active' : '' )!!}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i><img src="{{ asset('assets/img/estoque.png') }}" alt="logo" width="25"></i> <span>Estoque</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'painel.estoquePlantaveis' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.estoquePlantaveis')}}">Produtos Plantáveis</a></li>
                    <li class="{{ Request::route()->getName() == 'painel.estoquePropriedade' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.estoquePropriedade')}}">Produtos Processados</a></li>
                </ul>
            </li>
            <li class="{{ Request::route()->getName() == 'painel.plantio.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.plantio.index')}}"><i><img src="{{ asset('assets/img/plantio.png') }}" alt="logo" width="25"></i> <span>Plantio</span></a></li>
            <li class="{{ Request::route()->getName() == 'painel.manejo.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.manejo.index')}}"><i><img src="{{ asset('assets/img/manejo.png') }}" alt="logo" width="25"></i> <span>Manejo</span></a></li>
            <li class="dropdown {!! (Request::is('painel/produto')|| Request::is( 'painel/talhao') ? ' active' : '' )!!}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i><img src="{{ asset('assets/img/propriedade.png') }}" alt="logo" width="25"></i> <span>Propriedade</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'painel.produto.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.produto.index')}}">Produtos</a></li>
                    <li class="{{ Request::route()->getName() == 'painel.talhao.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.talhao.index')}}">Talhões</a></li>
                </ul>
            </li>
            <li class="dropdown {!! (Request::is('painel/investimento')|| Request::is( 'painel/despesa') ? ' active' : '' )!!}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i><img src="{{ asset('assets/img/financeiro.png') }}" alt="logo" width="25"></i> <span>Financeiro</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::route()->getName() == 'painel.investimento.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.investimento.index')}}">Investimento</a></li>
                    <li class="{{ Request::route()->getName() == 'painel.despesa.index' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.despesa.index')}}">Despesa</a></li>
                </ul>
            </li>
            <li class="{{ Request::route()->getName() == 'painel.calendario' ? ' active' : '' }}"><a class="nav-link" href="{{route('painel.calendario')}}"><i><img src="{{ asset('assets/img/calendario.png') }}" alt="logo" width="20"></i> <span>Calendário</span></a></li></li>
            <li class=""><a class="nav-link" href=""><i><img src="{{ asset('assets/img/relatorio.png') }}" alt="logo" width="22"></i> <span>Relatório</span></a></li>
            <li class=""><a class="nav-link" href=""><i><img src="{{ asset('assets/img/manual.png') }}" alt="logo" width="25"></i> <span>Manual</span></a></li>
        </ul>
    </aside>
</div>