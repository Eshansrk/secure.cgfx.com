
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '開設交易帳戶')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link href="/css/passwordRulesHelper.min.css" rel="stylesheet" />
@endsection
@section('content')

<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar">
      <div class="row no-gutters">
        <div class="col-6">
          <h4 class="m-t-5">
            <i class="fa fa-globe"></i>
           開設交易帳戶
          </h4>
        </div>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner bg-container">


      <!--top section widgets-->
      <div class="card">
        <div class="card-block">
          {{--  <div class="row">
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
          </div>  --}}
          <div class="row">
            <div class="col-md-12">
              <ul class="up-barcurb">
                <li class="first-li "> 1. 選擇您的帳戶類型</li>
                <li class="second-li selected"> 2. 自定義您的交易賬戶 </li>
              </ul>
            </div>
          </div>
                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="card select-account">
                                        <div class="select-account-body">
                                            <h4>Live Trading Account</h4>
                                            <p>Enter the market and start trading in minutes. Open an account that’s tailored to your needs.</p>
                                        </div>
                                        <div class="select-account-button">
                                            <a href="/open-trading-account"><button>Select</button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card select-account">
                                        <div class="select-account-body">
                                            <h4>Open Demo Account</h4>
                                            <p>Enter the market and start trading in minutes. Open an account that’s tailored to your needs.</p>
                                        </div>
                                        <div class="select-account-button">
                                            <a href="/open-demo-account"><button>Select</button></a>
                                        </div>
                                    </div>
                                </div>
                              </div> -->




                            </div>

                            <div class="row-fluid trade">
                              <div class="span12 grey_bg">
                                <div class="padding15">
                                  <div class="form-part">
                                    <div class="row-fluid">
                                     @if(Session::has('msg'))
                                     <div class="col-md-12">
                                      <div class="alert alert-success"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('msg')}}</h3>
                                      </div>
                                    </div>
                                    @endif
                                    @if(Session::has('error'))
                                    <div class="col-md-12">
                                     <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('error')}}</h3>
                                     </div>

                                   </div>
                                   @endif
                                   @if(Session::has('max_allowance_error'))
                                   <div class="col-md-12">
                                    <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('max_allowance_error')}}</h3>
                                    </div>
                                  </div>
                                  @endif
                                  {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/open-trading-account'), 'name' => 'withdrawForm','id' => 'withdrawForm','class'=>'col-md-7 form form-horizontal']) !!}

                                  <div class="form-group">
                                    <div class="span3"><label class="control-label">我想要開戶:</label></div>
                                    <div class="span4 form-group">
                                      <select name="account_type" class="form-control" id="account_type" required="required" style="width: 60%">
                                        <option value="">選擇帳戶類型</option>
                                        @foreach($cms_account as $cat)
                                        <option value="{{$cat->mt4_ac_type}}">{{$cat->account_type}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="span4"></div>
                                  </div>
                                  <div class="form-group">
                                    <div class="span4"><label class="control-label">槓桿:</label></div>
                                    <div class="span4 form-group">
                                      <select name="leverage" class="form-control" id="leverage" required="required" style="width: 60%">
                                        <option value="">選擇槓桿</option>

                                        @foreach($leverage as $lev)

                                        <option value="{{$lev->leverage}}">{{$lev->leverage}}:1</option>

                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="span4"></div>
                                  </div>
                                  <div class="form-group">
                                    <div class="span8"><label class="control-label">匯率:</label></div>

                                    <input class="form-control" type="text" disabled="disabled" value="USD" id="currency" style="width: 60%">   
                                    
                                    <div class="span4"></div>
                                  </div>
                                    <!-- <div class="control-group">
                                        <div class="span4"><label class="control-label">Create a Phone Password:</label></div>
                                        <div class="span5">
                                          <input type="password" name="password" id="Password" placeholder="Password">
                                        </div>
                                        <div class="span3"></div>
                                      </div> -->
                                      <br> 
                                      <!-- <div class="control-group"> -->
                                       <!-- <div class="span4"></div> -->
                                       <div class="form-group">
                                        <label for="password">密碼:</label>
                                        <input type='password' name='password' id='passwordField' class='form-control' autocomplete='new-password' required="required" style="width: 60%"/>
                                        <span class ='message'></span>
                                      </div>
                                      <div class="form-group">
                                        <label for="c_password">確認 密碼:</label>
                                        <input type="password" name="c_password"
                                        id="c_password" required="required"
                                        maxlength="20" class="form-control" style="width: 60%">
                                        <span id='message'></span>
                                      </div> 
                                      <div class="span4 form-group">
                                       <input type="submit" id="submit" class="btn btn-primary" value="開戶" name="submit"> 
                                       <a href="/open-new-account" style="margin-left: 10px">上一步</a>
                                       <!--<button type="submit" class="btn">Continue</button>-->

                                     </div> 
                                     <!-- </div> -->

                                     {!!Form::close()!!}
                                     <div class="col-md-5">
                                      <div class="">
                                        <div class="">
                                          <h5>總計</h5>
                                          <div class="bank-table">
                                            <table class="table" id="myTable">
                                              <tbody>
                                                <tr>
                                                  <td class="left">帳戶組別</td>
                                                  <td class="left">流水賬</td>
                                                </tr>
                                                <tr>
                                                  <td class="left">賬戶類型</td>
                                                  <td class="left" id="type_account"></td>
                                                </tr>
                                                <tr>
                                                  <td class="left">帳戶匯率</td>
                                                  <td class="left" id="currency_show"></td>
                                                </tr>
                                                <tr>
                                                  <td class="left">槓桿</td>
                                                  <td class="left" id="leverage_show"></td>
                                                </tr>

                                              </tbody>
                                            </table>
                                          </div>
                                        </div>

                                      </div>
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
              @endsection
              @section('page-level-js')
              <script src="/js/passwordRulesHelper.min.js"></script>
              <script type="text/javascript">
                $(function(){
                  var form = $("#withdrawForm");

                  form.validate({
                    rules:{
                      account_type:{
                        required: true,
                      },
                      leverage:{
                        required:true,
                      },
                      password:{
                        required:true,
                      },
                      c_password:{
                        required:true,
                      }
                    },
                    messages:{
                      account_type:{
                        required:"請選擇帳戶類型"
                      },
                      leverage:{
                        required:"請選擇槓桿",
                      },
                      password:{
                        required:"密碼是必需的",
                      },
                      c_password:{
                        required:"確認你的密碼",
                      }
                    }
                  }),


                  $('#passwordField').passwordRulesValidator();
                  $('.rules').hide();
                  $('#passwordField, #c_password').on('keyup', function () {
                    $('.rules').show();
                    if ($('#passwordField').val() == $('#c_password').val()) {
                      $('#message').html('Password Matched').css('color', 'green');
                    } else 
                    $('#message').html('').css('color', 'red');
                  });
          //  function check_pass() {
          //     if (document.getElementById('passwordField').value ==
          //             document.getElementById('c_password').value) {
          //         document.getElementById('submit').disabled = false;
          //     } else {
          //         document.getElementById('submit').disabled = true;
          //     }
          // }


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


          });

          $('#account_type').on('change',function(){
            $select_val=$('#account_type option:selected').text();
            $('#type_account').html($select_val);

          });
          $select_val=$('#account_type option:selected').text();
          $('#type_account').html($select_val);

          $('#leverage').on('change',function(){
            $select_val1=$('#leverage option:selected').text();
            $('#leverage_show').html($select_val1);
          });
          $select_val1=$('#leverage option:selected').text();
          $('#leverage_show').html($select_val1);

          var $select_val2=$('#currency').val();
          $('#currency_show').html($select_val2);


            //how to transfer section
            $('.show-transfer-hide').hide();
            $('.up').hide();
            $('.show-transfer').click(function(){
              $(this).toggleClass('green');
              $('.down').toggle('2000');
              $('.show-transfer-hide').toggle('2000');
              $('.up').toggle();
            });
          });

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

</script>
@endsection
