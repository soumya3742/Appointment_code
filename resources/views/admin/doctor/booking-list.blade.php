@extends('admin/layouts/default')
@section('title')
<title> Booking List</title>
@stop
@section('inlinecss')

@stop
@section('breadcrum')
<h1 class="page-title">Booking List</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Booking</a></li>
    <li class="breadcrumb-item active" aria-current="page">List</li>
</ol>
@stop
@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Doctor</h3>
                        <div class="ml-auto pageheader-btn">
								<a href="{{route('doctor-create')}}" class="btn btn-success btn-icon text-white mr-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Doctor
                                </a>

								<a href="#" class="btn btn-danger btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
								</a>
							</div>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Booking ID</th>
                              <th>User Name</th>
                              <th>Doctor Name</th>
                              <th>Timing</th>
                              <th>Created At</th>
                              <th class="text-center">Status</th>
                              
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($booking as $key=>$val)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$val->booking_id}}</td>
                            <td>{{$val->user->name}}</td>
                            <td>{{$val->doctors->doctor_name}}</td>
                            <td>{{$val->timing}}</td>
                            <td>{{$val->created_at}}</td>
                            <td class="d-block text-capitalize @if($val->status=='pending'){{'badge  badge-danger'}}@elseif($val->status=='active'){{'badge badge-sucess'}}@endif">{{$val->status}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>


</div>
@stop
@section('inlinejs')

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('.data-table').DataTable();



        });
    </script>
@stop
