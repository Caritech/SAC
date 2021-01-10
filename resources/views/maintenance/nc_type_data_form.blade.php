@extends('layouts.app_v1.master')

@section('content')
<div class="card m-2">
    <div class="card-body">

        <h2>Needs Calculator Type Maintenance</h2>

        <form autocomplete="off" method="POST" action="{{url('vlife/setting/nc_type_data')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label>Category</label>
                {{Form::select('category',$lists_nc_category,null,['class'=>''])}}
            </div>
            <div class="form-group">
                <label>Type Code</label>
                <input type="text" name="type_code" required>
            </div>
            <div class="form-group">
                <label>Type Name</label>
                <input type="text" name="type_name" required>
            </div>

            <div class="m-2">
                <input type="submit" class="btn btn-success" value="Save">
            </div>
        </form>

    </div>

</div>
@endsection