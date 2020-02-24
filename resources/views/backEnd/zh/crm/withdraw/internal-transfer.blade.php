@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '内部转账')
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
                        内部转账
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
                   <!--  <div class="row">
                        <div class="col-md-6">
                            <div class="show-transfer">
                                <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                                <a href="#">内部转账</a>
                                <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                            </div>
                            <div class="show-transfer-hide">
                                <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>视频</a>
                                <span>如何进行内部转移</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="up-barcurb">
                                <li class="first-li selected"> 1.转账细节</li>
                                <li class="second-li"> 2.确认转账 </li>
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
                        {!! Form::label('transfer_from', '转出账户 *') !!}
                        <select name="transfer_from" class="form-control input-lg "  id="transfer_from">
                            <option value="">选择交易账户</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                    </div>
                    <div class="form-group show-form">
                        {!! Form::label('transfer_to', '转入账户 *') !!}
                        <select name="transfer_to" class="form-control input-lg" id="transfer_to">
                            <option value="">选择交易账户</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_to') }}</small>
                    </div>
                    <div class="form-group show-form">
                        {!! Form::label('amount', '转账金额 *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => '输入USD金额','onkeyup'=>'calculatenet()','name' => 'amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                    </div>
                    <div class="form-group">
                        {!!Form::button('转账',['class'=>'btn btn-primary transfer-button show-form','type'=>'button'])!!}
                    </div>
                    <div class="form-group hide-form">
                        <table class="table table-bordered ">
                            <thead>
                              <tr>
                                <td colspan="2" style="text-align: left;"><b>Please confirm the details below and pay</b></td>
                            </tr>
                        </thead>
                        <tr>
                            <td style="font-weight:bold">Transfer From *</td>
                            <td class="deposit-from"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Transfer To *</td>
                            <td class="amount-withdraw"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Net Amount</td>
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
                            <h5>转账细节:</h5>
                            <div class="bank-table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="left">币种:</td>
                                            <td class="left">USD</td>
                                        </tr>
                                        <tr>
                                            <td class="left">转出账户</td>
                                            <td class="left" id="trFrom"></td>
                                        </tr>
                                        <tr>
                                            <td class="left">转入账户</td>
                                            <td class="left" id="trTo"></td>
                                        </tr>
                                        <tr>
                                            <td class="left">金额</td>
                                            <td class="left" id="trAmount"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bank-info" style="padding: 0">
                            <ol>
                                <li> 不接受第三方付款。汇款人的姓名必须与您的交易账户名称一致。</li>
                                <li> {{$general_info->company_name}} 接受欧元，美元和英镑的电汇。以其他货币发送的资金将转换为您账户的存款货币。您可能需要支付转换费。</li>
                                <li> 汇款银行或代理行可能扣除处理电汇的费用。 {{$general_info->company_name}} 不收取任何费用，并将收到的净金额存入您的账户。</li>
                                <li>  如果交易完成，资金将在{{$general_info->company_name}}收到后存入到您的交易账户。处理时间一般为3-5个工作日。如果银行或{{$general_info->company_name}}无法验证您的信息，可能会有延迟。请保存您的银行电汇确认，以便我们在必要时查看所有详细信息。</li>
                                <li>通过电汇存入的资金可以提取到您名下的任何银行账户.</li>
                                <li>资金的来源应与资金的转出接收方相同。您的取款接受账户只能与您最初存入的账户相同.</li>
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
                transfer_from: {required:'选择交易账户'},
                transfer_to: {required:'选择交易账户'},
                amount: {required:'输入有效金额'},
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
