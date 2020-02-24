@extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
@section ('title')
Live Account Register
@endsection


@section('css-link')   
<link rel="stylesheet" href="/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/live-account-reg.css')}}"/>
<link href="/css/passwordRulesHelper.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.css">
<style type="text/css">
.rules{
  position: absolute;
  top: 100%;
  font-size: 12px;
  width: 95%
}
#message{
  position: absolute;
  font-size: 10px;
  left: 70%
}
#message1{
  position: absolute;
  font-size: 10px;
  left: 70%
}
.message{
  position: absolute;
  font-size: 10px;
  left: 73%
}
.bar{
  border-bottom: 0.099rem solid #ddd !important;
}
</style>
@endsection

  
    @section('main-body')

    <section class="main-body">
      <div class="container">
        <div class="row clearfix">
          <div class="col-md-12 col-xs-12  form-div-height">
            
            <div class="col-md-8 col-md-push-5 col-xs-12  col-sm-8 text-center">
              <!-- multistep form -->
              <form id="myform" method="post" action="{{LaravelLocalization::localizeURL('/live-account-register')}}">
                {{csrf_field()}}
                
                <ul id="progressbar">
                  <li class="active"><span style="color: #777">Personal Information</span></li>
                  <li><span style="color: #777">Personal Information</span></li>
                  <li><span style="color: #777">Account Information</span></li>
                  <li><span style="color: #777">Details</span></li>
                </ul>

                <fieldset id="x">
                  <h2 class="fs-title">Personal Information</h2>
                  <hr>
                  
                  <div class="row">
                    @if (Session::has('live_register'))
                    <span class="help-block">
                      <strong style="color: #00bf86 ;float: left;">{{ Session::get('live_register') }}</strong>
                    </span>
                    @endif  
                    <div class="row">
                      <div class="col-md-8 col-md-push-2">
                     
                    <div class="form-group">
                      <input type="text" id="fname" name="fname" style="color: #777" value="{{ old('fname') }}"  required="required" />
                      <label class="control-label" for="input">First Name</label><i class="bar"></i>
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-push-2">
                      
                      <div class="form-group">
                        <input type="text" id="lname" name="lname" style="color: #777" value="{{ old('lname') }}" required="required" />
                        <label class="control-label" for="input">Last Name</label><i class="bar"></i>
                      </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    
                    <div class="col-md-8 col-md-push-2">
                      
                    <div class="form-group">
                      <input type="email" id="email" name="email" style="color: #777" value="{{ old('email') }}" required="required" />
                      <label class="control-label" for="input">Email</label><i class="bar"></i>
                    </div>
                    @if (Session::has('email'))
                    <span class="help-block">
                      <strong style="color: #ff8080;text-align: left;">{{ Session::get('email') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-push-2">
                      
                    <div class="form-group">
                      <input type="password" id="password" name="password" style="color: #777" required="required" />
                      <label class="control-label" for="input">Password</label><i class="bar"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-md-push-2">
                      
                    <div class="form-group">
                      <input type="password" id="c_pass" name="c_pass" style="color: #777" required="required"  />
                      <label class="control-label" for="input">Confirm Password</label><i class="bar"></i>
                    </div>
                  </div>
                  
                </div>
              </div>
              
                
                <input type="button" name="next" class="next action-button" value="Next" id="next"/>
                
                
                <div class="row">
                    
                    </div>
                  </fieldset>
                  <fieldset id="a">
                    <h2 class="fs-title">Personal Information</h2>
                    <hr>
                    
                    <!-- <h3 class="fs-subtitle">This is step 1</h3> -->
                    <div class="row">
                    
                    
                    
                    <div class="col-md-6 clearfix">
                      
                          <div class="wrap">
                            
                            <div class="select">
                              <select class="select-text" id="country" name="country" style="color: #777" required>
                                <option code="" selected="selected" disabled="disabled" style="color: #777">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->countries_name}}" id="{{$country->countries_id}}" code="+{{$country->countries_isd_code}}" @if($selected_country == $country->countries_name) selected="selected" @endif>{{$country->countries_name}}</option>
                                @endforeach
                              </select>
                              <span class="select-highlight"></span>
                              <span class="select-bar"></span>
                              <small class="label-style">Country</small>

                            </div>
                            
                          </div>
                        </div>
                        <div class="col-md-6 clearfix">
                     
                      <div class="wrap">
                        
                        <!--Select with pure css-->
                        <div class="select">
                          <select id="state" name="state" class="select-text" style="color: #777" required>
                            
                          </select>
                          <span class="select-highlight"></span>
                          <span class="select-bar"></span>
                          <small class="label-style">Select State</small>
                        </div>
                        <!--Select with pure css-->
                        
                      </div>
                    </div>

                    <div class="col-md-6 clearfix">
                      <!-- <p style="margin-top: 3%">City : </p>
                      <select id="city" name="city" class="form-control input-sm"  >

                      </select> -->
                      <div class="wrap">
                        
                        <!--Select with pure css-->
                        <div class="select" style="margin-top: -7%">
                          <select id="city" name="city" class="select-text" style="color: #777" required>
                            
                          </select>
                          <span class="select-highlight"></span>
                          <span class="select-bar"></span>
                          <small class="label-style">Select City</small>
                        </div>
                        <!--Select with pure css-->
                        
                      </div>
                    </div>
                    <div class="col-md-6 clearfix">
                      <!-- <p style="margin-top: 3%">Zip Code : </p>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" id="postal_code" placeholder="Zip Code"  /> -->
                      <!-- <div class="reset-group">
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" id="postal_code" required><span class="highlight"></span><span class="bar"></span>
                        <small class="label-style">Zip Code</small>
                      </div> -->
                      <div class="form-group">
                        <input type="text" id="postal_code" name="postal_code" style="color: #777" value="{{ old('postal_code') }}" required="required" />
                        <label class="control-label" for="input">Zip Code</label><i class="bar"></i>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <!-- <p>Address : </p>
                        <textarea required="required" value="{{ old('address') }}" type="text" name="address" id="address" placeholder="Address"  /></textarea> -->
                      <!-- <div class="reset-group">
                        <input  value="{{ old('address') }}" type="text" name="address" id="address"  required><span class="highlight"></span><span class="bar"></span>
                        <small class="label-style">Address</small>
                      </div> -->
                      <div class="form-group">
                        <input type="text" id="address" name="address" style="color: #777"  value="{{ old('address') }}" required="required" />
                        <label class="control-label" for="input">Address</label><i class="bar"></i>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <!-- <p>Mobile Numbar : </p>
                        <input type="text" name="phone" value="{{ old('phone') }}" id="phone" placeholder="Phone No."  /> -->
                      <!-- <div class="reset-group">
                        <input type="text"  name="phone" value="{{ old('phone') }}" id="phone" required><span class="highlight"></span><span class="bar"></span>
                        <small class="label-style">Phone Numbar</small>
                      </div> -->
                      <div class="form-group">
                        <input type="text" id="phone" style="color: #777" value="{{ old('phone') }}" name="phone" />
                        <label class="control-label" for="input">Phone</label><i class="bar"></i>
                      </div>
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="form-group">
                      <input type="text" required="required"/>
                      <label class="control-label" for="input">Textfield</label><i class="bar"></i>
                    </div>
                  </div> -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <!-- <div class="reset-group">
                        <input type="text" id="dob" name="dob" value="{{ old('dob') }}" required><span class="highlight"></span><span class="bar"></span>
                        <small class="label-style">Birth Date</small>
                      </div> -->
                      <div class="form-group">
                        <input type="text" id="dob" style="color: #777" name="dob" value="{{ old('dob') }}" required="required" />
                        <label class="control-label" for="input">Birth Date</label><i class="bar"></i>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <input type="button" name="previous" class="previous action-button center-block" value="Previous" />
                <input type="button" name="next1" class="next1 action-button center-block" value="Next" id="next1" />
                
              </fieldset>

              <fieldset id="y">
                <h2 class="fs-title">Account Information</h2>
                <hr>
               
                  
                  <div class="row">
                    <div class="col-md-8 col-md-push-2">
                      <div class="wrap">
                        
                        <!--Select with pure css-->
                        <div class="select">
                          <select class="select-text" name="account_type" id="account_type" style="color: #777" required>
                            <option value="" disabled selected>Select Account Type</option>
                            @foreach($cms_account as $cat)
                            <option value="{{$cat->mt4_ac_type}}">{{$cat->account_type}}</option>
                            @endforeach
                          </select>
                          <span class="select-highlight"></span>
                          <span class="select-bar"></span>
                          <small class="label-style">Account Type</small>
                          <!-- <label class="select-label">Select Account Type</label> -->
                        </div>
                        <!--Select with pure css-->
                        
                      </div>
                    </div>
                  </div>
                  
                  <!-- <p>Account leverage : </p>
                  <select name="leverage" id="leverage" class="form-control input-sm" required>
                   <option value="" selected="selected" disabled="disabled">Select Leverage</option>
                    @foreach($leverage as $lev)
                      <option value="{{$lev->leverage}}">{{$lev->leverage}}:1</option>
                                                     
                    @endforeach
                  </select> -->
                  <div class="row">
                    <div class="col-md-8 col-md-push-2">
                      <div class="wrap">
                        
                        <!--Select with pure css-->
                        <div class="select">
                          <select class="select-text" name="leverage" id="leverage" style="color: #777" required>
                            <option value="" disabled selected>Select Leverage</option>
                            @foreach($leverage as $lev)
                            <option value="{{$lev->leverage}}">{{$lev->leverage}}:1</option>
                            
                            @endforeach
                          </select>
                          <span class="select-highlight"></span>
                          <span class="select-bar"></span>
                          <small class="label-style">Leverage</small>
                          <!-- <label class="select-label">Select Leverage</label> -->
                        </div>
                        <!--Select with pure css-->
                        
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8 col-md-push-2">
                      <div class="form-group">
                        
                        
                        <input type='password' name='trading_password' id='passwordField' class='' autocomplete='new-password' required="required" />
                        <span class ='message'></span>
                        <label class="control-label" for="input">Trading Password</label><i class="bar"></i>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8 col-md-push-2">
                      <div class="form-group">
                        
                        
                        <input type="password" name="c_trading_password" id="c_password" required="required"
                        maxlength="20" class="" style="margin-top: 2%">
                        <span id='message'></span>
                        <label class="control-label" for="input" style="margin-top: 2%">Confirm Trading Password</label><i class="bar"></i>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8 col-md-push-2">
                      <div class="form-group">
                        
                        
                        <input type='password' name='investor_password' id='passwordField1' class='' autocomplete='new-password' required="required" />
                        <span class ='message'></span>
                        <label class="control-label" for="input">Investor Password</label><i class="bar"></i>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8 col-md-push-2">
                      <div class="form-group">
                        
                        
                        <input type="password" name="cinvestor_password" id="c_investor_password" required="required"
                        maxlength="20" class="" style="margin-top: 2%">
                        <span id='message1'></span>
                        <label class="control-label" for="input" style="margin-top: 2%">Confirm Investor Password</label><i class="bar"></i>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <!-- <div class="form-group" style="margin-bottom: 27px">
                    <div class="col-xs-12">
                        <div class="checkbox">
                            <div style="position: absolute;left: 20%;color: #333;top: -6%">
                                <input type="checkbox" name="agree" value="agree" /> Agree with the terms and conditions
                            </div>
                        </div>
                    </div>
                  </div> -->
                  <div class="col-md-8 col-md-push-2">
                    
                    <div class="form-group">
                      <input type="checkbox" id="agree" name="agree" required="required" style="" />
                      <label class="control-label checkbox-inline small-label" for="input" style="">Agree with the terms and conditions</label><!-- <i class="bar"></i> -->
                    </div>
                  </div>
                  
                </div>

                
                <input type="button" name="previous" class="previous action-button center-block" value="Previous" />
                <input type="button" name="next2" class="next action-button center-block" value="Next" id="next2" />
              </fieldset>

              <fieldset id="z">
                <h2 class="fs-title">Details</h2>
                <hr>
                <!-- <h3 class="fs-subtitle">We will never sell it</h3> -->
                <div class="container" id="display">
                  
                </div>
                <input type="button" name="previous" class="previous action-button" value="Previous" />
                <input type="submit" name="submit" class="submit action-button my" value="Submit" style="background: #347dff" />
              </fieldset>

            </form>
          </div>
          <div class="col-md-4 col-md-pull-8 col-sm-4 col-xs-12 ">
            <div class="side-des">
              <img src="/img/open_live_account_page_img_{{app()->getLocale()}}.png" alt="" class="img-responsive center-block" style="max-width: 135px">
              <h2>{{$general_info_others->open_live_account_page_header}}</h2>
              <hr>
              <h3>{{$general_info_others->open_live_account_page_subheader}}</h3>
              <hr>
              <ul>
                <li><span class="form-icon"><i class="fa {{$general_info->open_live_account_page_icon1}}"></i></span>{{$general_info_others->open_live_account_page_text1}}</li>
                <li><span class="form-icon"><i class="fa {{$general_info->open_live_account_page_icon2}}"></i></span>{{$general_info_others->open_live_account_page_text2}}</li>
                <li><span class="form-icon"><i class="fas {{$general_info->open_live_account_page_icon3}}"></i></span>{{$general_info_others->open_live_account_page_text3}}</li>
                <li><span class="form-icon"><i class="fa {{$general_info->open_live_account_page_icon4}}"></i></span>{{$general_info_others->open_live_account_page_text4}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @endsection

   

    @section('js-link')
    <script src="/js/jquery.easing.min.js" type="text/javascript" charset="utf-8" async defer></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/jquery.validate.js"></script>
    <script type="text/javascript" src="{{asset('js/pages/live-account-reg.js')}}"></script>
    <script src="/js/passwordRulesHelper.min.js"></script>
    <script src="/js/passwordRulesHelper1.min.js"></script>
    <!-- <script type="text/javascript" src="{{asset('js/pages/passwordRulesHelper.min.js')}}"></script> -->
    <script>
      window.FontAwesomeConfig = {
        searchPseudoElements: true
      }
    </script>
    
    <script type="text/javascript">
      
      $(document).ready(function($) {
        
        var Body = $('body');
        Body.addClass('preloader-site');
      });
      $(window).load(function() {
        $('.preloader-wrapper').fadeOut();
        $('body').removeClass('preloader-site');
      });
    </script>
    <script type="text/javascript">
     
      var value=$('option:selected', '#country').attr('code');
      $('#phone').val(value);
      $('option:selected', '#country').css('color','#fff');

      
      

      $(document).on('change','#country',function(e){
        
        var value=$('option:selected', this).attr('code');
        $('#phone').val(value);
        $('option:selected', '#country').css('color','#fff');
      });
    </script>
    
    <script type="text/javascript">
     var selected_state=<?php echo json_encode($selected_state, JSON_HEX_TAG); ?>;
     var selected_city=<?php echo json_encode($selected_city, JSON_HEX_TAG); ?>;
     var selected_zipcode=<?php echo json_encode($selected_zipcode, JSON_HEX_TAG); ?>;
     $('#postal_code').val(selected_zipcode);
     

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
    })
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
  $(document).ready(function(){

    
    $(".rules").hide();
    $('#passwordField, #c_password').on('keyup', function () {
      $('#passwordField').passwordRulesValidator();
      $(".rules").show();
      $(".rules").css({'top':'75%'});

      if ($('#passwordField').val() == $('#c_password').val()) {
        $('#message').html('Password Matched').css('color', 'green');
      } 
      else 
        $('#message').html('Enter same password').css('color', 'red');

      if($('#passwordField').val() ==0 && $('#c_password').val()==0){
        $('#message').html('').css('color', 'green');
      }
    });

    

    $('#passwordField1, #c_investor_password').on('keyup', function () {

      $('#passwordField1').passwordRulesValidator1();
      $(".rules").show();
      $(".rules").css({'top':'75%'});

      if ($('#passwordField1').val() == $('#c_investor_password').val()) {
        $('#message1').html('Password Matched').css('color', 'green');
      } 
      else 
        $('#message1').html('Enter same password').css('color', 'red');

      if($('#passwordField').val() ==0 && $('#c_investor_password').val()==0){
        $('#message1').html('').css('color', 'green');
      }
    });

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$("#next").click(function(){
  var form = $("#myform");
// jQuery.validator.addMethod('selectcheck', function (value) {
//         return (value != '0');
//     }, "year required");




$.validator.addMethod("regx", function(value, element, regexpr) {          
  return regexpr.test(value);
}, "Please enter a valid Phone number.");

$.validator.addMethod("regx1", function(value, element, regexpr) {          
  return regexpr.test(value);
}, "Please enter a valid Zip Code.");

$.validator.addMethod("regx2", function(value, element, regexpr) {          
  return regexpr.test(value);
}, "Please enter a valid Address.");

$.validator.addMethod("regx3", function(value, element, regexpr) {          
  return regexpr.test(value);
}, "Please enter a valid Name.");


form.validate({
  rules: {
    

    fname: {
      required: true,
      maxlength : 30,
      regx3:  /^[a-zA-Z0-9-@#&_,.:;+\s/g] ?([a-zA-Z0-9-@#&_,.:;+\s/g]|[a-zA-Z0-9-@#&_,.:;+\s/g] )*[a-zA-Z0-9-@#&_,.:;+\s/g]$/,
      
    },
    lname: {
      required: true,
      maxlength : 30,
      regx3:  /^[a-zA-Z0-9-@#&_,.:;+\s/g] ?([a-zA-Z0-9-@#&_,.:;+\s/g]|[a-zA-Z0-9-@#&_,.:;+\s/g] )*[a-zA-Z0-9-@#&_,.:;+\s/g]$/,
      
    },
    password : {

     required: true,
     minlength: 8,
   },
   c_pass : {
    required: true,
    equalTo: '#password',
  },
  
  
  phone : {
    required: true,
    minlength:8,
    maxlength: 20,
    regx:  /^[+-]?\d+$/,
  }, 
  

  
  email: {
    required: true,
  }, 
  agree: {
    required: true,
  },

  postal_code : {
    required: true,
    regx1:  /^[a-zA-Z0-9-@#&_,.:;+\/] ?([a-zA-Z0-9-@#&_,.:;+\/]|[a-zA-Z0-9-@#&_,.:;+\/] )*[a-zA-Z0-9-@#&_,.:;+\/]$/,
    minlength:4,
    maxlength: 10
  },

  address:{
    required:true,
    regx2:/^[a-zA-Z0-9-@#&_,.:;+\/] ?([a-zA-Z0-9-@#&_,.:;+\/]|[a-zA-Z0-9-@#&_,.:;+\/] )*[a-zA-Z0-9-@#&_,.:;+\/]$/,
    maxlength : 200,
  }
  
},
messages: {
  
  fname: {
    required: "First name is required",
  },
  lname: {
    required: "Last Name is required",
  },
  password : {
    required: "Please enter the password",
  },

  c_pass: {
    required: "Please enter the same password as above"
  },
  email: {
    required: "Please enter your email address!"
  },

  address:{
    required:"Please Enter Your Address"
  }
  
  
},

});





if (form.valid()==true) {

  if(animating) return false;
  animating = true;
  
  current_fs = $(this).parent();
  next_fs = $(this).parent().next();
  
  //activate next step on progressbar using the index of next_fs
  $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
  
  //show the next fieldset
  next_fs.show(); 
  //hide the current fieldset with style
  current_fs.animate({opacity: 0}, {
    step: function(now, mx) {
      //as the opacity of current_fs reduces to 0 - stored in "now"
      //1. scale current_fs down to 80%
      scale = 1 - (1 - now) * 0.2;
      //2. bring next_fs from the right(50%)
      left = (now * 50)+"%";
      //3. increase opacity of next_fs to 1 as it moves in
      opacity = 1 - now;
      current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
      next_fs.css({'left': left, 'opacity': opacity});
    }, 
    duration: 800, 
    complete: function(){
      current_fs.hide();
      animating = false;
    }, 
    //this comes from the custom easing plugin
    easing: 'easeInOutBack'
  });

}

});


$("#next1").click(function(){
  var form = $("#myform");
// jQuery.validator.addMethod('selectcheck', function (value) {
//         return (value != '0');
//     }, "year required");


form.validate({
  rules: {
    country: {
     required: true,
   },


   
   dob: {
    required: true,
  },
  phone: {
    required: true,
    number: true,
  },

  
  country_change : {
    valueNotEquals: 0,
  },
  state : {
    required: true,
    
  },
  city : {
    required: true,
    
  },
  
  
},
messages: {
  country: {
    required: "Country required",
  },
  
  
  
  
  country_change : {
    valueNotEquals: "Please select a country"
  },

  state : {
    required: "Please select a state",
  },

  city : {
    required: "Please select a city",
  },

  postal_code : {
    required: "Please enter the zip code",
  },


  address : {
    required: "Please enter the address",
  },

  phone : {
    required : "Please input valid phone no.",

  },

  dob: {
    required: "Please enter your date of birth"
  },
  
  
}
});


if (form.valid()==true) {

  if(animating) return false;
  animating = true;
  
  current_fs = $(this).parent();
  next_fs = $(this).parent().next();
  
  //activate next step on progressbar using the index of next_fs
  $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
  
  //show the next fieldset
  next_fs.show(); 
  //hide the current fieldset with style
  current_fs.animate({opacity: 0}, {
    step: function(now, mx) {
      //as the opacity of current_fs reduces to 0 - stored in "now"
      //1. scale current_fs down to 80%
      scale = 1 - (1 - now) * 0.2;
      //2. bring next_fs from the right(50%)
      left = (now * 50)+"%";
      //3. increase opacity of next_fs to 1 as it moves in
      opacity = 1 - now;
      current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
      next_fs.css({'left': left, 'opacity': opacity});
    }, 
    duration: 800, 
    complete: function(){
      current_fs.hide();
      animating = false;
    }, 
    //this comes from the custom easing plugin
    easing: 'easeInOutBack'
  });

}


});


// $(document).on('change','#fruit',function(){
//  alert($(this).val());
// });





$("#next2").click(function(){
  // alert($('#fruit').val());exit;
  var o_pass = $('#passwordField').val();
  var s_pass = $('#c_password').val();
  if ( o_pass!= s_pass) {
    
    $('#message').html('Password doesn\'t match').css('color', 'red');
    e.preventDefault();
  }
  else{
    var flag1 = checkMatchedPass(o_pass).a;
    var flag2 = checkMatchedPass(o_pass).b;
    var flag3 = checkMatchedPass(o_pass).c;
    var flag4 = checkMatchedPass(o_pass).d;
    var flag5 = checkMatchedPass(o_pass).e;

    if (flag1 == 0) {
      $('.message').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag2 == 0) {
      $('.message').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag3 == 0) {
      $('.message').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag4 == 0) {
      $('.message').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag5 == 0) {
      $('.message').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    
  }
  var o_pass1 = $('#passwordField1').val();
  var s_pass1 = $('#c_investor_password').val();
  if ( o_pass1!= s_pass1) {
    
    $('#message1').html('Password doesn\'t match').css('color', 'red');
    e.preventDefault();
  }
  else{
    var flag6 = checkMatchedPass(o_pass1).a;
    var flag7 = checkMatchedPass(o_pass1).b;
    var flag8 = checkMatchedPass(o_pass1).c;
    var flag9 = checkMatchedPass(o_pass1).d;
    var flag10 = checkMatchedPass(o_pass1).e;

    if (flag6 == 0) {
      $('.message1').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag7 == 0) {
      $('.message1').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag8 == 0) {
      $('.message1').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag9 == 0) {
      $('.message1').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    if (flag10 == 0) {
      $('.message1').html('Check Condition').css('color', 'red');
      e.preventDefault();
    }
    
  }
  function checkMatchedPass(pass){

    regexp1 = /[^A-Z]/;
    regexp2 = /[^a-z]/;
    regexp3 = /[^a-zA-Z0-9]{1,}/;
    regexp4 = /[^0-9]{1,}/;
    var a =0;
    var b= 0;
    var c =0;
    var d= 0;
    var e =0;
    if (regexp1.test(pass)) {a= 1;}
    if (regexp2.test(pass)) {b= 1;}
    if (pass.length>=8) {c= 1;}
    if (regexp3.test(pass)) {d= 1;}
    if (regexp4.test(pass)) {e= 1;}
    return v = {a,b,c,d,e};
    

  }
  
  var form = $("#myform");

  function displayVals(){
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var email = $('#email').val();
    var country = $('#country').val();
    var state = $('#state').val();
    var city = $('#city').val();
    var address = $('#address').val();
    var postal_code = $('#postal_code').val();
    var dob = $('#dob').val();
    var phone = $('#phone').val();
    var account_type = $('#account_type').val();
    var leverage = $('#leverage').val();



    



    $('#display').html(
      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Name :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + fname + ' ' + lname + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Email :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + email + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Country :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + country + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">State :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + state + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">City :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + city + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Zip Code :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + postal_code + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Address :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + address + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Date of Birth :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + dob + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Phone :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + phone + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Account Type :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + account_type + '</p></div></div>' + 

      '<div class="row"><div class="col-md-2"><p style="font-weight: bold;">Leverage :</p></div><div class="col-md-offset-1"></div><div class="col-md-7"><p>' + leverage + ' : 1</p></div></div><br>'
      );
  }
  $( "#myform" ).change( displayVals );
  displayVals();
  


  if (form.valid()) {

    if(animating) return false;
    animating = true;
    
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    
  //activate next step on progressbar using the index of next_fs
  $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
  
  //show the next fieldset
  next_fs.show(); 
  //hide the current fieldset with style
  current_fs.animate({opacity: 0}, {
    step: function(now, mx) {
      //as the opacity of current_fs reduces to 0 - stored in "now"
      //1. scale current_fs down to 80%
      scale = 1 - (1 - now) * 0.2;
      //2. bring next_fs from the right(50%)
      left = (now * 50)+"%";
      //3. increase opacity of next_fs to 1 as it moves in
      opacity = 1 - now;
      current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'relative'
      });
      next_fs.css({'left': left, 'opacity': opacity});
    }, 
    duration: 800, 
    complete: function(){
      current_fs.hide();
      animating = false;
    }, 
    //this comes from the custom easing plugin
    easing: 'easeInOutBack'
  });
}
});




$(".previous").click(function(){
  
  if(animating) return false;
  animating = true;
  
  current_fs = $(this).parent();
  previous_fs = $(this).parent().prev();
  
  //de-activate current step on progressbar
  $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
  
  //show the previous fieldset
  previous_fs.show(); 
  //hide the current fieldset with style
  current_fs.animate({opacity: 0}, {
    step: function(now, mx) {
      //as the opacity of current_fs reduces to 0 - stored in "now"
      //1. scale previous_fs from 80% to 100%
      scale = 0.8 + (1 - now) * 0.2;
      //2. take current_fs to the right(50%) - from 0%
      left = ((1-now) * 50)+"%";
      //3. increase opacity of previous_fs to 1 as it moves in
      opacity = 1 - now;
      current_fs.css({'left': left});
      previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity,'position': 'relative'});
    }, 
    duration: 100, 
    complete: function(){
      current_fs.hide();
      animating = false;
    }, 
    //this comes from the custom easing plugin
    easing: 'easeInOutBack'
  });
});

// $(".submit").click(function(){
//   return false;
// })
$("[id='country']").on("change", function () {
  $("[name='phone']").val($(this).find("option:selected").data("code"));
});
});

</script>

<script type="text/javascript">
  $(function(){
    $( "#dob" ).datepicker({
      dateFormat: 'mm/dd/yy',
      changeMonth: true,
      changeYear: true,
      yearRange: '1940:'+ new Date().getFullYear(),
      defaultDate: new Date(1985, 00, 01)
    });
  });
</script>

<!-- <script type="text/javascript">
      $(function(){
        $('.selectpicker').selectpicker();
      });
    </script> -->
@endsection