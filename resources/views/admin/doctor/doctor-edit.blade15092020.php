@extends('admin/layouts/default')
@section('title')
<title>Edit Doctor</title>
@stop

@section('inlinecss')

<!-- WYSIWYG EDITOR CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('/public/admin/assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet"/>
@stop

@section('breadcrum')
<h1 class="page-title">Edit Doctor</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Doctor</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">
        <link href="{{ asset('/public/admin/assets/plugins/tag-selector/tagsinput.css') }}" rel="stylesheet"/>
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
                                    <form id="submitForm"  method="post" action="{{route('doctor-update', $post->id)}}">
                                    {{csrf_field()}}
                                    <div class="row">

                                          <div class="form-group col-sm-6">
											    <label class="form-label">Users</label>
    											<select  required="required"  name="user_id" id="user_id" class="form-control custom-select">
                                                    <option value="">Select</option>
                                                    @foreach ($user as $key=>$val)
                                                        <option @if($val->id==$post->user_id){{"selected='selected'"}}@endif value="{{$val->id}}">{{$val->name}}</option>  
                                                    @endforeach
    											</select>
                                          </div>

                                        <div class="form-group col-sm-6">
											<label class="form-label">Specialization</label>
											<select  required="required" onchange="getName('category_id','category_name')" name="category_id" id="category_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($category as $key=>$val)
                                                    <option @if($val->id==$post->category_id){{"selected='selected'"}}@endif value="{{$val->id}}">{{$val->title}}</option>  
                                                @endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Doctor Name *</label>
											<input type="text" class="form-control" name="doctor_name" value="{{$post->doctor_name}}" id="doctor_name">
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Qualification  *</label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select class="form-control js-example-basic-multiple" name="education[]" id="education" multiple="multiple">
                                              <option @if(isset($post->education) && in_array('MBBS',explode(', ',$post->education))) {{"selected='selected'"}} @endif value="MBBS">MBBS</option>
                                              <option @if(isset($post->education) && in_array('BDS',explode(', ',$post->education))) {{"selected='selected'"}}  @endif value="BDS"> BDS</option>
                                              <option @if(isset($post->education) && in_array('BAMS',explode(', ',$post->education))) {{"selected='selected'"}} @endif value="BAMS">BAMS</option>
                                              <option @if(isset($post->education) && in_array('BUMS',explode(', ',$post->education))) {{"selected='selected'"}} @endif value="BUMS">BUMS</option>
                                              <option @if(isset($post->education) && in_array('BHMS',explode(', ',$post->education))) {{"selected='selected'"}} @endif value="BHMS">BHMS</option>
                                              <option @if(isset($post->education) && in_array('BYNS',explode(', ',$post->education))) {{"selected='selected'"}} @endif value="BYNS">BYNS</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Experience *</label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select class="form-control" name="experience" id="experience">
                                              <option value="">Select</option>
                                                @for($i=1;$i<=30;$i++)                                                   
                                                <option value="{{$i}}" @if($post->experience==$post->experience) {{"selected='selected'"}} @endif  >{{$i}}</option>
                                                @endfor    
                                            </select>
                                        </div>

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Hospital Name *</label>-->
										<!--	<input type="text" class="form-control" name="hospital_name" value="{{$post->hospital_name}}" id="hospital_name">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Clinic Address *</label>-->
										<!--	<input type="text" class="form-control" name="clinic_address" value="{{$post->clinic_address}}" id="clinic_address">-->
          <!--                              </div>-->
                                        
										<!--<div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Specialist Name *</label>-->
										<!--	<input type="text" class="form-control" name="specialist_name" value="{{$post->specialist_name}}" id="specialist_name">-->
          <!--                              </div>-->

           <!--                             <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
											<!--<label class="form-label">System Name *</label>-->
											<!--<input type="text" class="form-control" name="system_medicine" value="{{$post->system_medicine}}" id="system_medicine">-->
           <!--                             </div>-->

                                        <div class="form-group col-sm-6">
											<label class="form-label">State</label>
											<select  required="required" onchange="getStates()" name="state_id" id="state_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($states as $key=>$val)
                                                    <option @if($post->state_id==$val->id) {{"selected='selected'"}} @endif value="{{$val->id}}">{{$val->name}}</option>  
                                                @endforeach
											</select>
                                        </div>


                                        <div class="form-group col-sm-6">
											<label class="form-label">District</label>
											<select required="required" name="city" id="city_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach($cities as $ckey=>$cval)
                                                <option @if($post->state_id==$cval->state_id){{"selected='selected'"}} @endif value="{{$cval->city}}">{{$cval->city}}</option>
                                                @endforeach
											</select>
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Contact No *</label>
											<input type="number" min="10"  value="{{$post->contact_no}}" class="form-control" name="contact_no" id="contact_no">
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">E-mail *</label>
											<input type="email" class="form-control" value="{{$post->email}}" name="email" id="email">
                                        </div>

										<!--<div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Latitude *</label>-->
										<!--	<input type="text" class="form-control"  value="{{$post->latitude}}"  name="latitude" id="latitude">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Longitude *</label>-->
										<!--	<input type="text" class="form-control"  value="{{$post->longitute}}"  name="longitute" id="longitute">-->
          <!--                              </div>-->

          <!--                              <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
										<!--	<label class="form-label">Fees *</label>-->
										<!--	<input type="number" class="form-control" name="fees"  value="{{$post->fees}}"  id="fees">-->
          <!--                              </div>-->
                                    
                                </div>

                           
                                <div class="form-group col-12"  id="AddMoreData">
                                @if(is_object($post->doctortimings) && count($post->doctortimings)>0)
                                    @foreach($post->doctortimings as $dkey=>$dval)
                                        <div class="form-group w-100"  id="AddMoreData">
                                            <div class="row p-2" id="ROW{{$dval->id}}">
                                                <div class="col-11 pb-4">
                                                    <div class="row">
                                                        
                                                        <div class="col-4 pb-3">
                                                            <label>Type</label>
                                                        	<select name="type[]" id="status" class="form-control custom-select">
                												<option value="">Select</option>
                												<option value="Hospital"  @if($dval->type=='Hospital'){{"selected='selected'"}}@endif>Hospital</option>
                												<option value="Clinic"  @if($dval->type=='Clinic'){{"selected='selected'"}}@endif>Clinic</option>
                											</select>
                                                        </div>
                                                        
                                                        <div class="col-4 pb-3">
                                                                <label>Hospital / Clinic Name</label>
                                                                <input type="text"  value="{{$dval->hospital_name}}"  class="form-control" name="hospital_name[]" id="hospital_name" />
                                                        </div>

            
                                                        <div class="col-4 pb-3">
                                                                <label>Address</label>
                                                                <input type="text" value="{{$dval->address}}"  class="form-control" name="address[]" id="address" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Timing</label>
                                                                <input type="text"  value="{{$dval->timing}}"  class="form-control" name="timing[]" id="timing" />
                                                        </div>
            
                                                        <div class="col-4 pb-3">
                                                                <label>Fees</label>
                                                                <input type="text"  value="{{$dval->fees}}"  class="form-control" name="fees[]" id="fees" />
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                     @php $onclick="onclick=RemoveTimingByAjax('$dval->id',this)"; if($dkey==0) $onclick = "onclick=addMoreTimings()"; @endphp
                                                    <button id="buttondel{{$dval->id}}" {{$onclick}}  type="button" class="btn btn-sm mt-5 btn-@if($dkey==0){{'success'}}@else{{'danger'}}@endif">
                                                       <i class="fa fa-@if($dkey==0){{'plus'}}@else{{'trash'}}@endif"></i>
                                                     </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                     @endforeach
                                    @else
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
                                 @endif
                                </div>
                                 <div class="form-group col-sm-12">
                                        <label class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control custom-select">
                                            <option @if($post->status == 'active') selected @endif value="active">Active</option>
                                            <option @if($post->status == 'inactive') selected @endif value="inactive">InActive</option>
                                        </select>
                                    </div>



                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        </div>

                                        <input type="hidden" name="state" id="state"   value="{{$post->state}}" />
                                        <input type="hidden" name="category_name" id="category_name" value="{{$post->category_name}}" />
                                        </form>
									</div>

								</div>
							</div><!-- COL END -->
    </div>
</div>

@stop
@section('inlinejs')

<script src="{{ asset('admin/assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('/public/admin/assets/plugins/tag-selector/tagsinput.js') }}"></script>
    <script type="text/javascript">
    var cnt=1;
    function addMoreTimings(){
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

    function RemoveTimingByAjax(id,thisObj){
        // alert(id);
        // return false;

        var con = confirm('Are You Sure Want to Delete This Timing ?');
        if(con==true){
            var $this = $('#'+thisObj.id);
            buttonLoading('loading', $this);
            var parameters='id='+id;
            $.ajax({
            type:'get',
            url:'{{route('delete-timings')}}',
            data:parameters,
            dataType:'json',
            success:function(data) {
                    if(data.status==true){
                        $("#ROW"+id).remove();
                        errorMsg('Delete Timing', data.msg);
                    }
                }
        });
       }
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
                        var btn = '<a href="{{route('drug-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Update drug', data.msg, btn);
						window.location.reload();
                        //$('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
						errorMsg('Edit drug', 'Input Error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Update drug', 'There has been an error, please alert us immediately');
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
