@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Mein Profil')
@section ('page-level-css')
<!--Plugin style-->
   <!--Plugin style-->
    <link type="text/css" rel="stylesheet" href="/vendors/modal/css/component.css"/>
    <link type="text/css" rel="stylesheet" href="/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css"/>
    <link rel="stylesheet" type="text/css" href="/vendors/animate/css/animate.min.css" />
    <!-- end of plugin styles -->
    <link type="text/css" rel="stylesheet" href="/css/pages/portlet.css"/>
    <link type="text/css" rel="stylesheet" href="/css/pages/advanced_components.css"/>
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
     <!--Plugin styles -->
    <link type="text/css" rel="stylesheet" href="/vendors/izitoast/css/iziToast.min.css" />

     

@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5" style="margin-left: 2%;">
                        <i class="fa fa-users"></i>
                        Mein Profil
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <!--top section widgets-->
            <div class="">

                                <div class="row">
                                    @if(Session::has('msg'))
                        <div class="alert alert-success">{{Session::get('msg')}}
                        </div>
                        @endif

                        @if(Session::has('profile-error'))
                        <div class="alert alert-danger">{{Session::get('profile-error')}}
                        </div>
                        @endif
                                    <div class="col-xs-12 col-md-12">
                                        
                                        <div class="col-md-6 m-t-25 m-b-20">
                                        
                                        <div class="col-md-12 panel panel-light-grey border border-dark" vertilize="" style="height: 138px;height: 138px;display: flex;justify-content: space-around;">
                                                
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                <form id="profile-pic-form" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" class="lazy" />
                                                    <label for="imageUpload"></label>
                                                </form>
                                                </div>
                                                <div class="avatar-preview lazy">
                                                    <div id="imagePreview" style="background-image: url('{{$profile_pic}}');">
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <div uib-collapse="panel_my_accounts" class="panel-wrapper collapse in" style="height: auto;" aria-expanded="true" aria-hidden="false">
                                                <div class="panel-body text-center pb20 pt20">
                                                    <h4 ng-bind="user.title" class="ng-binding">{{$profile->fname}} {{$profile->lname}}</h4>
                                                    <h4 class="ng-binding">ID: {{$profile->affiliate_prom_code}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        </div>
                                        <div class="col-md-6 m-t-25">
                                            
                                            <div class="panel panel-light-grey border border-dark" vertilize="" style="height: 138px;">
                                                <div class="panel-wrapper collapse in" style="height: auto;">
                                                    <div class="panel-body text-center">


                            @if($condition1)
                            @if(!$sub_condition1)
                            <h5 style="display: flex;justify-content: center;">Status :&nbsp
                                <div class="approved">
                                    <span ng-class="" data-ng-bind="" class="text-success">Genehmigt</span>   
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </h5>
                            <p>Ihr Konto ist vollständig freigegeben! 
                                Sie können nun auf alle Funktionen und Dienstleistungen von {{$general_info->company_name}} zugreifen.</p>
                            @else
                            <h5 style="display: flex;justify-content: center;">Status :&nbsp
                                <div class="approved">
                                    <span ng-class="" data-ng-bind="" class="text-info">steht aus</span>   
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </div>
                            </h5>
                            <p>
                                Dein Konto ist genehmigt! 
                                Sie können nicht auf Funktionen und Dienste innerhalb von {{$general_info->company_name}} zugreifen, ohne von Admin genehmigt zu werden.</p>
                            @endif
                            @elseif($condition2)
                            <h5 style="display: flex;justify-content: center;">Status :&nbsp 
                            <div class="not-approved">
                            <span ng-class="" data-ng-bind="" class="text-danger">Nicht bestätigt</span>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </div></h5>
                            <p>
                                Dein Konto ist nicht genehmigt! 
                                Sie können auf keine Funktionen und Dienste innerhalb von {{$general_info->company_name}} zugreifen.</p> 
                            @elseif($condition3)
                            <h5 style="display: flex;justify-content: center;">Status :&nbsp 
                            <div class="partially-approved">
                            <span ng-class="" data-ng-bind="" class="text-warning">Teilweise genehmigt</span>
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div></h5>
                            <p>Ihr Konto ist teilweise genehmigt! Sie können nicht auf alle Funktionen und Dienste innerhalb von  {{$general_info->company_name}} zugreifen.</p>
                            @else
                            <h5 style="display: flex;justify-content: center;">Status :&nbsp
                            <button type="button" class="btn btn-labeled btn-danger" style="margin-left: 3%"><span class="btn-label"><i class="fa fa-close"></i></span>steht aus</button> 
                        </h5>
                            <p>Dein Konto ist genehmigt! Sie können nicht auf Funktionen und Dienste innerhalb von {{$general_info->company_name}} zugreifen, ohne von Admin genehmigt zu werden.</p>
                            @endif
    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                       
                                        <div class="col-md-6 m-t-25 m-b-20">
                                            
                                            <div class="panel panel-light-grey border border-dark" vertilize="" >
                                                <div class="panel-wrapper collapse in" style="height: auto;">
                                                    <div class="panel-heading pb0" style="display: flex;justify-content: space-between;">
                                                        <h4>Information</h4>
                                                        <a href="#responsive" data-href="#responsive" data-toggle="modal" style="font-size: 15px;color: #92B0A8"><span style="padding: 4px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>Bearbeiten </a>
                                                    </div>
                                                    <div class="panel-body pt0 pb0">
                                                        <table class="table hidden-xs table-responsive my_table">
                                                            {{--  <thead>
                                                                <tr>
                                                                    <th>Kontakt Methoden</th>
                                                                    <th>Info</th>
                                                                </tr>
                                                            </thead>  --}}
                                                            <tbody>
                                                                <tr>
                                                                    <td>Land :</td>
                                                                    <td>{{$profile->country}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Telefonnummer :</td>
                                                                    <td>{{$profile->mobile}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Land :</td>
                                                                    <td>{{$profile->state}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Stadt :</td>
                                                                    <td>{{$profile->city}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Postleitzahl :</td>
                                                                    <td>{{$profile->postal_code}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Adresse :</td>
                                                                    <td>{{$profile->address}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="panel-footer no-border"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 m-t-25">
                                            
                                            <div class="panel panel-light-grey border border-dark" vertilize="" style="overflow: auto" >
                                                <div class="panel-wrapper collapse in" style="height: auto;">
                                                    <div class="panel-heading pb0">
                                                        <h4>Andere Details</h4>
                                                    </div>
                                                    <div class="panel-body pt0 pb0">
                                                        <table class="table hidden-xs  my_table">
                                                            {{--  <thead>
                                                                <tr>
                                                                    <th>Details</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>  --}}
                                                            <tbody>
                                                                <tr>
                                                                    <td>Partnerstatus :</td>
                                                                    <td>{!!($profile->ib_status==1?"Aktiv":"Nicht Aktiv")!!}</td>
                                                                    
                                                                </tr>

                                                                <!-- <tr>
                                                                    <td>Benachrichtigung :</td>
                                                                    <td>
                                                                <div class="dropdown">
                                                       <button class="btn btn-secondary dropdown-toggle my-edit" type="button" id="about-us1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 5px">
                                                        wählen
                                                       </button>
                                                       <div class="dropdown-menu" aria-labelledby="about-us1">
                                                           <ul style="padding-left: 10px">
                                                               <li>
                                                                   <input type="checkbox" class="noti"  value="newsletter" @if($profile->newsletter == 1) checked @endif >&nbsp Newsletter 
                                                               </li>
                                                               <li>
                                                                   <input type="checkbox" class="noti" value="market_updates" @if($profile->market_updates == 1) checked @endif>&nbsp Marktaktualisierungen
                                                               </li>
                                                               <li>
                                                                   <input type="checkbox" class="noti" value="trading_statement_daily" @if($profile->trading_statement_daily == 1) checked @endif>&nbsp Trading Statement (täglich)
                                                               </li>
                                                               <li>
                                                                   <input type="checkbox" class="noti" value="trading_statement_monthly" @if($profile->trading_statement_monthly == 1) checked @endif>&nbsp Trading Statement (monatlich)
                                                               </li>
                                                           </ul>
                                                       </div>
                                                   </div><td>
                                                                </tr> -->


                                                                <tr>
                                                                    <td>Reg Datum :</td>
                                                                    <td>{{date('d-M-Y',strtotime($profile->reg_time))}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Geburtsdatum :</td>
                                                                    <td>{{date('d-M-Y',strtotime($profile->dob))}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email :</td>
                                                                    <td>{{$profile->email}}</td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                            
                                                        </table>

                                                    </div>
                                                    <!-- <div class="panel-footer no-border">
                                                       <p style="font-size: 13px;margin-bottom: 19px">Um Ihre Email oder Geburtsdatum zu ändern, kontaktieren Sie bitte unsere
                                                        Supportabteilung.                                            </p> 
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            
                        </div>
                    </div>
    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>




<!--- responsive model -->
                <div class="modal fade in display_none" id="responsive" tabindex="-1" role="dialog" aria-hidden="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title text-white">Edit Your Info:</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <h4></h4> -->
                                        <!--  -->
                                        <form method="post" action="{{LaravelLocalization::localizeURL('/update-profile')}}" id="myform">
                                            {{csrf_field()}}

                                                    
                                        <div class="form-group row">
                                            <div class="col-lg-4 text-lg-right">
                                                <label for="country" class="form-control-label">Country
                                                    :</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <div class="input-group">
                                                    <select name="country" id="country"  required="required" class="form-control">
                    <option value="" code="">Select Country</option>
                        @foreach($countries as $country)
                        <option value="{{$country->countries_name}}" id="{{$country->countries_id}}" @if($profile->country==$country->countries_name) selected @endif>{{$country->countries_name}}</option>
                        @endforeach
                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-4 text-lg-right">
                                                <label for="state" class="form-control-label">State
                                                    :</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <div class="input-group">
                                                    <select name="state" id="state"  required="required" class="form-control">
                    <option value="" id="">Select State</option>
                       
                        <option value="{{$profile->state}}">{{$profile->state}}</option>
                        
                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-4 text-lg-right">
                                                <label for="city" class="form-control-label">City
                                                    :</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <div class="input-group">
                                                    <select name="city" id="city"  required="required" class="form-control">
                    <option value="" id="">Select City</option>
                       
                        <option value="{{$profile->city}}">{{$profile->city}}</option>
                        
                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-4 text-lg-right">
                                                <label for="zip" class="form-control-label">Zip Code
                                                    :</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <div class="input-group">
                                                    <input type="text" id="zip"  name="zip" value="{{$profile->postal_code}}"
                                                           class="form-control" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group gender_message row">
                                            <div class="col-lg-4 text-lg-right">
                                                <label fpr="mobile" class="form-control-label">Mobile No :</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <div class="input-group">
                                                <input type="text" id="phone_with_code"  name="mobile" value="{{$profile->mobile}}"
                                                           class="form-control" required="required">
                                                    
                                                        
                                                </div>
                                                
                                                    @if(Session::has('mobile_error'))
                                                    <span class="text-danger"> 
                            {{Session::get('mobile_error')}}
                            </span>
                            @endif
                                                 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 text-lg-right">
                                                <label for="address" class="form-control-label">Address:</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <input type="text" name="address" value="{{$profile->address}}" class="form-control" required="required">
                                            </div>
                                        </div>

                                    </div>
                                    

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                <button type="submit" class="btn btn-success" value="update">Save changes</button>

                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END modal-->

@endsection

@section ('page-level-js')
<!--End of global scripts-->
<script type="text/javascript" src="/js/pages/modals.js"></script>
<script src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/vendors/izitoast/js/iziToast.min.js"></script>
<!--End of plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="/js/pages/izi_toastr.js"></script>
<!-- end of page level scripts-->
    <script type="text/javascript">
$(function(){
   var selected_state=<?php echo json_encode($profile->state, JSON_HEX_TAG); ?>;
     var selected_city=<?php echo json_encode($profile->city, JSON_HEX_TAG); ?>;
     var selected_zipcode=<?php echo json_encode($profile->postal_code, JSON_HEX_TAG); ?>;
  $('#zip').val(selected_zipcode);
  
  $('.lazy').Lazy();

  var id=$('option:selected', '#country').attr('id');
   $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-states')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 
                       
                          $('#state').html( data );

$('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
            $(this).attr("selected","selected");    
        }
});


var id=$('option:selected', '#state').attr('id');
    
   $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 
                       
                          $('#city').html( data );
                          $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
            $(this).attr("selected","selected");    
        }
});

                        
                 }
    });
                        
                 }
    });
   $(document).on('change','#country',function(){
    var id=$('option:selected', '#country').attr('id');
   $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-states')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 
                       
                          $('#state').html( data );
                          $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
            $(this).attr("selected","selected");    
        }
});
                        
                 }
    });
   });
});
</script>

