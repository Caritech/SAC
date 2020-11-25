@extends('core::layouts.master')

@section('css')
<link rel="stylesheet" href="{{ mix('css/contactinformation.css') }}">
@stop

@section('content')
    <div id="app-contactinformation">
        <router-view></router-view>
    </div>
@endsection

@section('js')
    <script src="{{ mix('js/contactinformation.js') }}"></script>
@stop
