<?php
    $core = new Modules\Core\Http\Controllers\CoreController();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(View::hasSection('title'))
        <title>@yield('title') - Ired V2</title>
    @else
        <title>IRED V2</title>
    @endif
    <link rel="stylesheet" href="{{ mix('css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @yield('css')
</head>

<body>
    @include('core::layouts.js_css')
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('core::layouts.partial.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
                    @include('core::layouts.partial.top_left_bar')
                    <ul class="navbar-nav ml-auto">
                        @include('core::layouts.partial.top_right_bar')
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    @if(View::hasSection('content_header'))
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 mb-0 text-gray-800">@yield('content_header')</h1>
                    </div>
                    @endif

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/core.js') }}"></script>
    @yield('js')

</body>
