@extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
@section ('title')
寄存器
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
@section('main-body')
<section class="main-body">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12 col-xs-12  form-div-height">
        <div class="col-md-8 col-md-push-5 col-xs-12  col-sm-8 text-center">
          <form id="myform" method="post" action="{{LaravelLocalization::localizeURL('/register')}}">
            {{csrf_field()}}
            @if ($ref_id)
            <input type="hidden" name="referred_by" value="{{$ref_id}}">
            @endif
            <fieldset id="x">
              <h2 class="fs-title">寄存器</h2>
              <hr>
              <div class="row">
                @if (Session::has('register'))
                <span class="help-block">
                  <strong style="color: #00bf86 ;float: left;">{{ Session::get('register') }}</strong>
                </span>
                @endif  
                <div class="row">
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="text" id="fname" name="fname" style="color: #777" value="{{ old('fname') }}"  required="required" />
                      <label class="control-label" for="input">名字</label><i class="bar"></i>
                    </div>
                  </div>
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="text" id="lname" name="lname" style="color: #777" value="{{ old('lname') }}" required="required" />
                      <label class="control-label" for="input">姓</label><i class="bar"></i>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-10 col-md-push-1">
                    <div class="form-group">
                      <input type="email" id="email" name="email" style="color: #777" value="{{ old('email') }}" required="required" />
                      <label class="control-label" for="input">电子邮件</label><i class="bar"></i>
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
                      <label class="control-label" for="input">密码</label><i class="bar"></i>
                    </div>
                  </div>
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="password" name="c_password" id="c_password" required="required"
                      class="" style="">
                      <label class="control-label" for="input" style="">确认密码</label><i class="bar"></i>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 col-md-push-1">
                    <div class="wrap">
                      <div class="select">
                        <select class="select-text" id="country" name="country" style="color: #777" required>
                          <option code="" selected="selected" disabled="disabled" style="color: #777">选择国家</option>
                          @foreach($countries as $country)
                          <option value="{{$country->countries_name}}" id="{{$country->countries_id}}" code="+{{$country->countries_isd_code}}" @if($selected_country == $country->countries_name) selected="selected" @endif>{{$country->countries_name}}</option>
                          @endforeach
                        </select>
                        <span class="select-highlight"></span>
                        <span class="select-bar"></span>
                        <small class="label-style">国家</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group" style="margin-top: 20px">
                      <input type="text" id="phone" style="color: #777" value="{{ old('phone') }}" name="phone" />
                      <label class="control-label" for="input" style="margin-top: 11px">电话</label><i class="bar"></i>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 col-md-push-1">
                    <div class="form-group">
                      <input type="text" id="dob" style="color: #777;" name="dob" value="{{ old('dob') }}" required="required" />
                      <label class="control-label" for="input" style="">生日</label><i class="bar"></i>
                    </div>
                  </div>
                </div>
              </div>
              <input type="button" name="next" class="next action-button" value="提交" id="next"/>
              <div class="row">
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
              <li><span class="form-icon"><i class="fa {{$general_info->open_demo_account_page_icon1}}"></i></span>{{$general_info_others->open_demo_account_page_text1}}</li>
              <li><span class="form-icon"><i class="fa {{$general_info->open_demo_account_page_icon2}}"></i></span>{{$general_info_others->open_demo_account_page_text2}}</li>
              <li><span class="form-icon"><i class="fa {{$general_info->open_demo_account_page_icon3}}"></i></span>{{$general_info_others->open_demo_account_page_text3}}</li>
              <li><span class="form-icon"><i class="fa {{$general_info->open_demo_account_page_icon4}}"></i></span>{{$general_info_others->open_demo_account_page_text4}}</li>
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
    var current_fs, next_fs, previous_fs; 
    var left, opacity, scale; 
    var animating; 
    $("#next").click(function(){
      var form = $("#myform");
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
            required: "名字是必需的",
          },
          lname: {
            required: "姓氏是必需的",
          },
          password : {
            required: "请输入密码",
          },
          c_pass: {
            required: "请输入与上面相同的密码"
          },
          email: {
            required: "请输入您的电子邮件地址！"
          },
          deposit: {
            min: "请输入有效金额"
          },
          phone: {
            min: "输入有效的电话号码"
          }
        }
      });
      if (form.valid()==true) {
        form.submit();
      }
    });
    $("#next1").click(function(){
      var form = $("#myform");
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
          required: "需要国家",
        },
        country_change : {
          valueNotEquals: "请选择一个国家"
        },
        state : {
          required: "请选择一个州",
        },
        city : {
          required: "请选择一个城市",
        },
        postal_code : {
          required: "请输入邮政编码",
        },
        address : {
          required: "请输入地址",
        },
        phone : {
          required : "请输入有效的电话号码"
        },
        dob: {
          required: "请输入你的生日"
        },
      }
    });
      if (form.valid()==true) {
        if(animating) return false;
        animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show(); 
        current_fs.animate({opacity: 0}, {
          step: function(now, mx) {
            scale = 1 - (1 - now) * 0.2;
            left = (now * 50)+"%";
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
          easing: 'easeInOutBack'
        });
      }
    });
    $("#next2").click(function(){
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
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        next_fs.show(); 
        current_fs.animate({opacity: 0}, {
          step: function(now, mx) {
            scale = 1 - (1 - now) * 0.2;
            left = (now * 50)+"%";
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
          easing: 'easeInOutBack'
        });
      }
    });
    $(".previous").click(function(){
      if(animating) return false;
      animating = true;
      current_fs = $(this).parent();
      previous_fs = $(this).parent().prev();
      $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
      previous_fs.show(); 
      current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
          scale = 0.8 + (1 - now) * 0.2;
          left = ((1-now) * 50)+"%";
          opacity = 1 - now;
          current_fs.css({'left': left});
          previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        }, 
        duration: 800, 
        complete: function(){
          current_fs.hide();
          animating = false;
        }, 
        easing: 'easeInOutBack'
      });
    });
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