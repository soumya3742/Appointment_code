@extends('admin/layouts/default')
@section('title')
<title>Appointment-Dashboard</title>
@stop
@section('inlinecss')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

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
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-body ">
                       @if(Session::has('errors'))
                         <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">Mobile No Already Exist on Row {{ Session::get('errors') }}</p>
                       @endif  
                       
                       @if(Session::has('success'))
                       <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                     @endif 

                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                             <div class="col-12 col-lg-2">
                                <label>File</label>
                                <input required="required" type="file" class="form-control" name="file" id="customFile">
                              </div>

                             <div class="col-12 col-lg-2">
                                <label>State</label>
                                <select onchange="getCities()" class="form-control" name="state" id="state">
                                    <option value="">Select</option>
                                    @foreach($states as $key=>$val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                              </div>

                             <div class="col-12 col-lg-2">
                                <label>City</label>
                                <select class="form-control" name="city" id="city">
                                    <option vlaue="">Select</option>
                                </select>
                              </div>


                                <div class="form-group">
                                    <button class="btn btn-success mt-4">Import User Data</button>
                                    <a href="{{asset('/public/Sample.csv')}}" class="mt-4 btn btn-success">Download Sample</a>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Front Users</h3>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Mobile</th>
                              <th>State</th>
                              <th>District</th>
                              <th>Membership Date</th>
                              <th>Password</th>
                              <th>Reporter</th>
                              <th>Referal By</th>
                              <th>Created AT</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($front_users as $key=>$val)
                        <tr>
                             <td>
                                <a href="{{route('front-users-edit',$val->id)}}" class="btn btn-primary">Edit</a>
                                @if($val->reporter == "NO" ||$val->reporter == "" )
                                <button class="btn btn-primary" onclick="getReporter({{$val->id}})" id="reporter" value="1">Make Reporter</button>
                                @else
                                <button class="btn btn-primary" onclick="getReporter({{$val->id}})" id="reporter" value="2" >Unmake Reporter</button>
                                @endif
                                
                                <button onclick="getModalData({{$val->id}})"  class="btn btn-primary">Change Password</button>
                            </td>
                            <td>{{$val->id}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->mobile}}</td>
                            <td> {{(isset($val->states->name))?$val->states->name:'--'}}</td>
                            <td> {{(isset($val->cities->city))?$val->cities->city:'--'}}</td>
                            <td>{{(!empty($val->membership_date))?$val->membership_date:'--'}}</td>
                            <td>{{$val->password_visiable}}</td>
                            <td>{{$val->reporter}}</td>
                            <td>{{(isset($val->referalby->name))?$val->referalby->name:'--'}}</td>
                            <td>{{$val->created_at}}</td>
                           
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

    <!-- View MODAL -->
<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
<!-- View CLOSED -->



 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <form action="{{route('front-users-password')}}" id="submitForm" method="GET">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="change_password" id="change_password" />
                        </div>
                    </div>
                    <!--<div class="col-md-12">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>Confirm Password</label>-->
                    <!--        <inpu type="text" class="form-control" name="c_password" id="c_password" />-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" onclick="location.reload()" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <input type="hidden" name="user_id" id="user_id" />
          </form>
      </div>
    </div>


</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
    
    function getModalData(id)
    {
        $("#exampleModal").modal("show");
        $("#user_id").val(id);
    }
     
       function getReporter(id){
            var btn_id = $("#reporter").val();
            
        //   alert(btn_id);
           
            $.ajax({
    		type: "POST",
    		url: '{{route('front-users-getreporter')}}',
    		data:{"user_id":id,"btn_id":btn_id,"_token": "{{ csrf_token() }}"},
    		success: function(data)
    		{
    		    console.log(data);
    		   if(data.status){

                         successMsg('Reporter Update', data.msg);
                         location.reload();
                       

                    }else{
                       
                        errorMsg('Reporter Update','Input error');
                    }
    		}
    	});
           
       }
    
    
    
    $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "GET",
                 //processData: false,  // Important!
                // contentType: false,
                // cache: false,
                data: {change_password:$("#change_password").val(),user_id:$("#user_id").val()},
                success: function(data) {
                    if(data.status){

                        successMsg('Password Update', 'User Created...');
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Password Update','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Password Update', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
           
        $(".data-table").DataTable({
       "scrollX": true,
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 50,
    } );
    
    function getCities()
    {
            var parameters = 'state='+$("#state option:selected").val();
            $.ajax({
    		type: "GET",
    		url: '{{route('get.cities')}}',
    		data:parameters,
    		success: function(data)
    		{
    		    $("#city").empty();
    		    $("#city").append(`<option value="">Select</option>`);
                var html='';
    		    for(var i=0;i<data.length;i++)
    		    {
                    html+=`<option value="${data[i].id}">${data[i].city}</option>`;
    		    }
    			$("#city").append(html);
    		}
    	});
    }
    </script>
@stop
