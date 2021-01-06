@extends('layouts.app_v1.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 text-center">
            @if(Auth::user()->profile_image != "" && Auth::user()->profile_image != null )
                <a href="{{url('view_image/'.Auth::user()->profile_image)}}" target="_blank">
                    <img class="dashbroad-profile-image image" src="{{ url('view_image/'.Auth::user()->profile_image) }}">
                </a>
            @else
                <img class="dashbroad-profile-image image" src="{{ asset('images/profile_placeholder.jpg') }}">
            @endif
        </div>
        <div class="col-md-8">
            <h3>Welcome, {{get_user_role(\Auth::user()->role)}} !</h3>
            <h1><b>{{\Auth::user()->name}}</b></h1>
            <h6>{{\Auth::user()->email}} </h6>
            <p>
                Your last sign-in was on 27th June 2020, Saturday at
                13:21PM<br />
                Joined Since <b>{{ date_format(\Auth::user()->created_at, "j F Y" )}}</b>
            </p>
        </div>
    </div>
    <!--<div class="row mt-5">
        <div class="card col-md-5">
            <div class="card-body" style="height: 200px">
                <h5 class="card-title">Life Planning Model Diagram</h5>
                <p class="card-text">Comming Soon</p>
            </div>
        </div>
        <div class="card col-md-5 offset-md-1">
            <div class="card-body" style="height: 200px">
                <h5 class="card-title">Claim Record Q1 2020</h5>
                <p class="card-text">Comming Soon</p>
            </div>
        </div>
    </div>-->
</div>
@endsection
