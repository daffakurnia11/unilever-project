<!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <div>
      <h4 class="logo-text">IOT System</h4>
    </div>
    <div class="toggle-icon ms-auto">
      <i class="bi bi-chevron-double-left"></i>
    </div>
  </div>
  <!--navigation-->
  <ul class="metismenu" id="menu">
    <li class="{{ Request::is('/') ? 'mm-active' : '' }}">
      <a href="/">
        <div class="parent-icon">
          <i class="bi bi-house-door"></i>
        </div>
        <div class="menu-title">Dashboard</div>
      </a>
    </li>

    

    <li class="menu-label">Panel Monitoring</li>
    @foreach ($sidebars as $menu)
      @if ($menu->plant_type == 'Panel')
      <li class="{{ Request::is(`$menu->plant_name**`) ?? 'mm-active' }}">
        <a class="has-arrow" href="javascript:;" aria-expanded="false">
          <div class="parent-icon">
            <i class="bi bi-circle"></i>
          </div>
          <div class="menu-title">{{ $menu->plant_name }}</div>
        </a>
        <ul class="mm-collapse {{ Request::is(`$menu->plant_name**`) ?? 'mm-show' }}" style="">
          <li class="{{ Request::is(`$menu->plant_name/monitoring`) ?? 'mm-active' }}"> 
            <a href="/{{ $menu->plant_name }}/monitoring">
              <i class="bi bi-arrow-right-short"></i> Monitoring
            </a>
          </li>
          <li class="{{ Request::is(`$menu->plant_name/setpoint`) ?? 'mm-active' }}"> 
            <a href="/{{ $menu->plant_name }}/setpoint">
              <i class="bi bi-arrow-right-short"></i> Set Point
            </a>
          </li>
        </ul>
      </li>
      @endif
    @endforeach
    <li class="menu-label">Motor Monitoring</li>
    @foreach ($sidebars as $menu)
      @if ($menu->plant_type == 'Motor')
      <li class="{{ Request::is(`$menu->plant_name**`) ?? 'mm-active' }}">
        <a class="has-arrow" href="javascript:;" aria-expanded="false">
          <div class="parent-icon">
            <i class="bi bi-circle"></i>
          </div>
          <div class="menu-title">{{ $menu->plant_name }}</div>
        </a>
        <ul class="mm-collapse {{ Request::is(`$menu->plant_name**`) ?? 'mm-show' }}" style="">
          <li class="{{ Request::is(`$menu->plant_name/monitoring`) ?? 'mm-active' }}"> 
            <a href="/{{ $menu->plant_name }}/monitoring">
              <i class="bi bi-arrow-right-short"></i> Monitoring
            </a>
          </li>
          <li class="{{ Request::is(`$menu->plant_name/setpoint`) ?? 'mm-active' }}"> 
            <a href="/{{ $menu->plant_name }}/setpoint">
              <i class="bi bi-arrow-right-short"></i> Set Point
            </a>
          </li>
        </ul>
      </li>
      @endif
    @endforeach
  </ul>
  <!--end navigation-->
</aside>
<!--end sidebar -->