<script type="text/javascript">



  
   $(document).on('change','#state',function(){

    var id=$('option:selected', '#state').attr('id');

   $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 
                       
                          $('#city').html( data );
                          $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
            $(this).attr("selected","selected");    
        }
});
                        
                 }
    });
   })
</script>
<script>
    $(function(){
        function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    fd = new FormData();

    fd.append( 'profile_pic', $('input[type=file]')[0].files[0] );
    fd.append('_token',$('input[name=_token]').val());

    $.ajax({
            url: "{{LaravelLocalization::localizeURL('/upload-profile-pic')}}",
            type: "POST",
            data: fd,
            contentType: false,
            processData:false,
            success: function(data)
            {
            
            },
            error: function() 
            {
                
            }           
       });
    
    readURL(this);
});
    })
</script>
<script>
    $('input.noti').on('change',function(){
        var field = $(this).val();
        var agree = 0;
       if($(this).is(':checked')){agree = 1;}

        $.ajax({
        url: "{{LaravelLocalization::localizeURL('/notification-status-update')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            field:field,
            agree:agree
        },
        
    });

    });
</script>
<script type="text/javascript">
    $(function(){
        var form = $('#myform');
        $.validator.addMethod("regx2", function(value, element, regexpr) {          
        return regexpr.test(value);
        }, "Please enter a valid Address.");

        form.validate({
            rules: {
                address:{
                    regx2:/^[a-zA-Z0-9-@#&_,.:;+\/] ?([a-zA-Z0-9-@#&_,.:;+\/]|[a-zA-Z0-9-@#&_,.:;+\/] )*[a-zA-Z0-9-@#&_,.:;+\/]$/,
                }
            }
        });
    });
</script>
@endsection