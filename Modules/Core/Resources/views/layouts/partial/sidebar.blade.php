<?php
/**
 *
 * Sidebar Menu
 *
 *
 * **/
?>
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            IRED v2
        </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @foreach($core->menu as $k => $m)
        @if( isset($m['submenu']))
            <li class="nav-item ">
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
        @else
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{$m['url']}}">
                <i class="{{$m['icon']}}"></i>
                <span>{{$m['text']}}</span></a>
            </li>

        @endif
    @endforeach

</ul>
<!-- End of Sidebar -->
