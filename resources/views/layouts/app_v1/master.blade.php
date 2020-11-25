<?php
$core = new App\Http\Controllers\Core\MenuController();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(View::hasSection('title'))
        <title>@yield('title') - SAC</title>
    @else
        <title>SAC</title>
    @endif
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


    @yield('css')
</head>

<body>
    @include('layouts.app_v1.js_css')
    <!-- Page Wrapper -->
    <div id="app">
        <div id="wrapper">

            <!-- Sidebar -->
            @include('layouts.app_v1.partial.sidebar')

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
                        @include('layouts.app_v1.partial.top_left_bar')
                        <ul class="navbar-nav ml-auto">
                            @include('layouts.app_v1.partial.top_right_bar')
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
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>


    @yield('js')

</body>
