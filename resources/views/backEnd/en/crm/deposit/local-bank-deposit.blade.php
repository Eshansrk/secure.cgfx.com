
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Local Bank Deposit')
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
                        Local Bank Deposit
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
                           
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected"> 1.Transfer Details</li>
                                        <li class="second-li"> 2.Confirm Transfer </li>
                                    </ul>
                                </div>
                            </div>
                            
                            
                        @if(Session::has('msg'))
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                <h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                            </div>
                        </div>
                        @endif                        

                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/local-bank-transfer-funds'), 'name' => 'withdrawForm','class'=>'col-md-7','id'=>'localbankv']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('deposit_to', 'Deposit to *') !!}
                            <select name="deposit_to" class="form-control input-lg"  id="deposit-to">
                            <option value="">Select Trading Account</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} {{$account->CURRENCY}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('deposit_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        
                            {!! Form::label('amount', 'Enter Amount to Deposit (USD)*') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount',  'placeholder' => 'Enter Amount in USD']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        <div class="form-group show-form">
                        
                        {!! Form::label('amount2', 'Amount to Deposit') !!}(<span id="local_currency_code">{{ $currency_iso }}</span>)
                        {!! Form::text('amount2', null, ['class' => 'form-control input-lg','id'=>'local_amount', 'readonly'=>'readonly', 'placeholder' => 'Amount in Other Currency']) !!}
                        <small class="text-danger">{{ $errors->first('amount2') }}</small>
                        </div>

                        <span class="text-danger"><small class="currency_value_message"></small></span>
                        
                        <div class="form-group show-form">
                        {!!Form::submit('Deposit',['class'=>'btn btn-primary transfer-button'])!!}
                        </div>
                        
                        {!!Form::close()!!}
                        <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Deposit details:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Currency:</td>
                                                <td class="left">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Fees / Commission:</td>
                                                <td class="left">No Commission</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Processing Time:</td>
                                                <td class="left">instant</td>
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
                                    <li>  If the transaction goes through, the funds will be posted to your trading account upon receipt by {{$general_info->company_name}}.</li>
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
@endsection
@section ('page-level-js')
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

        // $.validator.addMethod('amount2', function (value) { 
        //     return /^[0-9]+(\.[0-9]{1,2})?$/.test(value); 
        // }, 'Please enter a valid code.');
        
        //form validation
        $('#localbankv').validate({
            rules:{
                deposit_to: "required",
                amount: "required amount",
            },
            messages:{
                deposit_to: 'Select Trading Account',
                amount: 'Enter valid Amount'
            }

        });

        //form validity check and next
        $('.hide-form').hide();
        
           
        
    });



    var timeout = null
    $('#amount').on('keyup', function() {
        $('#local_amount').val('');
        $('.currency_value_message').text('');
        var local_currency = $('#local_currency_code').text();
        var currency_pair = 'USD_'+local_currency;
        var usd_ammount = parseFloat(this.value);
        if (usd_ammount!='' && usd_ammount>=1) {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                $.ajax({
                    url: "https://free.currconv.com/api/v7/convert?q="+currency_pair+"&compact=ultra&apiKey=2ba12ec9052e0a42bce3",
                    type: "GET",
                    data:{},
                    success: function(response){
                        var other_currency_rate = parseFloat(response[currency_pair]);
                        var other_currency_amount = parseFloat(usd_ammount*other_currency_rate);
                        $('#local_amount').val(other_currency_amount.toFixed(2));
                        $('.currency_value_message').text('This rate is only valid for today.');
                   }        
               });
            }, 1500) 
        }
        
    })

</script>
@endsection








