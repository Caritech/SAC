@extends('core::layouts.master')

@section('title','Dashboard')

@section('content_header')
    Dashboard
@stop

@section('css')
    <style>
        .huge-text{
            font-size:30px;
            font-weight:bold

        }
        .small-padding{
            padding:4px 15px;
        }
        .dashboard-count-box{
            margin-bottom:10px;
            color:white !important;
        }

        .dashboard-count-box .box-title{
            font-weight:bold;
            text-align:center
        }
    </style>
@stop

@section('content')
    <div class="row">
        @for($i=0;$i<=11;$i++)
            <div class="dashboard-count-box col-md-2  col-sm-4 col-6">
                <div class="card">
                    <div class="card-body small-padding bg-danger">
                        <div class="box-title">
                            Pending Complete
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-comments fa-2x"></i>
                            </div>
                            <div class="col-8 text-center">
                                <span class='huge-text'>26</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>



@stop

@section('js')
<script>
</script>
@stop


