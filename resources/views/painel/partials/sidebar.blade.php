<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('painel.dashboard') }}">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">St</a>
  </div>
  <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="{{ Request::route()->getName() == 'painel.dashboard' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.dashboard') }}"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
      <li class="menu-header">Users</li>
      <li class="{{ Request::route()->getName() == 'painel.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.users') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
      </ul>
</aside>
