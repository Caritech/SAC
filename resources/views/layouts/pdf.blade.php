<html>
    <head>
        <title>@yield('title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('css/global.css') }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('css/color.css') }}"
        />
        <style>
            body {
                font-family: "arial-unicode-ms", Helvetica, Arial, sans-serif;
                font-size: 12px;
                line-height: 1em;
                color: #333;
                background-color: #fff;
            }
            .text-area {
                font-family: "arial-unicode-ms", Helvetica, Arial, sans-serif;
                font-size: 12px;
                line-height: 1em;
                color: #333;
                background-color: #fff;
                height: 50px;
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            .title,
            th,
            thead td {
                font-family: Helvetica;
                font-weight: 900;
                line-height: 1.3em;
                vertical-align: middle;
            }
            table {
                border-collapse: collapse;
            }
            table th {
                font-weight: 700;
                border-bottom: 2px solid black;
                text-align: center;
            }

            .h1 {
                font-size: 2.5rem;
            }

            .h2 {
                font-size: 2rem;
            }

            .h3 {
                font-size: 1.75rem;
            }

            .h4 {
                font-size: 1.5rem;
            }

            .h5 {
                font-size: 1.25rem;
            }
            .h6 {
                font-size: 1rem;
            }

            .w10 {
                width: 9%;
                float: left;
            }
            .w15 {
                width: 14%;
                float: left;
            }
            .w20 {
                width: 19%;
                float: left;
            }
            .w30 {
                width: 29%;
                float: left;
            }
            .w33 {
                width: 31.3%;
                float: left;
            }
            .w40 {
                width: 39%;
                float: left;
            }
            .w50 {
                width: 49%;
                float: left;
            }
            .w60 {
                width: 59%;
                float: left;
            }
            .w70 {
                width: 69%;
                float: left;
            }
            .w80 {
                width: 79%;
                float: left;
            }
            .w85 {
                width: 84%;
                float: left;
            }
            .w90 {
                width: 88%;
                float: left;
            }
            .w100 {
                width: 100%;
            }

            .p-1 {
                padding: 5px;
            }
            .p-2 {
                padding: 10px;
            }
            .p-3 {
                padding: 15px;
            }
            .p-4 {
                padding: 20px;
            }
            .p-5 {
                padding: 30px;
            }

            .pr-1 {
                padding-right: 5px;
            }
            .pr-2 {
                padding-right: 10px;
            }
            .pr-3 {
                padding-right: 15px;
            }
            .pr-4 {
                padding-right: 20px;
            }
            .pr-5 {
                padding-right: 30px;
            }

            .px-1 {
                padding: 0px 5px;
            }
            .px-2 {
                padding: 0px 10px;
            }
            .px-3 {
                padding: 0px 15px;
            }
            .px-4 {
                padding: 0px 20px;
            }
            .px-5 {
                padding: 0px 30px;
            }

            .m-1 {
                margin: 5px;
            }
            .m-2 {
                margin: 10px;
            }
            .m-3 {
                margin: 15px;
            }
            .m-4 {
                margin: 20px;
            }
            .m-5 {
                margin: 30px;
            }

            .mb-1 {
                margin-bottom: 5px;
            }
            .mb-2 {
                margin-bottom: 10px;
            }
            .mb-3 {
                margin-bottom: 15px;
            }
            .mb-4 {
                margin-bottom: 20px;
            }
            .mb-5 {
                margin-bottom: 30px;
            }

            .mt-1 {
                margin-top: 5px;
            }
            .mt-2 {
                margin-top: 10px;
            }
            .mt-3 {
                margin-top: 15px;
            }
            .mt-4 {
                margin-top: 20px;
            }
            .mt-5 {
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>
