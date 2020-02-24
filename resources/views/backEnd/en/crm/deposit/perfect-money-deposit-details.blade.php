
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Perfect Money Deposit')
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
                        Perfect Money Deposit
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
                                        <li class="first-li"> 1.Transfer Details</li>
                                        <li class="second-li selected"> 2.Confirm Transfer </li>
                                    </ul>
                                </div>
                            </div>
                            
                            
                            {!! Form::open(['method' => 'POST', 'url' => 'https://perfectmoney.is/api/step1.asp', 'name' => 'withdrawForm','class'=>'col-md-6','id'=>'withdrawForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
        <input type="hidden" name="PAYEE_ACCOUNT" value="U7493427">
                        <input type="hidden" name="PAYEE_NAME" value="Limited">
                        <input type="hidden" name="PAYMENT_ID" value="{{$reference}}">
                        <input type="hidden" name="PAYMENT_AMOUNT" value="{{$request->amount}}">
                        <input type="hidden" name="PAYMENT_UNITS" value="USD">
                        <input type="hidden" name="STATUS_URL" value="{{config('app.url')}}/{{app()->getLocale()}}/perfect_money_deposit_status">
                        <input type="hidden" name="PAYMENT_URL" value="{{config('app.url')}}/{{app()->getLocale()}}/perfect_money_deposit_success">
                        <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
                        <input type="hidden" name="NOPAYMENT_URL" value="{{config('app.url')}}/{{app()->getLocale()}}/perfect_money_deposit_cancel">
                        <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
                        <input type="hidden" name="SUGGESTED_MEMO" value="">
                        <input type="hidden" name="BAGGAGE_FIELDS" value="">
                            
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
            <td>Perfect Money</td>
          </tr>
          
          <tr> 
            <td style="font-weight:bold">Amount</td>
            <td>{{$request->amount}} USD</td>
          </tr>
       
       </table>
                            <br>
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary'])!!}
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









