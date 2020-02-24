
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Visa / Master Card Deposit')
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
                        Visa / Master Card Deposit
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           
                                   <div class="card-block">
                            {{-- <div class="row">
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
                            </div> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li"> 1. Transfer Details</li>
                                        <li class="second-li selected"> 2. Confirm Transfer </li>
                                    </ul>
                                </div>
                            </div>
                            
                            
                 <form class="col-md-6" id='payform' onsubmit='return false;' method='POST' action='https://voguepay.com/pay/'>

                 {{-- <input type='hidden' name='v_merchant_id' value='' />  --}}
                <input type='hidden' name='v_merchant_id' value='demo' />
                <input type='hidden' name='merchant_ref' value="{{$reference}}" />
                <input type='hidden' name='memo' value='Deposit' />
                <input type='hidden' name='notify_url' value='{{config("app.url")}}/{{app()->getLocale()}}/voguepay_deposit_notify' />
                {{-- <input type='hidden' name='success_url' value='' /> --}}
                {{-- <input type='hidden' name='fail_url' value='' /> --}}
                <!--<input type='hidden' name='developer_code' value='' />-->

                <input type='hidden' name='total' value="{{$request->amount}}" />
                <input type='hidden' name='cur' value='USD' />
                {{-- <input type='hidden' name='closed' value='closedFunction'> --}}
                <input type='hidden' name='success' value='successFunction'>
                <input type='hidden' name='failed' value='failedFunction'>
                            
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
        <thead>
          <tr>
            <td colspan="2" style="text-align: left;"><b>Please confirm the details below and pay</b></td>
          </tr></thead>
          <tr>
            <td style="font-weight:bold">Reference No.</td>
            <td>{{$reference}}</td>
          </tr>
      <tr>
            <td style="font-weight:bold">Account Number</td>
            <td>{{$request->deposit_to}}</td>
          </tr>
        <tr>
            <td style="font-weight:bold">Payment Type</td>
            <td>Visa / Master Card</td>
          </tr>
          
          <tr> 
            <td style="font-weight:bold">Amount</td>
            <td>{{$request->amount}} USD</td>
          </tr>
       
       </table>
                            <br>
                            <input type="submit" value="Confirm" class="btn btn-primary">
                        </div>
                        </form>
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
<script src="//voguepay.com/js/voguepay.js"></script>

<script>
    // closedFunction=function() {
    //     alert('window closed');
    // }

     successFunction=function(transaction_id) {
        // alert('Transaction was successful, Ref: '+transaction_id)
        $('.card-block').html('<div class="card card-block" style="background:#4DB6AC;padding:10px;margin-top:20px;"><h2 style="color:#fff;">Your Deposit has been processed successfully to '+{{$request->deposit_to}}+'.</h2></div>');
    }

     failedFunction=function(transaction_id) {
         // alert('Transaction was not successful, Ref: '+transaction_id)
         $('.card-block').html('<div class="card card-block" style="background:#EE6E73;padding:10px;margin-top:20px;"><h2 style="color:#fff;">Your Deposit has been cancelled. Please <a href="/voguepay_deposit" style="color:#fff;text-decoration:underline;">Retry</a>.</h2></div>');
    }
</script>
<script>
    Voguepay.init({form:'payform'});
</script>

@endsection








