@extends('backEnd.'.app()->getLocale().'.auth.signin-layout')
 @section ('title')
  Passwort zurücksetzen
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
            <h4 class="form-reset-h4">Passwort zurücksetzen</h4>
            <small>Um Ihr Passwort zurückzusetzen, geben Sie bitte Ihre E-Mail-Adresse an.</small>
            <div class="form-group">
              <!-- <div class="reset-group">
                <input type="email" name="email"><span class="highlight"></span><span class="bar"></span>
                <label>Email</label>
              </div> -->
              <div class="form-group">
                        <input type="email" id="email" name="email" style="color: #777" required="required" />
                        <label class="control-label" for="input">Email</label><i class="bar"></i>
                      </div>
              
            </div>
              <div class="col-md-6 col-xs-12 no-padding">
                <button type="submit" class="reset-mat-form-button">Weiter</button>
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
                        message: 'Die E-Mail-Adresse ist erforderlich und darf nicht leer sein'
                    },
                    emailAddress: {
                        message: 'Die E-Mail-Adresse ist nicht gültig'
                    }
                }
            },
           
        }
        

  });

      });
    </script>

    @endsection
    
  