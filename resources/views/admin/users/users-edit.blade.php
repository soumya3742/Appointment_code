@extends('admin/layouts/default')
@section('title')
<title>Edit User</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Users</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">User Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('user-update', $user->id)}}">
                                    {{csrf_field()}}
										<div class="form-group">
											<label class="form-label">Name *</label>
											<input type="text" class="form-control" name="name" id="name" placeholder="Name.." value="{{$user->name}}">
										</div>

                                        <div class="form-group">
											<label class="form-label">Email *</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Email.." value="{{$user->email}}">
										</div>
                                        <div class="form-group">
											<label class="form-label">Mobile No *</label>
											<input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{$user->mobile_no}}" placeholder="Mobile..">
										</div>
                                        <div class="form-group">
											<label class="form-label">Profile Image </label>
											<input type="file" class="form-control" name="profile_image" id="profile_image" placeholder="">
                                            <img id="profile_image_select" src="{{ asset('/public/'.$user->profile_image) }}" style="width:100px">
										</div>

										<div class="form-group">
											<label class="form-label">Role *</label>
											<select name="roles[]" id="roles" multiple="multiple" class="multi-select form-control">
												<option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                <option @if(in_array($role->id, $userRole)) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
											</select>
										</div>
                                        <div class="form-group col-sm-6">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($user->status == 1) selected @endif value="1">Active</option>
												<option @if($user->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>
										
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
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

                        successMsg('Update User', data.msg);

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
                    errorMsg('Update User', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });

           $("#profile_image").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#profile_image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            
       function getPassword(){
           pass=  Math.random().toString(36).slice(-8);
           $('#password').val(pass);
       }
    </script>
@stop