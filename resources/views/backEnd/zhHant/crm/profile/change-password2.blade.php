
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '修改密碼')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-lock"></i>
                        修改密碼
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
            <div class="card" style="border: none;">

                        
                            
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
                                        
                                         <!-- Progress Bar -->
    <ul id="progressbar">
        <li class="active first">請求PIN</li>
        <li class="second">輸入PIN</li>
        <li class="last">設置新密碼</li>
    </ul>
    <fieldset class="field1 current">
            <h2 style="font-size: 20px">修改您的密碼</h2>
            

        <p>
            您的電子郵箱將會受到一封來自PIN授權更改密碼的請求.
        </p>
        <p>
            <label for="Next">
                <input type="button" name="next" class="next action-button" value="Next" />
            </label>
        </p>
    </fieldset>
    <fieldset class="field2">
            <h2 style="text-align: left;">輸入請求PIN</h2>

        <p>
            請輸入我們剛發送到您電子郵件中的PIN
            <input class="pin-input" type="text" name="" style="width: 50%;height: 50%" minlength="6">
            <small id="small-msg" style="color: tomato">請輸入至少6位程式碼</small>
            <small id="small-msg2" style="color: tomato">程式碼不匹配</small>
        </p>
        
        <p>
            <label for="Next1">
                <input type="button" name="next1" class="next1 action-button" value="Next" />
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
                    <p>您可以選擇在30秒內重新發送PIN。請注意，只有您收到的最後一個PIN有效</p>
                    <div class="main-sub-view">
                        <input type="button" class="resend-code-button" value="Resend" style="width: 30%" />
                        <!-- <a href="">Send PIN code by voice call</a> -->
                    </div>
                </div>
            </div>
        </p>
    </fieldset>
    
    <fieldset class="field3">
            <h2 style="text-align: left;font-size: 20px;margin-bottom: 5%">確認並提交</h2>
        <p style="text-align: left">
            <label for="new_password" style="width: 50%">新密碼：
                <input id="pass" type="password"  name="confirm_new_password" value="" class="form-control" style="padding: 10px">
            </label>
        </p>

        <p style="text-align: left" >
            <label for="confirm_new_password" style="width: 50%">確認新密碼：
            <input id="c-pass" type="password"  name="confirm_new_password" value="" class="form-control" style="padding: 10px">
            <small id="small-msg3" style="color: tomato">程式碼不匹配</small>
            <small id="small-msg4" style="color: tomato">必須填寫密碼字段</small>
            </label>
        </p>
        
        
        <p style="text-align: left;">
            <label for="Submit">
                <input id="form-sub" type="button"  value="Submit" class="form-control" style="cursor: pointer;width: 100px;font-weight: bold;border: 0 none;border-radius: 1px;cursor: pointer;padding: 10px 5px;margin: 10px 5px;background:#f0f0f0">
                

            </label>
        </p>
    </fieldset>

                                     {!!Form::close()!!}
                                        
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
            } //success ends
            }); //ajax ends
       
            
    

    }); //next1 click ends

    // $('.previous').click(function () {
    //     $('.current').removeClass('current').hide().prev().show().addClass('current');
    //     $('#progressbar li.active').removeClass('active').prev().addClass('active');
    // });

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

    //confirm password match check

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
        else if(!pass){$('#small-msg4').show();}
        else{
            $.ajax({
        url: '{{LaravelLocalization::localizeURL("/save-updated-password")}}',
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
