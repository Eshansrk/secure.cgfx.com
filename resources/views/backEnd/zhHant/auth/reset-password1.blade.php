@extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
 @section ('title')
  重設密碼
@endsection

@section('css-link')
    <!-- main css file -->
    <link type="text/css" rel="stylesheet" href="{{asset('css/pages/login5.css')}}"/>
    <style type="text/css">
      .bar{
            border-bottom: 0.099rem solid #ddd !important;
      }
    </style>

@endsection
 
  
 <!--  <div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{asset('img/loader.gif')}}" alt="loading..." style="max-width: 200px">
    </div>
  </div>
    <section class="main-header">
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
                <p>Open Account!<span><a href="/login">Sign Up</a></span></p>
                
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
          <div class="col-md-12 col-xs-12">
            <form class="reset-form clearfix" id="reset" method="POST" action="{{LaravelLocalization::localizeURL('/reset-password')}}">
              @if ($errors->has('msg'))
        
            <span class="help-block" style="text-align:center; color:red">
                <strong>{{ $errors->first('msg') }}</strong>
            </span>
        
        @endif

        @if (Session::has('notExist'))
                                <span class="help-block">
                                    <strong style="color: #f00;">{{ Session::get('notExist') }}</strong>
                                </span>
                                @endif 

        @if (Session::has('link'))
                                <span class="help-block">
                                    <strong style="color: #00BF86;">{{ Session::get('link') }}</strong>
                                </span>
                                @endif

        {{ csrf_field() }}
            <h4 class="form-reset-h4">重設密碼</h4>
            <small>要重置密碼，請向我們提供您的電子郵件地址。</small>
            <div class="form-group">
              <!-- <div class="reset-group">
                <input type="email" name="email"><span class="highlight"></span><span class="bar"></span>
                <label>Email</label>
              </div> -->
              <div class="form-group">
                        <input type="email" id="email" name="email" style="color: #777" required="required" />
                        <label class="control-label" for="input">電子電子郵箱</label><i class="bar"></i>
                      </div>
              
            </div>
              <div class="col-md-6 col-xs-12 no-padding">
                <button type="submit" class="reset-mat-form-button">提交表格</button>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </section>

    @endsection



   @section('js-link')
    <script type="text/javascript" src="{{asset('js/pages/login5.js')}}"></script>
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
    <script>
      $(function(){

        $("#reset").bootstrapValidator({
    feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields : {
          email: {
                validators: {
                    notEmpty: {
                        message: '電子郵件地址是必填項，不能為空'
                    },
                    emailAddress: {
                        message: '電子郵件地址無效'
                    }
                }
            },
           
        }
        

  });

      });
    </script>

    @endsection
    
  