<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/public/images/favicon.png') }}" />

    <!-- TITLE -->
    @yield('title')

    <!-- BOOTSTRAP CSS -->
    <link href="{{ asset('/public/admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('/public/admin/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('/public/admin/assets/css/skin-modes.css') }}" rel="stylesheet" />
    <link href="{{ asset('/public/admin/assets/css/dark-style.css') }}" rel="stylesheet" />

    <!-- SIDE-MENU CSS -->
    <link href="{{ asset('/public/admin/assets/plugins/sidemenu/sidemenu.css') }}" rel="stylesheet">

    <!-- SIDE-MENU CSS -->
    <link href="{{ asset('/public/admin/assets/plugins/accordion/accordion.css') }}" rel="stylesheet">

    <!-- CUSTOM SCROLL BAR CSS-->
    <link href="{{ asset('/public/admin/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('/public/admin/assets/css/icons.css') }}" rel="stylesheet" />
    <!--C3.JS CHARTS CSS -->
    <link href="{{ asset('/public/admin/assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet" />

    <!-- MORRIS CSS-->
    <link href="{{ asset('/public/admin/assets/plugins/morris/morris.css') }}" rel="stylesheet" />

      <!-- MORRIS CSS-->
      <link href="{{ asset('/public/admin/assets/plugins/summernote/summernote.css') }}" rel="stylesheet" />


    <!-- SELECT2 CSS -->
	<link href="{{ asset('/public/admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('/public/admin/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- SIDEBAR CSS -->
    <link href="{{ asset('/public/admin/assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('/public/admin/assets/colors/color1.css') }}" />
    <link rel="stylesheet"  href="{{ asset('/public/admin/assets/multiselectbox/css/multi-select.css') }}" />
    {{-- @yield('inlinecss') --}}
    <!-- JQUERY JS -->
    <script src="{{ asset('/public/admin/assets/js/jquery-3.4.1.min.js') }}"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        var siteUrl = "{{URL::to('/')}}";
    </script>
</head>

