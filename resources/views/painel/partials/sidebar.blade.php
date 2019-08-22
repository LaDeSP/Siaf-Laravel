<div class="main-sidebar sidebar-style-2">
<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('painel.dashboard') }}"><img src="{{ asset('assets/img/Siaf-logo.png') }}" width="130"></a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">St</a>
  </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Menus</li>
      <li class="{{ Request::route()->getName() == 'painel.dashboard' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.dashboard') }}"><i class="fa fa-columns"></i> <span>Inicio</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-heartbeat"></i> <span>Vendas</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Estoque</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Plantio</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Manejo</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Propriedade</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Despesas</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Investimento</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Relatório</span></a></li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Manual</span></a></li>
      <li class="menu-header">Users</li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
      </ul>
</aside>
</div>