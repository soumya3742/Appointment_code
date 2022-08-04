@extends('admin/layouts/default')
@section('title')
<title>Create Doctor</title>
@stop

@section('inlinecss')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('/public/admin/assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet"/>
@stop

@section('breadcrum')
<h1 class="page-title">Create Doctor </h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"> Doctor</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
</ol>
@stop

@section('content')
<link href="{{ asset('/public/admin/assets/plugins/tag-selector/tagsinput.css') }}" rel="stylesheet"/>
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->

        <!-- COL END -->
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Doctor Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('doctor-store')}}">
                                    {{csrf_field()}}
                                    <div class="row">
                                        
                                          <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Users</label>
											<select  required="required"  name="user_id" id="user_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($user as $key=>$val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>  
                                                @endforeach
											</select>
                                        </div>
                                        
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Specialization</label>
											<select  required="required" onchange="getName('category_id','category_name')" name="category_id" id="category_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($category as $key=>$val)
                                                    <option value="{{$val->id}}">{{$val->title}}</option>  
                                                @endforeach
											</select>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Doctor Name *</label>
											<input type="text" class="form-control" name="doctor_name" id="doctor_name">
                                        </div>


                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Qualification *</label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select class="form-control js-example-basic-multiple" name="education[]" id="education" multiple="multiple">
                                              <option value="MBBS">MBBS</option>
                                              <option value="BDS"> BDS</option>
                                              <option value="BAMS">BAMS</option>
                                              <option value="BUMS">BUMS</option>
                                              <option value="BHMS">BHMS</option>
                                              <option value="BYNS">BYNS</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Experience *</label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select class="form-control " name="experience" id="experience">
                                              <option value="">Select</option>
                                                @for($i=1;$i<=30;$i++)                                                   
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endfor    
                                            </select>
                                        </div>
                                        
          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Hospital Name *</label>-->
										<!--	<input type="text" class="form-control" name="hospital_name"  id="hospital_name">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Clinic Address *</label>-->
										<!--	<input type="text" class="form-control" name="clinic_address" id="clinic_address">-->
          <!--                              </div>-->
                                        

										<!--<div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Specialist Name *</label>-->
										<!--	<input type="text" class="form-control" name="specialist_name" id="specialist_name">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">System Name *</label>-->
										<!--	<input type="text" class="form-control" name="system_medicine" id="system_medicine">-->
          <!--                              </div>-->

                                       
                                        

                                        <div class="form-group col-sm-6">
											<label class="form-label">State</label>
											<select  required="required" onchange="getStates()" name="state_id" id="state_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($states as $key=>$val)
                                                    <option value="{{$val->id}}">{{$val->name}}</option>  
                                                @endforeach
											</select>
                                        </div>


                                        <div class="form-group col-sm-6">
											<label class="form-label">District</label>
											<select required="required" name="city" id="city_id" class="form-control custom-select">
                                                <option value="">Select</option>
											</select>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Contact No *</label>
											<input type="number" min="10"  class="form-control" name="contact_no" id="contact_no">
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">E-mail *</label>
											<input type="email" class="form-control" name="email" id="email">
                                        </div>

                                        
										<!--<div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Latitude *</label>-->
										<!--	<input type="text" class="form-control" name="latitude" id="latitude">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Longitude *</label>-->
										<!--	<input type="text" class="form-control" name="longitute" id="longitute">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-12 col-md-6 col-6">-->
										<!--	<label class="form-label">Fees *</label>-->
										<!--	<input type="number" class="form-control" name="fees" id="fees">-->
          <!--                              </div>-->

                                        <div class="form-group w-100"  id="AddMoreData">
                                            <div class="row p-2">
                                                <div class="col-11 pb-4">
                                                    <div class="row">
                                                        
                                                        <div class="col-4 pb-3">
                                                            <label>Type</label>
                                                        	<select name="type[]" id="status" class="form-control custom-select">
                												<option value="">Select</option>
                												<option value="Hospital">Hospital</option>
                												<option value="Clinic">Clinic</option>
                											</select>
                                                        </div>
                                                        
                                                        <div class="col-4 pb-3">
                                                                <label>Hospital / Clinic Name</label>
                                                                <input type="text" class="form-control" name="hospital_name[]" id="hospital_name" />
                                                        </div>

            
                                                        <div class="col-4 pb-3">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control" name="address[]" id="address" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Timing</label>
                                                                <input type="text" class="form-control" name="timing[]" id="timing" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Fees</label>
                                                                <input type="text" class="form-control" name="fees[]" id="fees" />
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <button onclick="addMoreTimings()" type="button" class="btn btn-sm mt-5 btn-success">
                                                         <i class="fa fa-plus"></i>
                                                     </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       

                                        <div class="form-group col-sm-12">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option value="active">Active</option>
												<option value="inactive">InActive</option>
											</select>
                                        </div>
                                   

                                        <div class="card-footer">
                                            
                                        </div>
                                        
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>
                                        
                                        </div>
                                            <input type="hidden" name="state" id="state"  />
                                            <input type="hidden" name="category_name" id="category_name"  />
                                        </form>
									</div>
								</div>
							</div><!-- COL END -->

        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script src="{{ asset('/public/admin/assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('/public/admin/assets/plugins/tag-selector/tagsinput.js') }}"></script>
