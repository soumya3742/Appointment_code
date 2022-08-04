@extends('admin/layouts/default')
@section('title')
<title> Our Expert Doctors</title>
@stop
@section('inlinecss')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
@stop
@section('breadcrum')
<h1 class="page-title">Our Expert Doctors List</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Our Expert Doctors</a></li>
    <li class="breadcrumb-item active" aria-current="page">List</li>
</ol>
@stop
@section('content')
<style>
    .buttons-html5,.buttons-print
    {
        color: #fff !important;
        background: #5e2dd8 !important;
        border-color: #5e2dd8 !important;
        box-shadow: 0 5px 10px rgba(94, 45, 216, 0.3);
         display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 0.9375rem;
    line-height: 1.84615385;
    border-radius: 5px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        
    }
    .btn {
  
}


</style>

<style>
    .card-body nav
    {
        float: right;
    }
    .div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
    .data-table
    {
            width: -webkit-fill-available!important;
    }
</style>

<div class="app-content">
    <div class="side-app">
        @include('admin.layouts.pagehead')
                {{--<div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-body ">
                       @if(Session::has('errors'))
                         <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">Mobile No Already Exist on Row {{ Session::get('errors') }}</p>
                       @endif  
                       
                       @if(Session::has('success'))
                       <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                     @endif 

                        <form action="{{ route('doctor-import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                             <div class="col-12 col-lg-2">
                                <label>File</label>
                                <input required="required" type="file" class="form-control" name="import_file" id="customFile">
                              </div>
                              
                              <div class="col-12  col-lg-2">
                                <label>State</label>
                                <select onchange="getCities();getName('state_id','state')" class="form-control" name="state_id" id="state_id">
                                    <option value="">Select</option>
                                    @foreach($states as $key=>$val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                              </div>

                              <div class="col-12 col-lg-2">
                                <label>City</label>
                                <select class="form-control" onchange="getName('city_id','city')" name="city_id" id="city_id">
                                    <option vlaue="">Select</option>
                                </select>
                              </div>
                              

                               <div class="col-12 col-lg-6">
                                    <button class="btn btn-success mt-4">Import User Data</button>
                                    <a href="{{asset('/public/Sample.csv')}}" class="mt-4 btn btn-success">Download Sample</a>
                                </div>
                            </div>
                            <input type="hidden" name="state" id="state" />
                            <input type="hidden" name="city" id="city" />
                        </form>
                    </div>
                </div>
            </div>
        </div>--}}
        
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
                              <th>Doctor Name</th>
                              <th>Doctor Category</th>
                              <th>System of Medicine</th>
                              <th>Status</th>
                              <th>Created AT</th>
                              <th width="150px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($doctor as $key=>$val)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$val->doctor_name}}</td>
                            <td>{{$val->category_name}}</td>
                            <td>{{(!empty($val->system_medicine))?$val->system_medicine:'--'}}</td>
                            <td class="alert text-capitalize {{($val->status=='active')?'alert-success':'alert-danger'}}">{{$val->status}}</td>
                            <td>{{$val->created_at}}</td>
                            <td width="150px"><a href="{{route('doctor-edit', $val->id)}}" class="edit btn btn-primary btn-sm">Edit</a></td>
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
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
      <script>
        $(".data-table").DataTable({
      "scrollX": true,
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 50,
    } );
    
    function getName(SelfID,AppendID)
    {
        $("#"+AppendID).val($("#"+SelfID+' option:selected').text());
    }
    
    function getCities()
    {
           
            var parameters = 'state='+$("#state_id option:selected").val();
            $.ajax({
    		type: "GET",
    		url: '{{route('get.cities')}}',
    		data:parameters,
    		success: function(data)
    		{
    		    $("#city_id").empty();
    		    $("#city_id").append(`<option value="">Select</option>`);
                var html='';
    		    for(var i=0;i<data.length;i++)
    		    {
                    html+=`<option value="${data[i].id}">${data[i].city}</option>`;
    		    }
    			$("#city_id").append(html);
    		}
    	});
    }
    </script>
@stop
