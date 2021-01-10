@extends('layouts.app_v1.master')

@section('content')
<div class="card m-2">
    <div class="card-body">

        
        <h2>Needs Calculator Type Maintenance</h2>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th >OP</th>
                    <th>Category Code</th>
                    <th>Category Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td class="fit">
                        <a href="{{url('vlife/setting/nc_type_category/'.$d->id.'/edit')}}" class="btn btn-primary">
                            Edit Category
                        </a>
                    </td>
                    <td>{{$d->category_code}}</td>
                    <td>{{$d->category_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection