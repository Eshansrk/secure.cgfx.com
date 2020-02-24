
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Change MT4 Password')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link href="/css/passwordRulesHelper.min.css" rel="stylesheet" />
<style type="text/css">
div.rules-list{
    width: 100%
}
</style>
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-compass"></i>
                        Change MT4 Password
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card">

                <div class="card-block m-t-35">
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <div class="show-transfer">
                                <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                                <a href="#">Show me how</a>
                                <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                            </div>
                            <div class="show-transfer-hide">
                                <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                <span>How to Open Account</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="up-barcurb">
                                <li class="first-li selected"> 1. Change Your Password</li>
                                <li class="second-li"> 2. Confirm Code </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card select-account" style="height: auto">
                                <div class="select-account-body">
                                    <h4>Change MT4 Password</h4>

                                </div>
                                        <!-- <div class="select-account-button">
                                            <a href="/open-trading-account"><button>Select</button></a>
                                        </div> -->
                                        @if(Session::has('error'))
                                        <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('error')}}</h3>
                                        </div>
                                        <!-- <h4 style="color:red;">{{$errors->first()}}</h4> -->
                                        @endif
                                        {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/change-mt4-password'), 'id' => 'withdrawForm','class'=>'col-md-12 form form-horizontal']) !!}

                                        <div class="form-group">
                                            <div class="span3 " style="margin-top: 5px;"><label class="control-label">Select Account:</label></div>
                                            <div class="span4 form-group">
                                                <select name="account_no" class="form-control" id="account_no" >
                                                    <option value="" disabled="disabled" selected="selected">Select Account</option>
                                                    @foreach($accounts as $account)
                                                    <option value="{{$account->account_no}}" @if(old('account_no')==$account->account_no) selected="selected" @elseif($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="span4"></div>
                                        </div>

                                    <!-- <div class="form-group ">
                                        <div class="span4 "><label class="control-label">New Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('pass_error'))
                                    <span style="color:red;">{{Session::get('pass_error')}}</span>
                                    @endif
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                      <label for="password">Password:</label>
                                      <input type='password' name='password' id='passwordField' class='form-control' autocomplete='new-password' style=""/>
                                      <span class ='message' style="font-size: 11px"></span>
                                  </div>

                                    <!-- <div class="form-group ">
                                        <div class="span4 "><label class="control-label">Confirm New Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="cpassword" class="form-control" id="cpassword" value="{{old('cpassword')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('cpass_error'))
                                    <span style="color:red;">{{Session::get('cpass_error')}}</span>
                                    @endif
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password:</label>
                                        <input type="password" name="c_password"
                                        id="c_password" 
                                        maxlength="20" class="form-control" style="">
                                        <span id='message'></span>
                                    </div> 

                                    <br> 
                                    <div class="control-group">
                                       <div class="span4"></div>
                                       <div class="span4 form-group">
                                           <input type="submit" id="submit" class="btn btn-primary" value="Change" name="submit"> 
                                           <!--<button type="submit" class="btn">Continue</button>-->

                                       </div> 
                                   </div>

                                   {!!Form::close()!!}

                               </div>
                           </div>
                           <div class="col-md-6">
                            <div class="card select-account" style="height: auto">
                                <div class="select-account-body">
                                    <h4>Change Investor Password</h4>

                                </div>
                                        <!-- <div class="select-account-button">
                                            <a href="/open-demo-account"><button>Select</button></a>
                                        </div> -->
                                        @if(Session::has('investor_error'))
                                        <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('error')}}</h3>
                                        </div>
                                        <!-- <h4 style="color:red;">{{$errors->first()}}</h4> -->
                                        @endif
                                        {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/change-mt4-investor-password'), 'name' => 'withdrawForm','class'=>'col-md-12 form form-horizontal','style'=>'','id'=>'form_id1']) !!}

                                        <div class="form-group">
                                            <div class="span3 " style="margin-top: 5px;"><label class="control-label">Select Account:</label></div>
                                            <div class="span4 form-group">
                                                <select name="account_no" class="form-control" id="account_no1" >
                                                    <option value="" disabled="disabled" selected="selected">Select Account</option>
                                                    @foreach($accounts as $account)
                                                    <option value="{{$account->account_no}}" @if(old('account_no')==$account->account_no) selected="selected"@endif>{{$account->account_no}} ({{$account->act_type}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="span4"></div>
                                        </div>

                                    <!-- <div class="form-group ">
                                        <div class="span4 "><label class="control-label">New Investor Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="investor_password" class="form-control" id="investor_password" value="{{old('investor_password')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('investor_pass_error'))
                                    <span style="color:red;">{{Session::get('investor_pass_error')}}</span>
                                    @endif
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                      <label for="investor_password">Password:</label>
                                      <input type='password' name='investor_password' id='passwordField1' class='form-control' autocomplete='new-password'  style=""/>
                                      <span class ='message1'></span>
                                  </div>

                                    <!-- <div class="form-group">
                                        <div class="span4 "><label class="control-label">Confirm New Investor Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="cinvestor_password" class="form-control" id="cinvestor_password" value="{{old('cinvestor_password')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('cinvestor_pass_error'))
                                    <span style="color:red;">{{Session::get('cinvestor_pass_error')}}</span>
                                    @endif
                                        </div>
                                    </div> -->

                                    <div class="form-group">
                                        <label for="cinvestor_password">Confirm Password:</label>
                                        <input type="password" name="cinvestor_password"
                                        id="c_password1" 
                                        maxlength="20" class="form-control" style="">
                                        <span id='message1'></span>
                                    </div> 

                                    <br> 
                                    <div class="control-group">
                                       <div class="span4"></div>
                                       <div class="span4 form-group">
                                           <input type="submit" id="submit1" class="btn btn-primary" value="Change" name="submit1"> 
                                           <!--<button type="submit" class="btn">Continue</button>-->

                                       </div> 
                                   </div>

                                   {!!Form::close()!!}
                               </div>
                           </div>
                       </div>




                   </div>
                   <!-- /.inner -->
               </div>


               <!--top section widgets-->
           <!-- <div class="card ">
                   
                    <div class="card-block">
                        <div class="table-responsive">
                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a href="#tab_2" class="nav-link pass-nav" data-toggle="tab">Password</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tab_3" class="nav-link inv-pass-nav" data-toggle="tab">Investor Password</a>
                                                </li>
                                                
                                            </ul>
                                            <br>
                                            <div class="tab-content">
                                                <div class="tab-pane gallery-padding" id="tab_2">
                                                   

                             @if($errors->any())
                             <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{$errors->first()}}</h3>
                             </div>
                           <h4 style="color:red;">{{$errors->first()}}</h4> 
                            @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => '/change-mt4-password', 'name' => 'withdrawForm','class'=>'col-md-4 form form-horizontal']) !!}

                                    <div class="control-group">
                                        <div class="span3 form-group" style="margin-top: 5px;"><label class="control-label">Select Account:</label></div>
                                        <div class="span4 form-group">
                                            <select name="account_no" class="form-control" id="account_no" required="required">
                                            <option value="" disabled="disabled" selected="selected">Select Account</option>
                                               @foreach($accounts as $account)
                                                    <option value="{{$account->account_no}}" @if(old('account_no')==$account->account_no) selected="selected"@endif>{{$account->account_no}} ({{$account->act_type}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                    
                                    <div class="control-group ">
                                        <div class="span4 form-group"><label class="control-label">New Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('pass_error'))
                                    <span style="color:red;">{{Session::get('pass_error')}}</span>
                                    @endif
                                        </div>
                                    </div>

                                    <div class="control-group ">
                                        <div class="span4 form-group"><label class="control-label">Confirm New Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="cpassword" class="form-control" id="cpassword" value="{{old('cpassword')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('cpass_error'))
                                    <span style="color:red;">{{Session::get('cpass_error')}}</span>
                                    @endif
                                        </div>
                                    </div>

                                    <br> 
                                  <div class="control-group">
                                     <div class="span4"></div>
                                     <div class="span4 form-group">
                                     <input type="submit" id="submit" class="btn btn-primary" value="Change" name="submit"> 
                                      <button type="submit" class="btn">Continue</button>
                                     
                                     </div> 
                                  </div>

                               {!!Form::close()!!}
                                                </div>
                                                
    

        <div class="tab-pane gallery-padding" id="tab_3">
                                                    

                             @if($errors->any())
                             <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{$errors->first()}}</h3>
                             </div>
                             <h4 style="color:red;">{{$errors->first()}}</h4> 
                            @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => '/change-mt4-investor-password', 'name' => 'withdrawForm','class'=>'col-md-4 form form-horizontal']) !!}

                                    <div class="control-group">
                                        <div class="span3 form-group" style="margin-top: 5px;"><label class="control-label">Select Account:</label></div>
                                        <div class="span4 form-group">
                                            <select name="account_no" class="form-control" id="account_no" required="required">
                                            <option value="" disabled="disabled" selected="selected">Select Account</option>
                                               @foreach($accounts as $account)
                                                    <option value="{{$account->account_no}}" @if(old('account_no')==$account->account_no) selected="selected"@endif>{{$account->account_no}} ({{$account->act_type}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                    
                                    <div class="control-group ">
                                        <div class="span4 form-group"><label class="control-label">New Investor Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="investor_password" class="form-control" id="investor_password" value="{{old('investor_password')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('investor_pass_error'))
                                    <span style="color:red;">{{Session::get('investor_pass_error')}}</span>
                                    @endif
                                        </div>
                                    </div>

                                    <div class="control-group ">
                                        <div class="span4 form-group"><label class="control-label">Confirm New Investor Password:</label></div>
                                        <div class="span4 form-group">
                                            <input type="password" name="cinvestor_password" class="form-control" id="cinvestor_password" value="{{old('cinvestor_password')}}" required="required">
                                        </div>
                                        <div class="span4">
                                            @if(Session::has('cinvestor_pass_error'))
                                    <span style="color:red;">{{Session::get('cinvestor_pass_error')}}</span>
                                    @endif
                                        </div>
                                    </div>

                                    <br> 
                                  <div class="control-group">
                                     <div class="span4"></div>
                                     <div class="span4 form-group">
                                     <input type="submit" id="submit" class="btn btn-primary" value="Change" name="submit"> 
                                      <button type="submit" class="btn">Continue</button>
                                     
                                     </div> 
                                  </div>

                               {!!Form::close()!!}
                                                </div>

        
        




                                            </div>
                                          
                                        </div>
                            
                        </div>
                    </div>
                </div>  -->






            </div>
            <!-- /.inner -->
        </div>
    </div>
</div>
</div>





@endsection

@section('page-level-js')
<script src="/js/passwordRulesHelper.min.js"></script>
<script src="/js/passwordRulesHelper1.min.js"></script>
<script type="text/javascript">
    $(function(){
        var form = $('#withdrawForm');
        var form1 = $('#form_id1');

        form.validate({
            rules : {
                account_no : {
                    required: true,
                },
                password : {
                    required: true,
                },
                c_password : {
                    required: true,
                },
            },
            messages : {
                account_no : {
                    required: "Please select account",
                },
                password : {
                    required: "Password is required",
                },
                c_password : {
                    required: "Conform your password",
                },
            }
        });
        form1.validate({
            rules : {
                account_no : {
                    required: true,
                },
                investor_password : {
                    required: true,
                },
                cinvestor_password : {
                    required: true,
                },
            },
            messages : {
                account_no : {
                    required: "Please select account",
                },
                investor_password : {
                    required: "Password is required",
                },
                cinvestor_password : {
                    required: "Conform your password",
                },
            }
        });


         @if( Session::has('investor_pass_error') || Session::has('cinvestor_pass_error'))
            $('.inv-pass-nav').addClass('active');
            $('#tab_3').addClass('active'); 
            @else
            $('.pass-nav').addClass('active');
            $('#tab_2').addClass('active'); 
            @endif
            //how to transfer section
            $('.show-transfer-hide').hide();
            $('.up').hide();
            $('.show-transfer').click(function(){
                $(this).toggleClass('green');
                $('.down').toggle('2000');
                $('.show-transfer-hide').toggle('2000');
                $('.up').toggle();
            });

//1st form

$('#passwordField').passwordRulesValidator();
$('.rules').hide();
$('#passwordField, #c_password').on('keyup', function () {
    $('.rules').show();
  if ($('#passwordField').val() == $('#c_password').val()) {
    $('#message').html('Password Matched').css('color', 'green');
} else 
$('#message').html('').css('color', 'red');

if($('#passwordField').val() ==0 && $('#c_password').val()==0){
    $('#message').html('').css('color', 'green');
}
});

$('#form_id').on('submit', function(e){
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
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag2 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag3 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag4 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag5 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
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
      });


              //2nd form

              $('#passwordField1').passwordRulesValidator1();
              $('.rules-list1').hide();

              $('#passwordField1, #c_password1').on('keyup', function () {
                $('.rules-list1').show();
                  if ($('#passwordField1').val() == $('#c_password1').val()) {
                    $('#message1').html('Password Matched').css('color', 'green');
                } else 
                $('#message1').html('').css('color', 'red');

                if($('#passwordField1').val() ==0 && $('#c_password1').val()==0){
                    $('#message1').html('').css('color', 'green');
                }
            });

              $('#form_id1').on('submit', function(e){
                  var o_pass = $('#passwordField1').val();
                  var s_pass = $('#c_password1').val();
                  if ( o_pass!= s_pass) {

                    $('#message1').html('Password doesn\'t match').css('color', 'red');
                    e.preventDefault();
                }
                else{
                    var flag1 = checkMatchedPass(o_pass).a;
                    var flag2 = checkMatchedPass(o_pass).b;
                    var flag3 = checkMatchedPass(o_pass).c;
                    var flag4 = checkMatchedPass(o_pass).d;
                    var flag5 = checkMatchedPass(o_pass).e;

                    if (flag1 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag2 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag3 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag4 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }
              if (flag5 == 0) {
                  // $('.message').html('Check Condition').css('color', 'red');
                  e.preventDefault();
              }


              //   if (flag1 == 0 && flag2 == 0 && flag3 == 0 && flag4 == 0 && flag5 == 0) {$('#message').html('Minimum one upperccase, one lowercase, 8 characters, 1 digit, 1 special characters are required').css('color', 'red');e.preventDefault();}
              //  else if (flag1 == 0 && flag2 == 0 && flag3 == 0 && flag4 == 0) {$('#message').html('Minimum one upperccase, one lowercase, 8 characters and 1 digit required').css('color', 'red');e.preventDefault();}
              //  else if (flag1 == 0 && flag2 == 0 && flag3 == 0) {$('#message').html('Minimum one upperccase, one lowercase, 8 characters  required').css('color', 'red');e.preventDefault();}
              //   else if (flag1 == 0 && flag2 == 0) {$('#message').html('Minimum one upperccase, one lowercase required').css('color', 'red');e.preventDefault();}
              //  else if (flag1 == 0 && flag3 == 0) {$('#message').html('Minimum one upperccase and 8 characters required').css('color', 'red');e.preventDefault();}
              //   else if (flag2 == 0 && flag3 == 0) {$('#message').html('Minimum one lowercase and 8 characters required').css('color', 'red');e.preventDefault();}
              // else if (flag1 == 0) {$('#message').html('Minimum one uppercase is required').css('color', 'red');e.preventDefault();}
              //  else if (flag2 == 0) {$('#message').html('Minimum one lowercase is required').css('color', 'red');e.preventDefault();}
              //  else if (flag3 == 0) {$('#message').html('Minimum eight characters are required').css('color', 'red');e.preventDefault();}
              
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
      });

              

          });

      </script>
      @endsection
