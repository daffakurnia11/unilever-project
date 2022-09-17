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
  </ul>
  <!--end navigation-->
</aside>
<!--end sidebar -->