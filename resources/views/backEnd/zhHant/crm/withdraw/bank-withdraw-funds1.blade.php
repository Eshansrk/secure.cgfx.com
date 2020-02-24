
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '出金 Request')
@section ('page-level-css')
<!--Plugin styles-->
<link type="text/css" rel="stylesheet" href="/vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
<link type="text/css" rel="stylesheet" href="/vendors/switchery/css/switchery.min.css" />
<link type="text/css" rel="stylesheet" href="/vendors/radio_css/css/radiobox.min.css" />
<link type="text/css" rel="stylesheet" href="/vendors/checkbox_css/css/checkbox.min.css" />
<!--End of Plugin styles-->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="/css/pages/radio_checkbox.css" />
<link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
<!--End of Page level styles-->
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-money"></i>
                        出金 Request
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <!--top section widgets-->
            <div class="card " style="padding: 20px">
                <div class="row">
                    <div class="col-md-7">
                        {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/bank-withdraw-funds'), 'name' => 'bankForm','class'=>'col-md-10','id'=>'bankWithdrawFunds']) !!}

                        @if($errors->any())
                        <h4 style="color:red;">{{$errors->first()}}</h4>
                        @endif

                        {{csrf_field()}}

                        @if(Session::has('success'))
                        <span class="text-success">
                            {{Session::get('success')}}
                        </span>
                        @endif

                        
                        <label for="payment_system">支付方法</label>
                        <input class="form-control" name="payment_system" placeholder="Bank Payment" disabled="disabled" type="text" style="width: 50%">
                        <label for="" style="margin-top: 5%">帳戶</label>
                        <div class="form-group" style="width: 50%">
                            <select class="form-control item" name="transfer_from">
                                <option disabled selected value="">選擇</option>
                                @foreach($accounts as $key => $accounts)
                                <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="" style="margin-top: 5%">匯率 <span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Please indicate the currency in which you would like to make your transfer "></i></span></label>

                        <div class="radio">
                            <label>
                                <input name="currency" class="rad" value="USD" type="radio">
                                <span class="cr" style="font-size: 18px;cursor: pointer;" id="hi"><i class="cr-icon fa fa-circle"></i></span>
                                USD
                            </label>
                        </div>

                        <div class="bank-info" id="bank-info">


                            
                                <div class="form-group col-md-12">

                                    {!! Form::label('amount', '待提取金額 *') !!}
                                    {!! Form::text('amount', '', ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '待提取金額']) !!}
                                    
                                </div>
                          

                            <div class="form-group col-md-6">
                                
                                    {!! Form::label('bank_acc_name', '銀行帳戶名稱 *') !!}
                                    {!! Form::text('bank_acc_name', $info->bank_acc_name, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '入境銀行帳戶名稱']) !!}
                                    
                                
                            </div>
                            
                                <div class="col-md-6 form-group">

                                    {!! Form::label('bank_acc_num', '賬號(IBAN) *') !!}
                                    {!! Form::text('bank_acc_num', $info->bank_acc_num, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入銀行帳戶名']) !!}
                                    
                                </div> 
                           

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_name', '銀行名稱  *') !!}
                                {!! Form::text('bank_name', $info->bank_name, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入銀行名稱']) !!}
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_country', '銀行國家 *') !!}

                                <select name="bank_residence_country" id="country" class="form-control" required="required">
                                    <option selected="selected" disabled="disabled">銀行國家 *</option>
                                    @foreach($countries as $country)
                                    <option id="{{$country->countries_id}}" value="{{$country->countries_name}}" {{($info->bank_residence_country==$country->countries_name)?'selected="selected"':''}}>{{$country->countries_name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            <div class="clearfix"></div>


                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_state', '州/省份  *') !!}

                                <select name="bank_residence_state" id="state" class="form-control" required="required">

                                </select>

                                <!--  {!! Form::text('bank_residence_state', $info->bank_residence_state, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank State Province']) !!} -->
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_city', '城市 *') !!}
                                <select name="bank_residence_city" id="city" class="form-control" required="required">

                                </select>

                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_code', '郵政編碼 *') !!}
                                {!! Form::text('bank_residence_code', $info->bank_residence_code, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入銀行郵政編碼']) !!}
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('swift_num', '銀行代碼 *') !!}
                                {!! Form::text('swift_num', $info->swift_num, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入 銀行代碼']) !!}
                                
                            </div>


                            <div class="form-group col-md-12">

                                {!! Form::label('bank_address', '銀行地址 *') !!}
                                {!! Form::textarea('bank_address', $info->bank_address, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入銀行地址']) !!}
                                
                            </div>




                            <div class="form-group col-md-12">
                                {!!Form::submit('Withdraw',['class'=>'btn btn-primary'])!!}
                            </div>
                            {!!Form::close()!!}
                        </div>

                    </form>
                </div>


                <div class="col-md-5">
                    <div class="">
                        <div class="bank-info">
                            <h5>轉帳 詳情:</h5>
                            <div class="bank-table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="left">匯率:</td>
                                            <td class="left">USD</td>
                                        </tr>
                                        <tr>
                                            <td class="left">手續費:</td>
                                            <td class="left">2.5%</td>
                                        </tr>
                                        <tr>
                                            <td class="left">處理時間:</td>
                                            <td class="left">24小时</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bank-info" style="padding: 0">
                            <ol>
                                <li> 不接受第三方付款。發送方的名稱必須與您交易帳戶上的名稱匹配。</li>
                                <li> 您可以以您的名義將資金轉移到任何銀行帳戶。您的首次存款只能選取到您原來存入的同一個銀行帳戶。</li>
                                <li> 銀行電匯取款支付用途：
                                    <ul>
                                        <li>{{$general_info->company_name}} 轉帳</li>
                                        <li>客戶身份證號</li>
                                        <li>日期</li>
                                    </ul>

                                </li>
                                <li>  無最低選取金額。請注意，處理資金選取的費用將從選取的金額中扣除。</li>
                                <li>   確保您的帳戶中有足够的自由保證金來支付您的提款。如果您不這樣做，您可以選擇關閉您帳戶上的未結頭寸。</li>
                                <li>   提款由 {{$general_info->company_name}} 在您提出請求後24小時內處理。資金將在我們處理後的3-5個工作日內匯入您的銀行帳戶。如果我們無法驗證您的資訊，可能會有延遲。</li>
                                <li> {{$general_info->company_name}} 儘管客戶有要求，但外匯客戶關係管理如認為適當，保留從客戶要求的銀行以外的任何銀行支取款項的唯一權利。銀行手續費的任何差額將由 承擔 {{$general_info->company_name}}.</li>
                            </ol>
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

@section ('page-level-js')
<!--Plugin scripts-->
<script type="text/javascript" src="/vendors/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="/vendors/switchery/js/switchery.min.js"></script>
<!--End of plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="/js/pages/radio_checkbox.js"></script>
<!--End of Page level scripts-->
<!-- end page level scripts -->
<script type="text/javascript">

    var selected_state=<?php echo json_encode($info->bank_residence_state, JSON_HEX_TAG); ?>;
    var selected_city=<?php echo json_encode($info->bank_residence_city, JSON_HEX_TAG); ?>;


    var id=$('option:selected', '#country').attr('id');
    $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-states')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 

          $('#state').html( data );

          $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});


          var id=$('option:selected', '#state').attr('id');

          $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#city').html( data );
              $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});


          }
      });

      }
  });
    $(document).on('change','#country',function(){
        var id=$('option:selected', '#country').attr('id');
        $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-states')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#state').html( data );
              $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});

          }
      });
    })





    $(document).on('change','#state',function(){

        var id=$('option:selected', '#state').attr('id');

        $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#city').html( data );
              $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});

          }
      });
    })
</script>
<script>
    $(document).ready(function(){
        var form = $('#bank-withdraw-funds');
        
        form.validate({
            rules : {
                amount : "需要"
            },
            messages : {
                amount : "請輸入金額"
            }
        });


        $('[data-toggle="tooltip"]').tooltip();

        $('#bank-info').css({'display':'none'});

        $('.rad').click(function() {
            var item = $(".item option:selected").val();
            if($(this).is(':checked')) { 
                if (item=='') {
                    $('#bank-info').css({'display':'none'});}
                    else{
                        $('#bank-info').css({'display':'block'});}
                    }
                    else{
                        $('#bank-info').css({'display':'none'});
                    }
                });

        if ($(".item option:selected").val() && $('.rad').is(':checked') ) {
            $('#bank-info').css({'display':'block'});
        }else{
            $('#bank-info').css({'display':'none'});
        }


        $('.item').click(function() {
            var rad = $('.rad').is(':checked');
            if($('.item option:selected').val()) { 
                if (rad=='') {
                    $('#bank-info').css({'display':'none'});}
                    else{
                        $('#bank-info').css({'display':'block'});}
                    }
                    else{
                        $('#bank-info').css({'display':'none'});
                    }

                });

    });
</script>
@endsection
