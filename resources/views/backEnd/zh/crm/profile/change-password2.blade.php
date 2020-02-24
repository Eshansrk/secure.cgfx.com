@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '更改密码')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5" style="margin-left: 2%;">
                        <i class="fa fa-lock"></i>
                        更改密码
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card" style="border: none">
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                             @if(Session::has('msg'))
                             <div class="alert alert-success">{{Session::get('msg')}}
                             </div>
                             @endif  
                             @if(Session::has('error'))
                             <div class="alert alert-danger">{{Session::get('error')}}
                             </div>
                             @endif 
                             {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/change-password'),'class'=>'form','id'=> 'helpdeskform']) !!}
                             {{csrf_field()}}    
                             <ul id="progressbar">
                                <li class="active first">请求PIN码</li>
                                <li class="second">输入PIN码</li>
                                <li class="last">设置新密码</li>
                            </ul>
                            <fieldset class="field1 current">
                                <h2 style="font-size: 20px">更改您的密码</h2>
                                
                                <p>
                                    您将通过电子邮件收到PIN以授权您的密码更改请求
                                </p>
                                <p>
                                    <label for="Next">
                                        <input type="button" name="next" class="next action-button" value="下一个" />
                                    </label>
                                </p>
                            </fieldset>
                            <fieldset class="field2">
                                <h2 style="text-align: left;">輸入請求PIN</h2>
                                <p>
                                    請輸入我們剛剛發送到您的電子郵箱的PIN碼.
                                    <input class="pin-input" type="text" name="" style="width: 50%;height: 50%" minlength="6">
                                    <small id="small-msg" style="color: tomato">請輸入至少6位數的代碼</small>
                                    <small id="small-msg2" style="color: tomato">代碼不匹配</small>
                                </p>
                                <p>
                                    <label for="Next1">
                                        <input type="button" name="next1" class="next1 action-button" value="下一个" />
                                        <span>沒有收到PIN碼？ 
                                            <button type="button" style="color: green;background: transparent;border: none" id="resendShow">重新發送PIN碼<i class="fa fa-angle-down" aria-hidden="true" style="margin-left: 3px"></i></button>
                                        </span>
                                    </label>
                                </p>
                                <p>
                                    <div class="resend-code">
                                        <div class="second-view">
                                            <p id='count'>30s</p>
                                        </div>
                                        <div class="main-view">
                                            <p>您可以選擇在30秒內重新發送PIN碼。請注意，只有您收到的最後一個PIN有效</p>
                                            <div class="main-sub-view">
                                                <input type="button" class="resend-code-button" value="重發" style="width: 30%" />
                                            </div>
                                        </div>
                                    </div>
                                </p>
                            </fieldset>
                            <fieldset class="field3">
                                <h2 style="text-align: left;font-size: 20px;margin-bottom: 5%">確認並提交</h2>
                                <p style="text-align: left">
                                    <label for="new_password" style="width: 50%">新密碼:
                                        <input id="pass" type="password"  name="confirm_new_password" value="" class="form-control" style="padding: 10px">
                                    </label>
                                </p>
                                <p style="text-align: left" >
                                    <label for="confirm_new_password" style="width: 50%">確認新密碼:
                                        <input id="c-pass" type="password"  name="confirm_new_password" value="" class="form-control" style="padding: 10px">
                                        <small id="small-msg3" style="color: tomato">代碼不匹配</small>
                                        <small id="small-msg4" style="color: tomato">必須填寫密碼字段</small>
                                    </label>
                                </p>
                                <p style="text-align: left;">
                                    <label for="Submit">
                                        <input id="form-sub" type="button"  value="提交" class="form-control" style="cursor: pointer;width: 100px;font-weight: bold;border: 0 none;border-radius: 1px;cursor: pointer;padding: 10px 5px;margin: 10px 5px;background:#f0f0f0">
                                    </label>
                                </p>
                            </fieldset>
                            {!!Form::close()!!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section ('page-level-js')
<script type="text/javascript">
    $(document).ready(function () {
        $('#small-msg').hide();
        $('#small-msg2').hide();
        $('#small-msg3').hide();
        $('#small-msg4').hide();
        $('.next').click(function () {
            $('.current').removeClass('current').hide('slow').next().show('fast').addClass('current');
            $('#progressbar li.active').next().addClass('active');
            if ($('#progress')) {};
            $.ajax({
                url: '/send-password-reset-code',
                type:'get'
            });
        });
        $('.next1').click(function () {
            $('.pin-input').prop('required',true);
            var opp = $('.pin-input').val();
            $.ajax({
                url:'/check-verification-code/'+opp,
                type:'get',
                success:function(data){
                    if (data==1) {
                        $('.current').removeClass('current').hide('slow').next().show('fast').addClass('current');
                        $('#progressbar li.active').next().addClass('active');
                        if ($('#progress')) {};
                    }
                    else{
                        $('#small-msg2').show();
                    }
                } 
            }); 
        }); 
        $('.resend-code').css({'display':'none'});
        $('#resendShow').click(function(){
            $('.resend-code').toggle('slow');
        });
        $('.resend-code-button').on('click',function(){
         $.ajax({
            url: '/save-updated-password',
            type:'get'
        });
     });
        $('#form-sub').on('click',function(){
         $('#small-msg').hide();
         $('#small-msg2').hide();
         $('#small-msg3').hide();
         $('#small-msg4').hide();
         var pass = $('#pass').val();
         var c_pass = $('#c-pass').val();
         if (pass != c_pass) {
            $('#small-msg3').show();
        }
        else if(!pass)
        {
            $('#small-msg4').show();
        }
        else{
            $.ajax({
                url: "{{LaravelLocalization::localizeURL('/save-updated-password')}}",
                type:'post',
                data:{
                    _token:$('input[name=_token]').val(),
                    pass:c_pass
                },
                success: function(data){
                    location.reload(); }
                });
        }
    });
        $('.next').click(function(){
          var counter = 30;
          $('.resend-code-button').prop('disabled', true).css({'cursor':'not-allowed','color':'#999'});
          setInterval(function() {
            counter--;
            if (counter >= 0) {
              span = document.getElementById("count");
              span.innerHTML = counter;
          }
          if (counter === 0) {
            $('.resend-code-button').prop('disabled', false).css({'background':'#9ec46a','color':'#fff','cursor':'pointer'});
            clearInterval(counter);
        }
    }, 1000);
      });
        $('.resend-code-button').click(function(){
          var counter1 = 30;
          $('.resend-code-button').prop('disabled', true).css({'background':'#ddd','color':'#999','cursor':'not-allowed'});
          setInterval(function() {
            counter1--;
            if (counter1 >= 0) {
              span = document.getElementById("count");
              span.innerHTML = counter1;
          }
          if (counter1 === 0) {
            $('.resend-code-button').removeClass('disabled').css({'background':'#9ec46a','color':'#fff','cursor':'pointer'});
            clearInterval(counter1);
        }
    }, 1000);
      });
    });
</script>
@endsection