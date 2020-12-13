@extends('layouts.app_v1.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 text-center">
            <img width="200" height="200" style="border-radius: 530px" src="https://www.pngitem.com/pimgs/m/226-2260470_transparent-admin-icon-png-admin-logo-png-png.png" />
        </div>
        <div class="col-md-8">
            <h2>Welcome, user.role !</h2>
            <h1> user.username </h1>
            <h6> user.email </h6>
            <p>
                Your last sign-in was on 27th June 2020, Saturday at
                13:21PM<br />
                Joined Since <b></b>
            </p>
        </div>
    </div>
    <div class="row mt-5">
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
    </div>
</div>
@endsection