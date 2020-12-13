@extends('layouts.app_v1.master')

@section('content')
<div class="card m-2">
    <div class="card-body">
        <h2>Needs Calculator Type Maintenance</h2>
        <div class="m-2">
            <a href="{{url('vlife/nc_type_maintenance/create')}}" class="btn btn-success">Add New</a>
        </div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th class="fit">OP</th>
                    <th class="fit">ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>X
                    </td>
                    <td>{{$d->id}}</td>
                    <td>{{$d->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection