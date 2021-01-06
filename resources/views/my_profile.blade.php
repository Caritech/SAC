@extends('layouts.app_v1.master')

@section('css')
@stop

@section('content')
<div class="col-md-12 p-2">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">My Profile</li>
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


        {!! Form::model($user, ['method' => 'PUT','url' => 'my_profile/'.$user->id, 'class'=>'col-md-12', 'files' => true]) !!}

        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header bg-blue">Academy Profile Image</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="profile-image-container">
                            @if(isset($user) && $user->profile_image != "")
                                <a href="{{url('view_image/'.$user->profile_image)}}" target="_blank">
                                  <img class="profile-image image" src="{{ url('view_image/'.$user->profile_image) }}">
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
        <div class="card-header">My Profile</div>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-6 form-group">
                    {{ Form::label('username','Username') }}
                    {{ Form::text('username', null,['class'=>'form-control','readonly' => 'true']) }}
                  </div>

                  <div class="col-md-6 form-group">
                    {{ Form::label('email','Email', ['class'=>'required_label']) }}
                    {{ Form::text('email', null,['class'=>'form-control']) }}
                  </div>

                  <div class="form-group col-md-6">
                    {{ Form::label('name','Name', ['class'=>'required_label']) }}
                    {{ Form::text('name', null,['class'=>'form-control']) }}
                  </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <h3>Change Your Password</h3>
                    </div>

                    <div class="form-group col-md-6">
                        {{ Form::label('old_password','Old Password') }}<br>
                        {{ Form::password('old_password',['class'=>'form-control']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('new_password','New Password') }}<br>
                        {{ Form::password('new_password',['class'=>'form-control']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('new_password_confirmation','Confirm New Password') }}<br>
                        {{ Form::password('new_password_confirmation', ['class'=>'form-control']) }}
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
