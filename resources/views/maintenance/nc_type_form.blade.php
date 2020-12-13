@extends('layouts.app_v1.master')

@section('content')
<div class="card m-2">
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('vlife/nc_type_maintenance')}}">View</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Type</li>
            </ol>
        </nav>
        <h2>Needs Calculator Type Maintenance</h2>

        <form autocomplete="off" method="POST" action="{{url('vlife/nc_type_maintenance')}}">
            {{csrf_field()}}
            <label>Name</label>
            <input type="text" name="name" required>

            <div class="m-2">
                <input type="submit" class="btn btn-success" value="Save">
            </div>
        </form>

    </div>

</div>
@endsection