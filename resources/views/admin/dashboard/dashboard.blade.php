@extends('admin/layouts/default')
@section('title')
<title>Appointment - Dashboard</title>
@stop
@section('inlinecss')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

@stop
@section('breadcrum')
<h1 class="page-title">Dashboard</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">dashboard</li>
</ol>
@stop
@section('content')
<style>
.ui-widget
{
    z-index: 999999999!important;
    border: 1px solid!important;
}
.ui-widget li
{
    border-bottom: 1px solid black!important;
}

</style>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
      <!-- Users Section -->
    <div class="row">
            <div class=" col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    	<div class="col-sm-12 col-lg-4 col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">{{$nousers}}</h2>
                                <p>No of Users </p>
                                <a href="{{route('front-users')}}" >View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">{{$todayusers}}</h2>
                                <p>Today Users</p>

                            </div>
                        </div>
                    </div>
					<div class="col-sm-12 col-lg-4 col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">{{$yesterdayusers}}</h2>
                                <p>Yesterday Users</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
      <!-- Medical Section -->
    <div class="row">
            <div class=" col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    	<div class="col-sm-12 col-lg-4 col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">{{$totaldoctors}}</h2>
                                <p>Total Doctors</p>
                                 <a href="{{route('doctor-list')}}" >View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">{{$approvedoctors}}</h2>
                                <p>Approved Doctors</p>

                            </div>
                        </div>
                    </div>
					<div class="col-sm-12 col-lg-4 col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-1 number-font">{{$pendingdoctors}}</h2>
                                <p>Pending Doctors</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
      <!-- Doctors Section -->



        <!--<div id="container"></div>-->

</div>
@stop

@section('inlinejs')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript">
        $('.Description').summernote({ height:250 });
    </script>
@if(Session::has('success'))
<script>
    successMsg('Mail','{{ Session::get('success') }}','');
</script>
@endif

@stop