<body class="app sidebar-mini" style="background: white;">

    <!-- GLOBAL-LOADER -->
    <!--<div id="global-loader">-->
    <!--    <img src="{{ asset('/public/admin/assets/images/loader.svg') }}" class="loader-img" alt="Loader">-->
    <!--</div>-->
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            <div class="">
                <div class="side-app">
                    <center>
                        <img style="height: 100px;" src="https://play-lh.googleusercontent.com/ooZnlAZepty_CCj3xOa01YYptaTOBTkZFHPDYXI3Gw1mivEN59FpxGFG_EaV8CAhCw" />
                    </center>

                    <div class="col-lg-12">
                        <h2></h2>
                        <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Team Registration</h2>
                    </div>
                    <div class="card-body">
                        <form id="submitForm" enctype="multipart/form-data"  method="post" action="{{route('front-team-store')}}">
                        {{csrf_field()}}
                        <div class="row">

                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>

                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">E-mail *</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>

                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Phone *</label>
                                <input type="text" class="form-control" name="mobile" id="mobile">
                            </div>

                            
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">State *</label>
                                <select  required="required" onchange="getStates();getName('state_id','state_name')" name="state_id" id="state_id" class="form-control custom-select">
                                    <option value="">Select</option>
                                    @foreach ($states as $key=>$val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">District *</label>
                                <select required="required" name="city" id="city_id" class="form-control custom-select">
                                    <option value="">Select</option>
                                </select>
                            </div> 
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Qualification </label>
                                <input type="text" class="form-control" name="qualification" id="qualification">
                            </div>
                            
                            <!--<div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">-->
                            <!--    <label class="form-label">Designation </label>-->
                            <!--    <input type="text" class="form-control" name="designation" id="designation">-->
                            <!--</div>-->
                            
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">City *</label>
                               <input type="text" class="form-control" name="locality" id="locality">
                            </div>

                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label  for="value"><b>Your business/professional address</b></label>
                                <textarea class="form-control" name="business_address" id="business_address"></textarea>
                            </div>                            
                          
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label  for="value"><b>Address</b></label>
                                <textarea class="form-control" name="address" id="address"></textarea>
                            </div>
                            
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Experience *</label>
                                <textarea type="text" class="form-control" name="experiences" id="experiences"></textarea>
                            </div>
                            
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Your Plan for chikitsa sansar*</label>
                                <textarea type="text" class="form-control" name="plan" id="plan"></textarea>
                            </div>
                            
        
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Profile Pic </label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>

                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">Qualification Document (pdf only)</label>
                                <input type="file" class="form-control" name="qualification_document" id="qualification_document">
                            </div>
                            
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-12">
                                <label class="form-label">KYC </label>
                                <input type="file" class="form-control" name="document" id="document">
                            </div>
                            

                       

                         
                        </div>

                            <div class="card-footer"></div>
                                <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>
                            </div>
                          
                            <input type="hidden" name="state" id="state" />
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('/public/admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/public/admin/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('/public/admin/assets/js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript">
        $(function () {

           $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                async:true,
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm')[0]),
                success: function(data) {
                    if(data.status){
                        var btn = '<a href="#" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Create news Upchar', data.msg, btn);
                        $('#submitForm')[0].reset();
                        alert('Thanks for showing your interest our representative will contact you shortly');
                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
						errorMsg('Create news Upchar', 'Input Error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create news Upchar', 'There has been an error, please alert us immediately');
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
                url:'{{route('front-get-cities')}}',
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

    <script>
        function getName(selfID,appendID){ $("#"+appendID).val($("#"+selfID+' option:selected').text());}
        function preview_image()
{
 var total_file=document.getElementById("upload_file").files.length;
var html='';
 for(var i=0;i<total_file;i++)
 {
    html+='<div class="col-3" id=col'+i+'><img style="height:200px;" src='+URL.createObjectURL(event.target.files[i])+'><button class="btn btn-danger" onclick="removeImg('+i+')"><i class="fa fa-trash"></i></button></div>';
 }
 $('#image_preview').append(html);
}
    function removeImg(id){  $("#col"+id).remove(); event.files[id].remove();}

        function getSubCategory(thisObj,route,appendID)
        {
           var id=$("#category_id option:selected").val();
           var subid="@if(isset($product->sub_category_id)){{$product->sub_category_id}}@endif";
           var sub=parseInt(subid);
            var parameters='id='+id;
            $.ajax({
               type:'get',
               url:"{{route('get-subcategory')}}",
               data:parameters,
               dataType:'json',
                success:function(data){
                    var emptyOp = $("#"+appendID+" :first-child");
                    emptyOp.nextAll().remove();
                    var html='';
                    for(var i=0;i<data.length;i++){
                        if(data[i]['id']==sub){
                        html+='<option value="'+data[i]['id']+'" selected="selected">'+data[i]['title']+'</option>';
                        }else{
                        html+='<option value="'+data[i]['id']+'">'+data[i]['title']+'</option>';                            
                        }

                    }
                    $("#"+appendID).append(html);
            }
        });
        }
        function convertToSlug(TextObj){ $("#slug").val(TextObj.value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-'));}
        $(".demo-accordion").accordionjs();
        function readURL(input, imgId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + imgId).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    $('.select2-show-search').select2({
		minimumResultsForSearch: ''
	});
    function buttonLoading(processType, ele){
        if(processType == 'loading'){
            ele.html(ele.attr('data-loading-text'));
            ele.attr('disabled', true);
        }else{
            ele.html(ele.attr('data-rest-text'));
            ele.attr('disabled', false);
        }
    }

    function successMsg(heading,message, html = ""){
        box = $('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'+heading+'</strong><hr class="message-inner-separator"><p>'+message+'</p>'+html+'</div>');
        $('.alert-messages-box').append(box);
    }
    function errorMsg(heading,message){
        box = $('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'+heading+'</strong><hr class="message-inner-separator"><p>'+message+'</p></div>');
        $('.alert-messages-box').append(box);
    }

    </script>
    
