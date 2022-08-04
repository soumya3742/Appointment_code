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
<h1 class="page-title">Create Front Users</h1>
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
                                    <form id="submitForm"  action="{{route('save-front-users')}}" method="post">
                                    {{csrf_field()}}

                                    <div class="form-group row">
                                        <label>Name of Party </label>
                                       <input name="name" id="name" type="text" class="form-control" required="required" >
                                    </div>

                                    <div class="form-group row">
                                        <label>Name of Firm </label>
                                       <input name="business_name" id="business_name" type="text" class="form-control" >
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label>Receipt no </label>
                                       <input name="receipt_no" id="receipt_no" type="text" class="form-control" >
                                    </div>
                                    

                                    <div class="form-group row">
                                        <label>Date </label>
                                       <input name="date" id="date" autocomplete="off" type="text" class="form-control datepicker" >
                                    </div>

                                    <div class="form-group row">
                                        <label>pincode </label>
                                       <input name="pincode" id="pincode" type="text" class="form-control" >
                                    </div>

                                    <div class="form-group row">
                                        <label>Post </label>
                                       <input name="post" id="post" type="text" class="form-control" >
                                    </div>

                                    <div class="form-group row">
                                        <label>Amount </label>
                                       <input name="redemption_value" id="redemption_value" type="text" class="form-control" >
                                    </div>
                                    
                                        <div class="form-group row">
        									<label class="form-label">State</label>
        									<select onchange="getStates()" name="state_id" id="state_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($states as $key=>$val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>  
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
                                           <input name="citiess" id="citiess" type="text" class="form-control" >
                                        </div>
                                    

                                    <div class="form-group row">
                                        <label>E-mail</label>
                                        <input name="email" id="email"  type="email" class="form-control"  required="required">
                                    </div>

                                    <div class="form-group row">
                                        <label>Mobile</label>
                                        <input name="mobile" id="mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control"  required="required">
                                    </div>

                                    <div class="form-group row">
                                        <label>Alternate Mobile No.</label>
                                        <input name="alternate_mobile" id="alternate_mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control"  >
                                    </div>


                                    <div class="form-group row">
                                        <label>Membership Date</label>
                                        <input  autocomplete="off" name="membership_date" id="membership_date" type="text" class="form-control datepicker" >
                                       
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label>Paasword</label>
                                        <input name="password" type="password" type="text" class="form-control"  required="required">
                                        
                                    </div>
                                
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>

										</div>
                                        </form>
									</div>

								</div>
							</div><!-- COL END -->

        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript">

    $( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});


   function setField(){
       var vla= $("#help_india option:selected").val();
        if(vla=='yes'){
            $("#help_india_div").removeClass('d-none');
            $("#help_india_id").attr('required','required');
        }
        else
        {
            $("#help_india_id").removeAttr('required');
            $("#help_india_div").addClass('d-none');
        }
    }
        $(function () {
            $('#roles').multiSelect();
           $('#submitForm').submit(function(){
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

                        successMsg('Create User', 'User Created...');
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

           });

       function getPassword(){
           pass=  Math.random().toString(36).slice(-8);
           $('#password').val(pass);
       }
       
       
       
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
                            $('#city_id').append('<option value="'+data[i]['id']+'" >'+data[i]['city']+'</option>');
                        }
                 }
             }
        });
    }
    
    </script>
@stop
