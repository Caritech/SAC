@extends('layouts.app_v1.master')

@section('css')
@stop


@section('content')
<div class="col-md-12 p-2">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
    <div class="col-md-12">
        @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
        @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
</div>

    <div class="row">

        <div class="col-md-10">
        {{ Form::open(['url' => '/admin/user_management', 'method'=>'GET']) }}
        <div class="row">
        <div class="col-md-9">
          {{ Form::text('search_input',$search_input,['class'=>'form-control height-auto-field','placeholder'=>'Search']) }}
        </div>
        <div class="col-md-3">
            {{ Form::submit('Search', array('class' => 'btn btn-xs btn-primary', 'id' => 'submit')) }}
            {{ Form::submit('Reset', array('class' => 'btn btn-xs btn-secondary', 'onClick' => 'resetForm()')) }}

        </div>
    </div>
        {{ Form::close() }}
    </div>

        <div class="col-md-2">
            <a href="{{url('/admin/user_management/create')}}" class="btn btn-success pull-right">Add New User</a>
        </div>
</div>

    <div class="row">
       <div class="col-md-12">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead>
              <tr>
                <th>@sortablelink('id','User ID')</th>
                <th>@sortablelink('name','Name')</th>
                <th>@sortablelink('username','Login ID')</th>
                <th>@sortablelink('email','Email Address')</th>
                <th>@sortablelink('status','Status')</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $d)
              <tr>
                <td>{{$d->id}}</td>
                <td>{{$d->name}}</td>
                <td>{{$d->username}}</td>
                <td>{{$d->email}}</td>
                <td>{!! statusIcon($d->status) !!}</td>

                <td>
                  {{Html::link(url('admin/user_management/'.$d->id.'/edit'),' Edit',['class'=>'btn btn-success  '])}}

                </td>
              </tr>
              @empty
                <tr>
                    <td colspan="7">No users are available<td>
                </tr>

              @endforelse
            </tbody>
          </table>
          <div class="row-">
                      <div class="col-12 text-center">
                           {{ $data->appends($_GET)->links() }}
                  </div>
        </div>
       </div>

    </div>
</div>


@stop


@section('js')
<script>
    function resetForm() {
        $('#searchForm').submit();
        $('input[type="text"], select').val(null);
    }
    $(document).ready(function() {
        $("input").keypress(function(e) {
            if (e.which == 13) {
                $('#submit').click();
                return false;
            }
            return true;
        });
    });
</script>
@stop