<script type="text/javascript">
var cnt=1;
    function addMoreTimings(){
       
        // var html='';
        // html+='<div class="row pt-4" id="ROW'+cnt+'">';
        // html+='    <div class="col-5">';
        // html+='      <label><b>Hospital Timing</b></label>';
        // html+='         <div class="row">';
        // html+='             <div class="col-6"><input required="required" class="form-control" type="time" name="hospital_start[]"></div>';
        // html+='             <div class="col-6"><input required="required" class="form-control" type="time" name="hospital_end[]"></div>';
        // html+='        </div>';
        // html+='    </div>';

        // html+='    <div class="col-5">';
        // html+='        <label><b>Home Timing</b></label>';
        // html+='        <div class="row">';
        // html+='            <div class="col-6"><input required="required" class="form-control" type="time" name="home_start[]"></div>';
        // html+='            <div class="col-6"><input required="required" class="form-control" type="time" name="home_end[]"></div>';
        // html+='        </div>';
        // html+='    </div>';

        // html+='    <div class="col-2  d-flex align-items-center ">';
        // html+='        <button onclick="RemoveTimingsRows('+cnt+')" type="button" class="btn btn-sm mt-5 btn-danger">';
        // html+='            <i class="fa fa-trash"></i>';
        // html+='        </button>';
        // html+='    </div>';
        // html+='</div>';
        
        $("#AddMoreData").append(`<div class="row p-2"  id="ROW${cnt}">
                                                <div class="col-11 pb-4">
                                                    <div class="row">
                                                        
                                                       <div class="col-4 pb-3">
                                                            <label>Type</label>
                                                        	<select name="type[]" id="status" class="form-control custom-select">
                												<option value="">Select</option>
                												<option value="Hospital">Hospital</option>
                												<option value="Clinic">Clinic</option>
                											</select>
                                                        </div>
                                                        
                                                        <div class="col-4 pb-3">
                                                                <label>Hospital / Clinic Name</label>
                                                                <input type="text" class="form-control" name="hospital_name[]" id="hospital_name" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control" name="address[]" id="address" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Timing</label>
                                                                <input type="text" class="form-control" name="timing[]" id="timing" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Fees</label>
                                                                <input type="text" class="form-control" name="fees[]" id="fees" />
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <button onclick="RemoveTimingsRows(${cnt})" type="button" class="btn btn-sm mt-5 btn-danger">
                                                         <i class="fa fa-trash"></i>
                                                     </button>
                                                </div>
                                            </div>`);
                                            
                                            
    }

    function RemoveTimingsRows(id){     $("#ROW"+id).remove(); }

  $('.Description').summernote({ height:250 });
  function convertToSlug(TextObj){ $("#slug").val(TextObj.value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-'));}
        $(function () {

            $('.js-example-basic-multiple').select2();
  
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
                        var btn = '<a href="{{route('doctor-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Create doctor', data.msg, btn);
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
						errorMsg('Create doctor', 'Input Error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create doctor', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });

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
                            $('#city_id').append('<option value="'+data[i]['city']+'" >'+data[i]['city']+'</option>');
                        }
                 }
             }
        });
    }



    </script>
@stop
