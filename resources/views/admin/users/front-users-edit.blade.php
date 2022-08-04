@extends('admin/layouts/default')
@section('title')
<title>Create Front User</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@stop

@section('breadcrum')
<h1 class="page-title">Edit Front Users</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">User Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  action="{{route('front-users-update',$front_users->id)}}" method="post">
                                    {{csrf_field()}}
                                    
                                    <div class="form-group row">
                                         <label>Name of Party </label>
                                       <input name="name" id="name" value="{{$front_users->name}}" type="text" class="form-control" >
                                     
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label>Name of Firm </label>
                                       <input name="business_name" id="business_name"  value="{{$front_users->business_name}}"  type="text" class="form-control" >
                                    </div>
                                    
                                     <div class="form-group row">
                                        <label>Receipt no </label>
                                       <input name="receipt_no" id="receipt_no"  value="{{$front_users->receipt_no}}"   type="text" class="form-control" >
                                    </div>
                                    

                                    <div class="form-group row">
                                        <label>Date </label>
                                       <input name="date" id="date" autocomplete="off" value="{{$front_users->date}}" type="text" class="form-control datepicker" >
                                    </div>

                                    <div class="form-group row">
                                        <label>pincode </label>
                                       <input name="pincode" id="pincode" type="text" value="{{$front_users->pincode}}"  class="form-control" >
                                    </div>

                                    <div class="form-group row">
                                        <label>Post </label>
                                       <input name="post" id="post" type="text" value="{{$front_users->post}}" class="form-control" >
                                    </div>

                                    <div class="form-group row">
                                        <label>Amount </label>
                                       <input name="redemption_value" id="redemption_value" value="{{$front_users->redemption_value}}" type="text" class="form-control" >
                                    </div>
                                    
                                     <div class="form-group row">
											<label class="form-label">State</label>
											<select  onchange="getStates()" name="state_id" id="state_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($states as $key=>$val)
                                                    <option @if($front_users->state==$val->id)  selected @endif value="{{$val->id}}">{{$val->name}}</option>  
                                                @endforeach
											</select>
                                        </div>


                                       <div class="form-group row">
											<label class="form-label">District</label>
											<select  name="city_id" id="city_id" class="form-control custom-select">
                                                <option value="">Select</option>
											</select>
                                        </div>
                                        
                                          <div class="form-group row">
                                            <label>City </label>
                                           <input name="citiess" value="{{$front_users->citiess}}"  id="citiess" type="text" class="form-control" >
                                        </div>
                                        
                                    <div class="form-group row">
                                        <label>E-mail</label>
                                        <input name="email" id="email" value="{{$front_users->email}}" type="email" class="form-control"  >
                                    </div>

                                    <div class="form-group row">
                                        <label>Mobile</label>
                                        <input name="mobile" id="mobile" value="{{$front_users->mobile}}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control"  required="required">
                                    </div>

                                    <div class="form-group row">
                                        <label>Alternate Mobile No.</label>
                                        <input name="alternate_mobile" id="alternate_mobile" value="{{$front_users->alternate_mobile}}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control" >
                                    </div>

                                    <div class="form-group row">
                                        <label>Membership Date</label>
                                        <input name="membership_date" autocomplete="off" id="membership_date"  value="{{$front_users->membership_date}}" type="text" class="datepicker form-control" >
                                    </div>


                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>

										</div>
									
                                        </form>
									</div>

								</div>
							

                        	<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Password Chnaged</h3>
									</div>
									<div class="card-body">
                                    <form id="submitFormPassword"  action="{{route('front-users-password',$front_users->id)}}" method="post">
                                    {{csrf_field()}}
                                    
                                    <div class="form-group row">
                                        <label>Password</label>
                                       <input name="change_password" id="change_password"  type="text" class="form-control" >
                                    </div>
                                    <div class="card-footer"></div>
                                        <button type="submit" id="submitButtons" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
								    </div>  
							    </form>
									</div>

								</div>
								</div>
	 </div>
							
     

@stop
@section('inlinejs')
<script src="{{ asset('/public/admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script>

 <script type="text/javascript">
  $( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  $(function () {
           $('#submitForm').submit(function(){
               event.preventDefault();
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm')[0]),
                success: function(data) {
                    if(data.status){

                        successMsg('Update User', 'User Updated...');
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create User','Input error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create User', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });



$('#submitFormPassword').submit(function(){
               event.preventDefault();
            var $this = $('#submitButtons');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitFormPassword').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitFormPassword')[0]),
                success: function(data) {
                    if(data.status){

                        successMsg('Update User', 'User Updated...');
                        $('#submitFormPassword')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create User','Input error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create User', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });
           
           });
           
        $(document).ready(function () {

// 			$('#membership_date').datetimepicker({
// 				format:'Y-m-d',
// 			});
			
// 			//minDate and maxDate Example
// 			$('#datetimepicker3').datetimepicker({
// 				 format:'Y-m-d',
// 				 timepicker:false,
// 				 minDate:'-1970/01/02', //yesterday is minimum date
// 				 maxDate:'+1970/01/02' //tomorrow is maximum date
// 			});
			
// 			//allowTimes options TimePicker Example
// 			$('#datetimepicker4').datetimepicker({
// 				datepicker:false,
// 				allowTimes:[
// 				  '11:00', '13:00', '15:00', 
// 				  '16:00', '18:00', '19:00', '20:00'
// 				]
// 			});
			
		});
    </script>
    
    <script type="text/javascript">
 
 function getStates() {
            var parameters='state_id='+$('#state_id option:selected').val();
            $("#state").val($('#state_id option:selected').text());
            $.ajax({
                type:'get',
                url:'{{route('get-cities')}}',
                data:parameters,
                dataType:'json',
                success:function(data) {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select</option>');
                    if(data.length>0)
                    {
                        for(var i=0; i<=data.length; i++)
                        {
                            var cityid = '{{$front_users->city}}';
                            if(cityid==data[i]['id'])
                            {
                               $('#city_id').append('<option selected value="'+data[i]['id']+'" >'+data[i]['city']+'</option>'); 
                            }
                            else
                            {
                                $('#city_id').append('<option value="'+data[i]['id']+'" >'+data[i]['city']+'</option>');
                            }
                            
                        }
                 }
             }
        });
    }
    getStates();

       

       function getPassword(){
           pass=  Math.random().toString(36).slice(-8);
           $('#password').val(pass);
       }
    </script>
@stop
