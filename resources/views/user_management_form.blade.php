@extends('layouts.app_v1.master')

@section('css')
@stop

@section('content')
<div class="col-md-12 p-2">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/user_management')}}">Users</a></li>
            <li class="breadcrumb-item" aria-current="page">{{$action}} Users</li>
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

        @isset($data)
        {{Form::model($data, ['url'=>['admin/user_management/'.$data->users->id.'/update'], 'method'=>'PUT','autocomplete'=>'off','class'=>'col-md-12','files'=>true])}}
        @else
        {{Form::open(['url'=>'admin/user_management/store','method'=>'POST','class'=>'col-md-12','autocomplete'=>'off','files'=>true])}}
        @endisset
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header bg-blue">Academy Profile Image</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="profile-image-container">
                            @if(isset($data) && $data->users->profile_image != "")
                                <a href="{{url('view_image/'.$data->users->profile_image)}}" target="_blank">
                                  <img class="profile-image image" src="{{ url('view_image/'.$data->users->profile_image) }}">
                                </a>
                            @else
                                <img class="profile-image image" src="{{ asset('images/profile_placeholder.jpg') }}">
                            @endif
                            {{ Form::file('profile_image', ['class'=>'file-input','accept'=>'image/*']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="card">
        <div class="card-header">{{$action}} User</div>
            <div class="card-body">
                <div class="row">
                <div class="col-md-6 form-group">
                    {{ Form::label('username','Username', ['class'=>'required_label']) }}
                    @isset($data)
                    {{ Form::text('users[username]', null,['class'=>'form-control','readonly' => 'true']) }}
                    @else
                    {{ Form::text('users[username]', null,['class'=>'form-control']) }}
                    @endisset
                  </div>

                  <div class="col-md-6 form-group">
                    {{ Form::label('email','Email', ['class'=>'required_label']) }}
                    {{ Form::text('users[email]', null,['class'=>'form-control']) }}
                  </div>

                  <div class="form-group col-md-6">
                    {{ Form::label('name','Name', ['class'=>'required_label']) }}
                    {{ Form::text('users[name]', null,['class'=>'form-control']) }}
                  </div>
                  @isset($data)
                  @else
                  <div class="form-group col-md-6">
                  {{ Form::label('password','Password', ['class'=>'required_label']) }}<br>
                  {{ Form::password('users[password]',['class'=>'form-control']) }}
                  </div>
                  @endisset
                  <div class="form-group col-md-6">
                    {{ Form::label('roles','Role', ['class'=>'required_label']) }}<br>
                    {{ Form::select('users[role]',get_user_role_lists(),null,['class'=>'form-control']) }}
                  </div>

                  <div class="form-group col-md-6">
                    {{ Form::label('status','Status', ['class'=>'required_label']) }}<br>
                    {{ Form::select('users[status]',user_active_status_option(),null,['class'=>'form-control']) }}
                  </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" value="Save" class="btn btn-success">
            </div>
        </div>
        {{Form::close()}}
    </div>


</div>
@endsection

@section('js')
<script>

  </script>
@stop
