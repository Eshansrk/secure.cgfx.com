
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Perfect Money Withdraw')
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
                        <i class="fa fa-home"></i>
                        Perfect Money Withdraw
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
                                        <a href="#">Show me how</a>
                                        <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="show-transfer-hide">
                                        <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                        <span>How to make an internal transfer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected"> 1.Transfer Details</li>
                                        <li class="second-li"> 2.Confirm Transfer </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- <h2>Perfect Money Withdraw</h2> -->
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/perfect_money_withdraw'), 'name' => 'withdrawForm','class'=>'col-md-7','id'=>'perfectMoneyForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('transfer_from', 'Transfer From *') !!}
                            <select name="transfer_from" class="form-control input-lg"  id="transfer_from">
                            <option value="">Select Trading Account</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->acc_no}} {{$account->balance}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                    <div class="form-group show-form">
                        
                            {!! Form::label('amount', 'Amount to be withdrawn *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Enter Amount in USD','onchange'=>'calculatenet()']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        <div class="form-group show-form">
                        
                            {!! Form::label('net_amount', 'Net Amount') !!}
                        {!! Form::text('net_amount', null, ['class' => 'form-control input-lg','id'=>'net_amount', 'readonly'=>'readonly']) !!}
                        <small class="text-danger">{{ $errors->first('net_amount') }}</small>
                        </div>

                        
                        <div class="form-group show-form">
                        
                            {!! Form::label('account', 'Perfect Money Account Id *') !!}
                        {!! Form::text('account', null, ['class' => 'form-control input-lg',  'placeholder' => 'Enter Account Id']) !!}
                        <small class="text-danger">{{ $errors->first('account') }}</small>
                        </div>

                        <div class="form-group show-form">
                        
                            {!! Form::label('email', 'Perfect Money Email *') !!}
                        {!! Form::email('email', null, ['class' => 'form-control input-lg',  'placeholder' => 'Enter Perfect Money Email Address']) !!}
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="form-group">
                        {!!Form::button('Withdraw',['class'=>'btn btn-primary transfer-button show-form'])!!}
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
                                    <td style="font-weight:bold">Amount to be withdrawn *</td>
                                    <td class="amount-withdraw"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight:bold">Net Amount</td>
                                    <td class="amount"></td>
                                  </tr>

                                  

                                  <tr>
                                    <td style="font-weight:bold">Perfect Money Email *</td>
                                    <td class="email"></td>
                                  </tr>
                                
                               
                               </table>
                            <br>
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary transfer-button'])!!}
                        </div>
                        {!!Form::close()!!}
                        <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Transfer details:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Currency:</td>
                                                <td class="left">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Fees / Commission:</td>
                                                <td class="left">2.5%</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Processing Time:</td>
                                                <td class="left">3-5 Business Days</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> Payments from third parties are not accepted. The name of the sender must match the name on your trading account.</li>
                                    <li> {{$general_info->company_name}} accepts wire transfers in USD. Funds sent in a different currency will be converted to the deposit currency of your account. You may be charged a fee for the conversion.</li>
                                    <li> The sending bank or correspondent bank may deduct a fee for processing a wire transfer. {{$general_info->company_name}} does not apply any fees and will deposit to your account the net amount received.</li>
                                    <li>  If the transaction goes through, the funds will be posted to your trading account upon receipt by {{$general_info->company_name}}. The processing time is generally 3-5 business days. There may be a delay if the bank or {{$general_info->company_name}} is unable to verify your information. Please save your bank wire confirmation so we can check all details if necessary.</li>
                                    <li>   Funds deposited by wire transfer may be withdrawn to any bank account in your name.</li>
                                    <li>   The source of incoming of funds should be the same as the outgoing of funds. In this respect the withdrawal of your deposit can only be made to the same account from which you originally deposited.</li>
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



<script>
    function calculatenet(){
  var amt = document.getElementById('amount').value;
  var total = (amt*2.5)/100;
  var total1 = amt - total;
  total1= Math.round(total1 * 100) / 100;
  document.getElementById('net_amount').value = total1;

  
}
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
        $('#perfectMoneyForm').validate({
            rules:{
                transfer_from: "required",
                net_amount: "required",
                amount: "required amount",
                email: "required",
                account: "required"
            },
            messages:{
                transfer_from: 'Select Trading Account',
                // transfer_to: 'Select Trading Account',
                amount: 'Enter valid Amount'
            }

        });

        //form validity check and next
        $('.hide-form').hide();
        
        $('.transfer-button').click(function(){
           if($('#perfectMoneyForm').valid()==true) {
                $('.first-li').removeClass('selected');
                $('.second-li').addClass('selected');
                $('.hide-form').show(500);
                $('.show-form').hide(300);
                $('.deposit-from').html($('#transfer_from').val());
                    $('.amount-withdraw').html($('#amount').val());
                    $('.amount').html($('#net_amount').val());
                    $('.email').html($('#email').val());
            }
           });
    
        
    });
</script>
@endsection





