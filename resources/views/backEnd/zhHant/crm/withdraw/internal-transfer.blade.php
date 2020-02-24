
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '轉帳')
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
                        <i class="fa fa-exchange"></i>
                        轉帳
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class="card">

                        <div class="card-block m-t-35">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="show-transfer">
                                        <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                                        <a href="#">教學</a>
                                        <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                                    </div>
                                   {{--  <div class="show-transfer-hide">
                                        <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                        <span>How to make an internal transfer</span>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected"> 1.轉帳詳情</li>
                                        <li class="second-li"> 2..確認轉帳 </li>
                                    </ul>
                                </div>
                            </div>
                            @if(Session::has('msg'))
                            <div class="col-md-12">
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                        </div>
                        @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/internal-transfer'), 'name' => 'withdrawForm','class'=>'col-md-8','id'=>'netellerForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('transfer_from', '由此轉帳 *') !!}
                            <select name="transfer_from" class="form-control input-lg "  id="transfer_from">
                            <option value="">選擇交易帳戶</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>

                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                         <div class="form-group show-form">
                        
                            {!! Form::label('transfer_to', '轉帳至 *') !!}
                            <select name="transfer_to" class="form-control input-lg" id="transfer_to">
                            <option value="">選擇交易帳戶</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        <!-- <p style="text-align: justify;">When carrying out non-trading operations between accounts with different deposit currencies, a conversion will take place according to the <a href="" style="color: green">Company exchange rates</a> on the day the funds are credited to Forex Time's account.</p> -->
                            {!! Form::label('amount', '轉帳金額*') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => '輸入金額','onkeyup'=>'calculatenet()','name' => 'amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        <div class="form-group">
                        {!!Form::button('轉帳',['class'=>'btn btn-primary transfer-button show-form','type'=>'button'])!!}
                        </div>
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
                                <thead>
                                  <tr>
                                    <td colspan="2" style="text-align: left;"><b>請確認以下詳細信息並付款</b></td>
                                  </tr>
                              </thead>
                                  <tr>
                                    <td style="font-weight:bold">由此轉帳 *</td>
                                    <td class="deposit-from"></td>
                                  </tr>
                                <tr>
                                    <td style="font-weight:bold">轉帳至 *</td>
                                    <td class="amount-withdraw"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight:bold">金額</td>
                                    <td class="amount"></td>
                                  </tr>

                                  
                               
                               </table>
                            <br>
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary transfer-button','type'=>'button'])!!}
                        </div>
                        {!!Form::close()!!}
                        <div class="col-md-4">
                        <div class="">
                            <div class="">
                                <h5>轉帳詳情:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">匯率:</td>
                                                <td class="left">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">由此轉帳</td>
                                                <td class="left" id="trFrom"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">轉帳至</td>
                                                <td class="left" id="trTo"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">金額</td>
                                                <td class="left" id="trAmount"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> 不接受第三方付款。發送方的名稱必須與您交易帳戶上的名稱匹配</li>
                                    <li> {{$general_info->company_name}} 接受歐元、美元和英鎊的電匯。以不同貨幣發送的資金將轉換為您帳戶的存款貨幣。轉換時可能會收取費用。</li>
                                    <li> 發送行或代理行可扣除電匯手續費。 {{$general_info->company_name}} 不收取任何費用，並將收到的淨金額存入您的帳戶。</li>
                                    <li>  如果交易成功, 將在收到資金後將其過帳到您的交易帳戶 {{$general_info->company_name}}. 處理時間一般為3-5個工作日。 如果銀行或 {{$general_info->company_name}} 無法驗證您的資訊，可能會有延遲。 請保存您的銀行電匯確認書，以便我們在必要時檢查所有細節。</li>
                                    <li>   以電匯方式存入的資金可以以您的名義存入任何銀行帳戶。</li>
                                    <li>   資金的流入來源應與資金的流出來源相同。在這方面，您的存款只能選取到您原來存入的同一帳戶。</li>
                                </ol>
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



<script type="text/javascript">
  $('select').change(function() {

    var value = $(this).val();

    $('select').not(this).children('option').each(function() {
        if ( $(this).val() === value ) {
            $(this).attr('disabled', true).siblings().removeAttr('disabled');   
        }
    });

});
</script>
@endsection

@section('page-level-js')
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(function(){

        //how to transfer section
        $('.show-transfer-hide').hide();
        $('.up').hide();
        $('.show-transfer').click(function(){
            $(this).toggleClass('green');
            $('.down').toggle('2000');
            $('.show-transfer-hide').toggle('2000');
            $('.up').toggle();
        });

        $.validator.addMethod('amount', function (value) { 
            return /^[0-9]+(\.[0-9]{1,2})?$/.test(value); 
        }, 'Please enter a valid US or Canadian postal code.');
        //form validation
        $('#netellerForm').validate({
            rules:{
                transfer_from: "required",
                transfer_to: "required",
                amount: "required amount",
            },
            messages:{
                transfer_from: {required:'選擇交易帳戶'},
                transfer_to: {required:'選擇交易帳戶'},
                amount: {required:'輸入有效金額'},
            }

        });

        //form validity check and next
        $('.hide-form').hide();
        
        $('.transfer-button').click(function(){
           if($('#netellerForm').valid()==true) {
                $('.first-li').removeClass('selected');
                $('.second-li').addClass('selected');
                $('.hide-form').show(500);
                $('.show-form').hide(300);
                 $('.deposit-from').html($('#transfer_from').val());
                    $('.amount-withdraw').html($('#transfer_to').val());
                    $('.amount').html($('#amount').val());
                    
            }
           });

            $('#transfer_from').on('change',function(){
              $select_val=$('#transfer_from option:selected').val();
              $('#trFrom').html($select_val);
              
            });
            $select_val=$('#transfer_from option:selected').val();
            $('#trFrom').html($select_val);


            $('#transfer_to').on('change',function(){
              $select_val=$('#transfer_to option:selected').val();
              $('#trTo').html($select_val);
              
            });
            $select_val=$('#transfer_to option:selected').val();
            $('#trTo').html($select_val);

            $('#amount').on('input',function(){
                var input_val=$('#amount').val();
                $('#trAmount').html(input_val);
            });
            var input_val=$('#amount').val();
            $('#trAmount').html(input_val);
        
    });
</script>
@endsection




