 @extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
 @section ('title')
  {{Session::get('success_title')}}
@endsection
@section('css-link')
  <link type="text/css" rel="stylesheet" href="{{asset('css/pages/login5.css')}}"/>
  <style type="text/css">
    body{
      background-color:#F5F7F8;
    }
  </style>
@endsection

@section('main-body')
    

    <section class="success-main-body">
       <div id="overlay">
         <div class="container">
           <div class="row text-center">
             <div class="col-md-6 col-md-push-6">
               <p class="success-heading"><br>{{Session::get('success_title')}}</p>
               <!-- <p class="success-subheading">
                 A verification email has been sent to your mail. Please check and confirm your email to receive login details.</p> -->
                 <p class="success-subheading">
                 {{Session::get('success_register')}}</p>
                 <div class="row" style="margin-top: 5%">
                  <div class="col-sm-4 col-xs-4 success-app">
                    <a href="{{$download_link}}" target="_blank"> <img src="/img/windows.png" alt=" Download MT4" style="max-width:94%; height:auto"></a>
                  </div>

                  <div class="col-sm-4 col-xs-4 success-app">
                    <a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><img src="/img/app-store-btn.svg" alt="Download MT4 from Appstore" style="max-width:100%; height:auto">
                    </a>
                  </div>
                  <div class="col-sm-4 col-xs-4 success-app">
                    <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4&hl=en&utm_campaign=www.metatrader4.com" target="_blank"><img src="/img/google-play-btn.svg" alt=" MT4 For Android" style="max-width:100%; height:auto"></a>

                  </div>
                </div>
             </div>
           </div>
         </div>
         
       </div> 
    </section>

  @endsection

  @section('js-link')

    
  
    <!-- <script>
        $(document).on('submit','form.form-login',function(){
        $('.mat-form-button').hide();
        $('.form-button-logging').show();
      });
    </script> -->
    
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
    
@endsection