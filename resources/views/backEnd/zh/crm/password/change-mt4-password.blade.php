@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '修改MT4密码')
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
            修改MT4密码
          </h4>
        </div>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner bg-container">
      <div class="card">
        <div class="card-block m-t-35">
         <!--  <div class="row">
            <div class="col-md-6">
              <div class="show-transfer">
                <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                <a href="#">演示操作</a>
                <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
              </div>
              <div class="show-transfer-hide">
                <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>视频</a>
                <span>如何开户</span>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-12">
              <ul class="up-barcurb">
                <li class="first-li selected"> 1. 选择密码</li>
                <li class="second-li"> 2. 确定密码 </li>
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card select-account" style="height: auto">
                <div class="select-account-body">
                  <h4>修改MT4密码</h4>
                </div>
                @if(Session::has('error'))
                <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('error')}}</h3>
                </div>
                @endif
                {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/change-mt4-password'), 'id' => 'withdrawForm','class'=>'col-md-12 form form-horizontal']) !!}
                <div class="form-group">
                  <div class="span3 " style="margin-top: 5px;"><label class="control-label">选择账户:</label></div>
                  <div class="span4 form-group">
                    <select name="account_no" class="form-control" id="account_no" >
                      <option value="" disabled="disabled" selected="selected">选择账户</option>
                      @foreach($accounts as $account)
                      <option value="{{$account->account_no}}" @if(old('account_no')==$account->account_no) selected="selected" @elseif($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}})</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="span4"></div>
                </div>
                <div class="form-group">
                  <label for="password">密码:</label>
                  <input type='password' name='password' id='passwordField' class='form-control' autocomplete='new-password' style=""/>
                  <span class ='message' style="font-size: 11px"></span>
                </div>
                <div class="form-group">
                  <label for="confirmPassword">确认密码:</label>
                  <input type="password" name="c_password"
                  id="c_password" 
                  maxlength="20" class="form-control" style="">
                  <span id='message'></span>
                </div> 
                <br> 
                <div class="control-group">
                 <div class="span4"></div>
                 <div class="span4 form-group">
                   <input type="submit" id="submit" class="btn btn-primary" value="修改" name="submit"> 
                 </div> 
               </div>
               {!!Form::close()!!}
             </div>
           </div>
           <div class="col-md-6">
            <div class="card select-account" style="height: auto">
              <div class="select-account-body">
                <h4>修改投资者密码</h4>
              </div>
              @if(Session::has('investor_error'))
              <div class="alert alert-danger"><h3 style="color: #fff;padding-top: 5px;">{{Session::get('error')}}</h3>
              </div>
              @endif
              {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/change-mt4-investor-password'), 'name' => 'withdrawForm','class'=>'col-md-12 form form-horizontal','style'=>'','id'=>'form_id1']) !!}
              <div class="form-group">
                <div class="span3 " style="margin-top: 5px;"><label class="control-label">选择账户:</label></div>
                <div class="span4 form-group">
                  <select name="account_no" class="form-control" id="account_no1" >
                    <option value="" disabled="disabled" selected="selected">选择账户</option>
                    @foreach($accounts as $account)
                    <option value="{{$account->account_no}}" @if(old('account_no')==$account->account_no) selected="selected"@endif>{{$account->account_no}} ({{$account->act_type}})</option>
                    @endforeach
                  </select>
                </div>
                <div class="span4"></div>
              </div>
              <div class="form-group">
                <label for="investor_password">密码:</label>
                <input type='password' name='investor_password' id='passwordField1' class='form-control' autocomplete='new-password'  style=""/>
                <span class ='message1'></span>
              </div>
              <div class="form-group">
                <label for="cinvestor_password">确认密码:</label>
                <input type="password" name="cinvestor_password"
                id="c_password1" 
                maxlength="20" class="form-control" style="">
                <span id='message1'></span>
              </div> 
              <br> 
              <div class="control-group">
               <div class="span4"></div>
               <div class="span4 form-group">
                 <input type="submit" id="submit1" class="btn btn-primary" value="更改" name="submit1"> 
               </div> 
             </div>
             {!!Form::close()!!}
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
          required: "請選擇帳戶",
        },
        password : {
          required: "密碼是必需的",
        },
        c_password : {
          required: "確認你的密碼",
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
          required: "請選擇帳戶",
        },
        investor_password : {
          required: "密碼是必需的",
        },
        cinvestor_password : {
          required: "確認你的密碼",
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
    $('.show-transfer-hide').hide();
    $('.up').hide();
    $('.show-transfer').click(function(){
      $(this).toggleClass('green');
      $('.down').toggle('2000');
      $('.show-transfer-hide').toggle('2000');
      $('.up').toggle();
    });
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
        $('#message').html('密码不匹配').css('color', 'red');
        e.preventDefault();
      }
      else{
        var flag1 = checkMatchedPass(o_pass).a;
        var flag2 = checkMatchedPass(o_pass).b;
        var flag3 = checkMatchedPass(o_pass).c;
        var flag4 = checkMatchedPass(o_pass).d;
        var flag5 = checkMatchedPass(o_pass).e;
        if (flag1 == 0) {
          e.preventDefault();
        }
        if (flag2 == 0) {
          e.preventDefault();
        }
        if (flag3 == 0) {
          e.preventDefault();
        }
        if (flag4 == 0) {
          e.preventDefault();
        }
        if (flag5 == 0) {
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
        $('#message1').html('密码不匹配').css('color', 'red');
        e.preventDefault();
      }
      else{
        var flag1 = checkMatchedPass(o_pass).a;
        var flag2 = checkMatchedPass(o_pass).b;
        var flag3 = checkMatchedPass(o_pass).c;
        var flag4 = checkMatchedPass(o_pass).d;
        var flag5 = checkMatchedPass(o_pass).e;
        if (flag1 == 0) {
          e.preventDefault();
        }
        if (flag2 == 0) {
          e.preventDefault();
        }
        if (flag3 == 0) {
          e.preventDefault();
        }
        if (flag4 == 0) {
          e.preventDefault();
        }
        if (flag5 == 0) {
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
  });
</script>
@endsection