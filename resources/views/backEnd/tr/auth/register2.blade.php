
@extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
@section ('title')
Register
@endsection

@section('css-link')


<link rel="stylesheet" href="/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<!-- main css file -->
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/live-account-reg.css')}}"/>
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
  top: 100%;
}
.message{
  position: absolute;
  font-size: 10px;
  
  left: 60%;
  top: 30%

}
</style>
@endsection
  <!-- <div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{asset('img/loader.gif')}}" alt="loading..." style="max-width: 200px">
    </div>
  </div> -->
   <!--  <section class="main-header">
      <div class="container">
        <div class="row">
          <div class="col-xs-6">
            <div class="header-img clearfix">
              <a href="/"><img src="/img/logo.png" alt="" style="width:{{$general_info->logo_width}};height:{{$general_info->logo_height}}"></a>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="header-right-content">
              <div class="button-sign" style="width: 150px">
                <p>Already Registered?<span><a href="/login">Sign In</a></span></p>
                
              </div>
              <select class="selectpicker" data-width="fit">
                  <option data-content='<span class="flag-icon flag-icon-us"></span> English'></option>
                  <option  data-content='<span class="flag-icon flag-icon-fr"></span> French'></option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    @section('main-body')

    <section class="main-body">
      <div class="container">
        <div class="row clearfix">
          <div class="col-md-12 col-xs-12  form-div-height">
            
            <div class="col-md-8 col-md-push-5 col-xs-12  col-sm-8 text-center">
              <!-- multistep form -->
              <form id="myform" method="post" action="{{LaravelLocalization::localizeURL('/register')}}">
                {{csrf_field()}}
                @if ($ref_id)
                <input type="hidden" name="referred_by" value="{{$ref_id}}">
                @endif
                <fieldset id="x">
                  <h2 class="fs-title">Kayıt olmak</h2>
                  <hr>
                  
                  <!-- <h3 class="fs-subtitle">This is step 1</h3> -->
                  <div class="row">
                    @if (Session::has('register'))
                    <span class="help-block">
                      <strong style="color: #00bf86 ;float: left;">{{ Session::get('register') }}</strong>
                    </span>
                    @endif  
                    <div class="row">
                      <div class="col-md-5 col-md-push-1">
                      <!-- <p>First Name : </p>
                        <input type="text" name="fname" value="{{ old('fname') }}" placeholder="First Name" id="fname" /> -->

                    <!-- <div class="form-group">
                      <div class="reset-group">
                        <input type="text" name="fname" value="{{ old('fname') }}" placeholder="First Name"><span class="highlight" ></span><span class="bar"></span>
                        <label>First Name</label>
                      </div>
                      
                    </div> -->
                    <div class="form-group">
                      <input type="text" id="fname" name="fname" style="color: #777" value="{{ old('fname') }}"  required="required" />
                      <label class="control-label" for="input">İsim</label><i class="bar"></i>
                    </div>

                  </div>
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="text" id="lname" name="lname" style="color: #777" value="{{ old('lname') }}" required="required" />
                      <label class="control-label" for="input">Soyadı</label><i class="bar"></i>
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  
                  <div class="col-md-10 col-md-push-1">
                      <!-- <p>Email : </p>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" id="email"  /> -->
                      <!-- <div class="form-group">
                      <div class="reset-group">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"><span class="highlight"></span><span class="bar"></span>
                        <label>Email</label>
                      </div>
                        
                    </div> -->
                    <div class="form-group">
                      <input type="email" id="email" name="email" style="color: #777" value="{{ old('email') }}" required="required" />
                      <label class="control-label" for="input">E-posta</label><i class="bar"></i>
                    </div>
                    @if (Session::has('email'))
                    <span class="help-block">
                      <strong style="color: #ff8080;text-align: left;">{{ Session::get('email') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      
                      
                      <input type='password' name='password' id='passwordField' class='' autocomplete='new-password' required="required" />
                      <!-- <span class ='message'></span> -->
                      <label class="control-label" for="input">Parola</label><i class="bar"></i>
                    </div>
                  </div>
                  <!-- <div class="clearfix"></div> -->
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      
                      
                      <input type="password" name="c_password" id="c_password" required="required"
                      class="" style="">
                      <!-- <span id='message'></span> -->
                      <label class="control-label" for="input" style="">Şifreyi Onayla</label><i class="bar"></i>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 col-md-push-1">
                      <!-- <p>Birth Date : </p>
                        <input type="text" name="dob" value="{{ old('dob') }}" id="dob" class="" placeholder="Birthdate" required> -->
                      <!-- <div class="form-group">
                      <div class="reset-group">
                        <input type="password" id="password" name="password" value="" placeholder="Password"><span class="highlight"></span><span class="bar"></span>
                        <label>Birth Date</label>
                      </div>
                        
                    </div> -->
                    <div class="wrap">
                      
                      <!--Select with pure css-->
                      <div class="select">
                        <select class="select-text" id="country" name="country" style="color: #777" required>
                          <option code="" selected="selected" disabled="disabled" style="color: #777">Ülke Seç</option>
                          @foreach($countries as $country)
                          <option value="{{$country->countries_name}}" id="{{$country->countries_id}}" code="+{{$country->countries_isd_code}}" @if($selected_country == $country->countries_name) selected="selected" @endif>{{$country->countries_name}}</option>
                          @endforeach
                        </select>
                        <span class="select-highlight"></span>
                        <span class="select-bar"></span>
                        <small class="label-style">ülke</small>
                        <!-- <label class="select-label">Select Country</label> -->

                      </div>
                      <!--Select with pure css-->
                      
                    </div>
                  </div>
                  <div class="col-md-5 col-md-push-1">
                      <!-- <p>Birth Date : </p>
                        <input type="text" name="dob" value="{{ old('dob') }}" id="dob" class="" placeholder="Birthdate" required> -->
                      <!-- <div class="form-group">
                      <div class="reset-group">
                        <input type="password" id="c_pass" name="c_pass" value="" placeholder="Confirm Password"><span class="highlight"></span><span class="bar"></span>
                        <label class="control-label" for="input">Textfield</label><i class="bar"></i>
                        <label>Birth Date</label>
                      </div>
                        
                    </div> -->
                    <div class="form-group" style="margin-top: 20px">
                      <input type="text" id="phone" style="color: #777" value="{{ old('phone') }}" name="phone" />
                      <label class="control-label" for="input" style="margin-top: 11px">Telefon</label><i class="bar"></i>
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="text" id="dob" style="color: #777;" name="dob" value="{{ old('dob') }}" required="required" />
                      <label class="control-label" for="input" style="">Doğum günü</label><i class="bar"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- <div class="row text-center"> -->
                
                <input type="button" name="next" class="next action-button" value="Submit" id="next"/>
                <!-- </div>   -->
                
                
                
                
                <div class="row">
                    <!-- <div class="col-md-12">
                        <label class="col-form-label text-white" style="text-align :center;">Already have an account? &nbsp;&nbsp;&nbsp;</label> <br>

                        <div style="margin-top: 2%"></div>
                        <a href="/login" style="color: white !important;width: 100px;background: #347dff;padding: 10px 32px;border-radius: 2px;" class="text-primary login_hover my"><b>Log In</b></a>
                        
                      </div> -->
                    </div>
                  </fieldset>
                  
                </form>
              </div>
              <div class="col-md-4 col-md-pull-8 col-sm-4 col-xs-12 ">
                <div class="side-des">
                  <img src="/img/register_page_img_{{app()->getLocale()}}.png" alt="" class="img-responsive center-block" style="max-width: 135px">
                  <h2>{{$general_info_others->open_demo_account_page_header}}</h2>
                  <hr>
                  <h3>{{$general_info_others->open_demo_account_page_subheader}}</h3>
                  <hr>
                  <ul>
                    <li><span class="form-icon"><i class="fas {{$general_info->open_demo_account_page_icon1}}"></i></span>{{$general_info_others->open_demo_account_page_text1}}</li>
                    <li><span class="form-icon"><i class="fas {{$general_info->open_demo_account_page_icon2}}"></i></span>{{$general_info_others->open_demo_account_page_text2}}</li>
                    <li><span class="form-icon"><i class="fas {{$general_info->open_demo_account_page_icon3}}"></i></span>{{$general_info_others->open_demo_account_page_text3}}</li>
                    <li><span class="form-icon"><i class="fas {{$general_info->open_demo_account_page_icon4}}"></i></span>{{$general_info_others->open_demo_account_page_text4}}</li>
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
      <script type="text/javascript" src="/js/bootstrap-select.min.js"></script>
      
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
      
      


      <script>
        $(document).ready(function(){
          
          
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$("#next").click(function(){

  var form = $("#myform");
// jQuery.validator.addMethod('selectcheck', function (value) {
//         return (value != '0');
//     }, "year required");






form.validate({
  rules: {
    

    fname: {
      required: true,
      
    },
    lname: {
      required: true,
      
    },
    passwordField : {
      required: true,
      minlength: 8,
    },
    c_password : {
      required: true,
      equalTo: '#passwordField',
    },
    
    
    phone : {
      required: true,
      min: 0,
      minlength:8,
      maxlength: 20,
    }, 
    
    deposit : {
      required: true,
      min : 1,
      

    },
    
    email: {
      required: true,
    }, 
    agree: {
      required: true,
    }
    
  },
  messages: {
    
    fname: {
      required: "İlk isim gerekli",
    },
    lname: {
      required: "Soyadı gerekli",
    },
    password : {
      required: "Lütfen şifreyi giriniz",
    },

    c_pass: {
      required: "Lütfen yukarıdaki ile aynı şifreyi giriniz"
    },
    email: {
      required: "Lütfen e-mail adresinizi giriniz!"
    },
    deposit: {
      min: "Lütfen geçerli bir miktar girin"
    },

    phone: {
      min: "Geçerli bir telefon numarası girin"
    }
    
    
    
  }
});


if (form.valid()==true) {


  form.submit();
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

   postal_code : {
    required: true,
  },
  
  dob: {
    required: true,
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
    required: "Ülke gerekli",
  },
  
  
  
  
  country_change : {
    valueNotEquals: "Lütfen bir ülke seçin"
  },

  state : {
    required: "Lütfen bir eyalet seçiniz",
  },

  city : {
    required: "Lütfen bir şehir seçiniz",
  },

  postal_code : {
    required: "Lütfen posta kodunu giriniz",
  },


  address : {
    required: "Lütfen adresi giriniz",
  },

  phone : {
    required : "Lütfen geçerli telefon numarası giriniz."
  },

  dob: {
    required: "Lütfen doğum tarihinizi giriniz"
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
      previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
    }, 
    duration: 800, 
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

@endsection