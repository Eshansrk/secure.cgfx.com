<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" type="image/x-icon" />
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>@yield('title')</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  <!-- font-awesome -->
  <link href="/fontawesome-5/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
  <link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
  <!-- <link rel="stylesheet" type="text/css" href="/css/bootstrap-select.min.css"> -->
  <link rel="stylesheet" type="text/css" href="/css/flag-icon.min.css">
  <link type="text/css" rel="stylesheet" href="{{asset('css/signin-color.css')}}"/>
  <link type="text/css" rel="stylesheet" href="{{asset('css/pages/login.css')}}"/>
  <!-- main css file -->
  @yield('css-link')
</head>
<body style="background-color:#F5F7F8;">
  <div class="preloader-wrapper">
    <div class="preloader">
      <img src="{{asset('img/loader.gif')}}" alt="loading..." style="max-width: 200px">
    </div>
  </div>
  <section class="main-header">
    <div class="container">
      <div class="row">
        <div class="logo-flex clearfix">
          <div class="col-xs-6 column">
            <div class="header-img clearfix">
              <a href="/"><img src="/img/logo.png" alt="logo" style="width:{{$general_info->logo_width}};height:{{$general_info->logo_height}}"></a>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="text-center header-right-content column">
              <?php if (Request::is('login') || Request::is(app()->getLocale().'/login')): ?>
              <div class="button-sign" style="width: 150px">
                <p>開戶!<span><a href="/register">註冊</a></span></p>
              </div>
              <?php endif ?>
              <?php if (Request::is('live-account-register') || Request::is(app()->getLocale().'/live-account-register')): ?>
              <div class="button-sign" style="width: 150px">
                <p>Have an Account!<span><a href="/login">Sign In</a></span></p>
              </div>
              <?php endif ?>
              <?php if (Request::is('demo-account-register') || Request::is(app()->getLocale().'/demo-account-register')): ?>
              <div class="button-sign" style="width: 150px">
                <p>創建賬戶!<span><a href="/login">登錄</a></span></p>
              </div>
              <?php endif ?>
              <?php if (Request::is('reset-password') || Request::is(app()->getLocale().'/reset-password')): ?>
              <div class="button-sign" style="width: 150px">
                <p>創建賬戶!<span><a href="/login">登錄</a></span></p>
              </div>
              <?php endif ?>
              <?php if (Request::is('register') || Request::is(app()->getLocale().'/register')): ?>
              <div class="button-sign" style="width: 150px">
                <p>創建賬戶!<span><a href="/login">登錄</a></span></p>
              </div>
              <?php endif ?>
              <!-- fetching all the available language -->
              <div class="show-language-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if (LaravelLocalization::getCurrentLocale() == $localeCode)
                <a href="#">
                  @if($localeCode=='en')
                  <span class="flag-icon flag-icon-us"></span> {{ $properties['native'] }}
                  <span class="caret"></span>
                  @elseif($localeCode=='zh')
                  <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                  <span class="caret"></span>

                  @elseif($localeCode=='zhHant')
                  <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                  <span class="caret"></span>
                  @else
                  <span class="flag-icon flag-icon-{{$localeCode}}"></span> {{ $properties['native'] }} <span class="caret"></span>
                  @endif
                </a>
                @endif
                @endforeach  
                <ul class="menu-language">
                  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                  <li>
                    @if (LaravelLocalization::getCurrentLocale() != $localeCode)
                    
                      <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                        @if($localeCode=='en')
                        <span class="flag-icon flag-icon-us"></span> {{ $properties['native'] }} 
                        @elseif($localeCode=='zh')
                        <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}

                         @elseif($localeCode=='zhHant')
                        <span class="flag-icon flag-icon-cn"></span> {{ $properties['native'] }}
                        @else 
                        <span class="flag-icon flag-icon-{{$localeCode}}"></span> {{ $properties['native'] }} 
                        @endif
                        @endif
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                <!-- end of available language -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @yield('main-body')
    <!--  -->
    <section class="form-footer">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 social-links">
            <a href="{{$general_info->facebook_link}}"><i class="fa fa-facebook"></i></a>
            <a href="{{$general_info->google_plus_link}}"><i class="fa fa-google-plus"></i></a>
            <a href="{{$general_info->twitter_link}}"><i class="fa fa-twitter"></i></a>
            <a href="{{$general_info->youtube_link}}"><i class="fa fa-youtube"></i></a>
            <a href="{{$general_info->linked_in_link}}"><i class="fa fa-linkedin"></i></a>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 company-link">
            <ul class="footer_menu">
              <li><a href="{{$general_info->footer_link1_link}}" target="" class="terms_conditions">{{$general_info_others->footer_link1_text}}</a></li>
              <li><a href="{{$general_info->footer_link2_link}}" target="" class="security_of_funds">{{$general_info_others->footer_link2_text}}</a></li>
              <li><a href="{{$general_info->footer_link3_link}}" target="" class="legal_forms">{{$general_info_others->footer_link3_text}}</a></li>
              <li><a href="{{$general_info->footer_link4_link}}" target="">{{$general_info_others->footer_link4_text}}</a></li>
              <li><a href="{{$general_info->footer_link5_link}}" target="" class="privacy_policy">{{$general_info_others->footer_link5_text}}</a></li>
            </ul>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 ">
            <br> 
            <p><b>{{$general_info_others->risk_warning_title}} : </b>{!!$general_info_others->risk_warning_text!!}</p>
            <br>
            <p><b>{{$general_info_others->legal_information_title}} : </b>{!!$general_info_others->legal_information_text!!}</p>
            <br><br>
            <p>{{$general_info_others->copyright_text}}</p>
          </div>
        </div>
      </div>
    </section>
    <!-- jQuery (necessary for Bootstrap JavaScript plugins) -->
    <script src="/js/jquery.min.js"></script> 
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
    <!-- <script type="text/javascript" src="/js/bootstrap-select.min.js"></script> -->
    
    @yield('js-link')
    <script type="text/javascript">
      $(function(){
        $('.preloader').fadeOut();
      });
    </script>
  </body>
  </html>