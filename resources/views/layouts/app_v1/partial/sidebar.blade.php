<?php

/**
 *
 * Sidebar Menu
 *
 *
 * **/
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" :class="{ 'toggled': sidebarToggle }" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon">
            SAC
        </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    @php
    $sidebar_config_file = base_path('modules_statuses.json');
    $sidebar_config = json_decode(file_get_contents($sidebar_config_file), true);
    @endphp


    <?php

    $menuClass = new App\Classes\Menu();
    $menu = $menuClass->menu;
    $user_role = \Auth::user()->role;

    foreach ($menu as $k => $m) {
        $menu_name = preg_replace('/\s+/', '', $m['text']);
        if (
            (isset($sidebar_config[$m['text']]) && $sidebar_config[$m['text']] == false) ||
            (isset($sidebar_config[$menu_name]) && $sidebar_config[$menu_name] == false)
        ) {
            continue;
        }
        $uri = "$_SERVER[REQUEST_URI]";
        $active_class = '';

        if (isset($m['submenu'])) {
            foreach ($m['submenu'] as $sub) {
                if (strpos($uri, $sub['url']) !== false) {
                    $active_class = 'active';
                    break;
                }
            }
        } else {
            if (strpos($uri, $m['url']) !== false) {
                $active_class = 'active';
            }
        }
    ?>
        @if(isset($m['submenu']) && (($m['access'] == 'user') || ($m['access'] == 'admin' && $user_role == 2) ))
        <li class="nav-item {{$active_class}}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuCollapse{{$k}}">
                <i class="{{$m['icon']}}"></i>
                <span>{{$m['text']}}</span>
            </a>
            <div id="menuCollapse{{$k}}" class="sidebar-menu-collapse collapse" data-parent="#accordionSidebar">
                <div class="collapse-inner sidebar-submenu-box">
                    @foreach($m['submenu'] as $sub)
                    <a class="collapse-item sidebar-sidemenu-item" href="{{$sub['url']}}">
                        <i class="{{$sub['icon']}}"></i> {{ $sub['text'] }}
                    </a>
                    @endforeach
                </div>
            </div>
        </li>
        @elseif(($m['access'] == 'user') || ($m['access'] == 'admin' && $user_role == 2) )
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{$active_class}}">
            <a class="nav-link" href="{{$m['url']}}">
                <i class="{{$m['icon']}}"></i>
                <span>{{$m['text']}}</span></a>
        </li>

        @endif
    <?php
    }
    ?>

</ul>
<!-- End of Sidebar -->
