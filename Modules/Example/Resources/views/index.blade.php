@extends('core::layouts.master')

@section('css')
<link rel="stylesheet" href="{{ mix('css/example.css') }}">
@stop

@section('content')
    <div id="app-example">
        <router-view></router-view>
    </div>
@endsection

@section('js')
    <script src="{{ mix('js/example.js') }}"></script>
@stop
