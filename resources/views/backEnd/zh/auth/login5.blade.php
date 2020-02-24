@extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
@section ('title') 登录 @endsection
@section('css-link')
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/login5.css')}}" />
@endsection
@section('main-body')
<section class="main-body">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-6 col-xs-12">
        <form class="clearfix form-login" id="login" method="POST" action="{{LaravelLocalization::localizeURL('/login')}}">
          <h4 class="form-h4">登录</h4>
          @if ($errors->has('msg'))
          <span class="help-block" style="text-align:center; color:red">
            <strong>{{ $errors->first('msg') }}</strong>
          </span>
          <br>
          @endif
          @if (Session::has('password'))
          <span class="help-block">
            <strong style="color: #00BF86;">{{ Session::get('password') }}</strong>
          </span>
          <br>
          @endif
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group">
              <input readonly type="email" id="email" name="email" style="color: #777" required="required" onfocus="if (this.hasAttribute('readonly')) {
                this.removeAttribute('readonly');
                this.blur();    this.focus();  }" />
                <label class="control-label" for="input">电子邮件</label><i class="bar"></i>
                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <input readonly type="password" id="password" name="password" style="color: #777" required="required"
                onfocus="if (this.hasAttribute('readonly')) {
                  this.removeAttribute('readonly');
                  this.blur();    this.focus();  }" />
                  <label class="control-label" for="input">密码</label><i class="bar"></i>
                  @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              <div class="row" style="margin-top: 30px">
                <div class="col-md-6 col-xs-12 col-sm-6 anc-style no-padding">
                  <a href="/reset-password">重置密码</a>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-6 no-padding">
                  <button type="submit" class="mat-form-button">登录</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6 col-xs-12 text-center no-padding">
            <div class="reg-des">
              <p>未注册？</p>
              <small>今天开始交易</small>
              <div>
                <a href="/live-account-register">
                  <button type="" class="mat-form-button1">开设真实账户</button>
                </a>
                <a href="/demo-account-register">
                  <button type="" class="mat-form-button2">开设模拟账户</button>
                </a>
              </div>
              <div class="flex-container">
                <div>
                  <img src="{{asset('img/login_1st_img_'.app()->getLocale().'.png')}}" alt="">
                  <small class="small-font">{{$general_info_others->login_1st_img_text}}</small>
                </div>
                <div>
                  <img src="{{asset('img/login_2nd_img_'.app()->getLocale().'.png')}}" alt="">
                  <small class="small-font">{{$general_info_others->login_2nd_img_text}}</small>
                </div>
                <div>
                  <img src="{{asset('img/login_3rd_img_'.app()->getLocale().'.png')}}" alt="">
                  <small class="small-font">{{$general_info_others->login_3rd_img_text}}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endsection
    @section('js-link')
    <script src="/js/jquery.validate.js"></script>
    <script type="text/javascript">
      $(function () {
        var twoToneButton = document.querySelector('.mat-form-button');
        twoToneButton.addEventListener("click", function () {
          twoToneButton.innerHTML = "登录中";
          twoToneButton.classList.add('spinning');
          setTimeout(
            function () {
              twoToneButton.classList.remove('spinning');
              twoToneButton.innerHTML = "登录";
            }, 2000);
        }, false);
      });
    </script>
    <script type="text/javascript" src="{{asset('js/pages/login5.js')}}"></script>
    <script type="text/javascript">
      $(document).ready(function ($) {
        var Body = $('body');
        Body.addClass('preloader-site');
      });
      $(window).load(function () {
        $('.preloader-wrapper').fadeOut();
        $('body').removeClass('preloader-site');
      });
    </script>
    <script>
      $(function () {
        $("#login").bootstrapValidator({
          feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            email: {
              validators: {
                notEmpty: {
                  message: '电子邮件地址是必填项，不能为空'
                },
                emailAddress: {
                  message: '电子邮件地址无效'
                }
              }
            },
            password: {
              validators: {
                notEmpty: {
                  message: '密码是必需的，不能为空'
                },
              }
            },
          }
        });
      });
    </script>
    @endsection