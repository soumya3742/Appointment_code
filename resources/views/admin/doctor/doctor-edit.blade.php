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
    											<select  required="required"    name="user_id" id="user_id" class="form-control custom-select">
                                                    <option value="">Select</option>
                                                    @foreach ($user as $key=>$val)
                                                        <option @if($val->id==$post->user_id){{"selected='selected'"}}@endif value="{{$val->id}}">{{$val->name}}</option>  
                                                    @endforeach
    											</select>
                                          </div>

                                        <div class="form-group col-sm-6">
											<label class="form-label">Specialization</label>
											<select  required="required"   class="form-control " onchange="getName('category_id','category_name')" name="category_id" id="category_id">
                                                <option value="">Select</option>
                                                @foreach ($category as $key=>$val)
                                                    <option @if($val->id==$post->category_id){{"selected='selected'"}}@endif value="{{$val->id}}">{{$val->title}}</option>  
                                                @endforeach
											</select>
                                        </div>
                                        
                                        
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Doctor Name *</label>
											<input  required="required"   type="text" class="form-control" name="doctor_name" value="{{$post->doctor_name}}" id="doctor_name">
                                        </div>
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Registration Number</label>
											<input type="text" class="form-control" value="{{$post->registration_number}}" name="registration_number" id="registration_number">
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Qualification  *</label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select  required="required"   class="form-control js-example-basic-multiple" name="education[]" id="education" multiple="multiple">
                                              <option @if(isset($post->education) && in_array('MBBS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MBBS">MBBS</option>
                                              <option @if(isset($post->education) && in_array('BDS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="BDS"value="BDS"> BDS</option>
                                              <option @if(isset($post->education) && in_array('MDS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MDS">MDS</option>
                                              <option @if(isset($post->education) && in_array('BAMS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="BAMS">BAMS</option>
                                              <option @if(isset($post->education) && in_array('BUMS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="BUMS">BUMS</option>
                                              <option @if(isset($post->education) && in_array('DNYS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DNYS">DNYS</option>
                                              <option @if(isset($post->education) && in_array('BNYS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="BNYS">BNYS</option>
                                              <option @if(isset($post->education) && in_array('MS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MS"> MS</option>
                                              <option @if(isset($post->education) && in_array('MD',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MD">MD</option>
                                              <option @if(isset($post->education) && in_array('DNB',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DNB">DNB</option>
                                              <option @if(isset($post->education) && in_array('DLO',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DLO">DLO</option>
                                              <option @if(isset($post->education) && in_array('DM',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DM">DM</option>
                                              <option @if(isset($post->education) && in_array('MCH',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MCH">MCH</option>
                                              <option @if(isset($post->education) && in_array('DGO',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DGO"> DGO</option>
                                              <option @if(isset($post->education) && in_array('DVD',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DVD">DVD</option>
                                              <option @if(isset($post->education) && in_array('DOMS',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DOMS">DOMS</option>
                                              <option @if(isset($post->education) && in_array('BPT',explode(',',$post->education))) {{"selected='selected'"}} @endif value="BPT">BPT</option>
                                              <option @if(isset($post->education) && in_array('MPT',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MPT">MPT</option>
                                              <option @if(isset($post->education) && in_array('DPM',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DPM">DPM</option>
                                              <option @if(isset($post->education) && in_array('DMRD',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DMRD"> DMRD</option>
                                              <option @if(isset($post->education) && in_array('BSC',explode(',',$post->education))) {{"selected='selected'"}} @endif value="BSC">BSC</option>
                                              <option @if(isset($post->education) && in_array('MSC',explode(',',$post->education))) {{"selected='selected'"}} @endif value="MSC">MSC</option>
                                              <option @if(isset($post->education) && in_array('DO',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DO">DO</option>
                                              <option @if(isset($post->education) && in_array('DHD',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DHD">DHD</option>
                                              <option @if(isset($post->education) && in_array('UMD',explode(',',$post->education))) {{"selected='selected'"}} @endif value="UMD">UMD</option>
                                              <option @if(isset($post->education) && in_array('PHD',explode(',',$post->education))) {{"selected='selected'"}} @endif value="PHD"> PHD</option>
                                              <option @if(isset($post->education) && in_array('D Orth',explode(',',$post->education))) {{"selected='selected'"}} @endif value="D Orth">D Orth</option>
                                              <option @if(isset($post->education) && in_array('DCH',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DCH">DCH</option>
                                              <option @if(isset($post->education) && in_array('DCP',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DCP">DCP</option>
                                              <option @if(isset($post->education) && in_array('DCP',explode(',',$post->education))) {{"selected='selected'"}} @endif value="DCP">DCP</option>
                                              <option @if(isset($post->education) && in_array('OTHER',explode(',',$post->education))) {{"selected='selected'"}} @endif value="OTHER">OTHER</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Experience * </label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select class="form-control" name="experience" id="experience">
                                              <option value="">Select</option>
                                                @for($i=1;$i<=30;$i++)                                                   
                                                <option value="{{$i}}" @if($post->experience==$i) {{"selected='selected'"}} @endif  >{{$i}}</option>
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

           <!--                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">-->
											<!--<label class="form-label">System Name *</label>-->
											<!--<input type="text" class="form-control" name="system_medicine" value="{{$post->system_medicine}}" id="system_medicine">-->
           <!--                            </div>-->
                                       
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">System Name *</label>
											<!--<input type="text" class="form-control" name="education"  id="education">-->
											<select class="form-control " name="system_medicine" id="system_medicine">
											    
											     <option value="">Select</option>
                                              <option value="Allopathy"  @if($post->system_medicine=='Allopathy') {{"selected='selected'"}} @endif>Allopathy</option>
                                              <option value="Homeopathic"  @if($post->system_medicine=='Homeopathic') {{"selected='selected'"}} @endif> Homeopathic</option>
                                              <option value="Aayurvedic"  @if($post->system_medicine=='Aayurvedic') {{"selected='selected'"}} @endif >Aayurvedic</option>
                                              <option value="Unanai"  @if($post->system_medicine=='Unanai') {{"selected='selected'"}} @endif  >Unanai</option>
                                              <option value="Yog and Naturopathy"  @if($post->system_medicine=='Yog and Naturopathy') {{"selected='selected'"}} @endif>Yog and Naturopathy</option>
                                              <option value="Dietician"  @if($post->system_medicine=='Dietician') {{"selected='selected'"}} @endif>Dietician</option>
                                              <option value="Physiotherapy"  @if($post->system_medicine=='Physiotherapy') {{"selected='selected'"}} @endif>Physiotherapy</option>
                                              <option value="Other"  @if($post->system_medicine=='Other') {{"selected='selected'"}} @endif> Other</option>
                                              
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6">
											<label class="form-label">State</label>
											<select  onchange="getStates()" name="state_id" id="state_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach ($states as $key=>$val)
                                                    <option @if($post->state_id==$val->id) {{"selected='selected'"}} @endif value="{{$val->id}}">{{$val->name}}</option>  
                                                @endforeach
											</select>
                                        </div>


                                        <div class="form-group col-sm-6">
											<label class="form-label">District</label>
											<select  name="city" id="city_id" class="form-control custom-select">
                                                <option value="">Select</option>
                                                @foreach($cities as $ckey=>$cval)
                                                <option @if($post->state_id==$cval->state_id){{"selected='selected'"}} @endif value="{{$cval->city}}">{{$cval->city}}</option>
                                                @endforeach
											</select>
                                        </div>
                                        <div class="form-group col-sm-6">
											<label class="form-label">Place</label>
											<input type="text"  value="{{$post->place}}" name="place" id="place_id" class="form-control custom-select">
                                                
											
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Contact No *</label>
											<input type="number" min="10"  value="{{$post->contact_no}}" class="form-control" name="contact_no" id="contact_no">
                                        </div>
                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">Alternative Mobile No</label>
											<input type="alternative_mobile_no" min="10"  value="{{$post->alternative_mobile_no}}" class="form-control" name="alternative_mobile_no" id="alternative_mobile_no">
                                        </div>

                                        <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
											<label class="form-label">E-mail *</label>
											<input type="email" class="form-control" value="{{$post->email}}" name="email" id="email">
                                        </div>

                                     <div class="form-group col-sm-6 col-lg-6 col-md-6 col-6">
                                        <div class="form-check-inline">
                                          <label class="form-check-label">
                                            <b>Our Expert</b><br /><br />
                                            <input type="radio" class="form-check-input" @if($post->our_expert=='Yes') checked @endif name="our_expert" value="Yes">Yes
                                          </label>
                                        </div>
                                        <div class="form-check-inline">
                                         <label class="form-check-label">
                                           <br /><br />
                                            <input type="radio" class="form-check-input"  @if($post->our_expert=='No') checked @endif name="our_expert" checked="checked" value="No">No
                                          </label>
                                        </div>
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
                												<option value="Diagnostic Center"  @if($dval->type=='Diagnostic Center'){{"selected='selected'"}}@endif>Diagnostic Center</option>
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
                                                                <option value="Diagnostic Center">Diagnostic Center</option>
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
                                    <div class="row">
        
                                        <div class="form-group col-sm-10 col-lg-10 col-md-10 col-10">
											<label class="form-label">Image</label>
											<input type="file" class="form-control" name="file" id="file"onchange="readURL(this, 'FileImg');">
                                        </div>

                                        <div class="col-md-2 ">
                                            <img id="FileImg" src="@if(!empty($post->images)){{url('/public'.$post->images)}}@else{{url('/public/notfound.png')}}@endif" style="width: 100px;height: 100px">
                                        </div>
                                        
                                        <div class="form-group col-sm-10 col-lg-10 col-md-10 col-10">
											<label class="form-label">Registration Certificate</label>
											<input type="file" class="form-control" name="registration_certificate" id="registration_certificate"onchange="readURL(this, 'FilesImgs');">
                                        </div>
                                        <div class="col-md-2 ">
                                                <img id="FilesImgs" src="@if(!empty($post->registration_certificate)){{url('/public'.$post->registration_certificate)}}@else{{url('/public/notfound.png')}}@endif" style="width: 100px;height: 100px">
                                                </div>
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
    function getName(selfId,AppendId)
{
    $("#"+AppendId).val($("#"+selfId+' option:selected').text());
}
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
                												<option value="Diagnostic Center">Diagnostic Center</option>
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
                        var btn = '<a href="{{route('doctor-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Update Doctor', data.msg, btn);
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
						errorMsg('Edit Doctor','Input Error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Update Doctor','There has been an error, please alert us immediately');
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
