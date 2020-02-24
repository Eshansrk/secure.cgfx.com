
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Citigate Deposit Details')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-8">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Citigate Deposit Details
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
                    <h2>Citigate Deposit Details</h2>
                    @if(Session::has('msg'))
                    <div class="col-md-12">
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                    </div>
                    @endif


                    {!! Form::open(['method' => 'POST', 'url' => 'https://test.dg-gw.co.uk/orion/hosted/Payment.aspx', 'name' => 'withdrawForm','class'=>'col-md-6','id'=>'']) !!}
                    @if($errors->any())
                    <h4 style="color:red;">{{$errors->first()}}</h4>
                    @endif


                    <input type="hidden" name="Signature" id="Signature" value="{{session('signature')}}"/>

<!-- <table>
<tr>
<td>
Merchant Name:
</td>
<td> --><input name="MerchantName" id="MerchantName" type="hidden" value="Dummy2"/>
    <input name="Firstname" id="Firstname" type="hidden" value="{{$info->fname}}"/>
    <input name="MerchantPassword" id="MerchantPassword" type="hidden" value="p@s5w0Rd123"/>
    <input name="Surname" id="Surname" type="hidden" value="{{$info->lname}}"/>
    <input name="MerchantRef" id="MerchantRef" type="hidden" value="{{session('reference')}}"/>
    <input name="StreetLine1" id="StreetLine1" type="hidden" value="{{$info->bank_address}}"/>
    <input name="Currency" id="Currency" type="hidden" value="USD"/>
    <input name="Country" id="Country" type="hidden" value="{{$country->countries_iso_code}}"/>
    <input name="Amount" id="Amount" type="hidden" value="{{session('amount')}}"/>

    <input name="City" id="City" type="hidden" value="{{$info->bank_residence_city}}"/>
    <input name="Email" id="Email" type="hidden" value="{{$info->email}}"/>

    <input name="PostalCode" id="PostalCode" type="hidden" value="{{$info->bank_residence_code}}"/>
    <input name="Telephone" id="YYY" type="hidden" value="{{$info->mobile}}"/>
    <input name="StateProvince" id="StateProvince" type="hidden" value="{{$state}}"/>
    <input name="DateOfBirth" id="DateOfBirth" type="hidden" value="{{date('Y-m-d',strtotime($info->dob))}}"/>

<!-- <input name="SuccessURL" id="SuccessURL" type="hidden" value="https://test.dg-gw.co.uk/orion/tester/TestReturn.aspx"/>
<input name="FailURL" id="FailURL" type="hidden" value="https://test.dg-gw.co.uk/orion/tester/TestReturn.aspx"/>
<input name="CallbackURL" id="CallbackURL" type="hidden" value="https://test.dg-gw.co.uk/orion/tester/TestCallback.ashx"/> -->


<input name="SuccessURL" id="SuccessURL" type="hidden" value="https://secure.one-fx.global/citigate_deposit_success"/>
<input name="FailURL" id="FailURL" type="hidden" value="https://secure.one-fx.global/citigate_deposit_cancel"/>
<input name="CallbackURL" id="CallbackURL" type="hidden" value="https://secure.one-fx.global/citigate_deposit_cancel"/>


<!-- <input name="SuccessURL" id="SuccessURL" type="hidden" value="https://secure.one-fx.global/citigate_deposit_success"/>
<input name="FailURL" id="FailURL" type="hidden" value="https://secure.one-fx.global/citigate_deposit_cancel"/>
<input name="CallbackURL" id="CallbackURL" type="hidden" value="https://secure.one-fx.global/citigate_deposit_cancel"/> -->







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
        <td style="font-weight:bold">Trading Account</td>
        <td>{{$request->deposit_to}}</td>
    </tr>
        <!-- <tr>
            <td style="font-weight:bold">Payment Type</td>
            <td>Citigate</td>
        </tr> -->

        <tr> 
            <td style="font-weight:bold">Amount</td>
            <td>{{$request->amount}} USD</td>
        </tr>

    </table>









    <div class="form-group">
        {!!Form::submit('Continue',['class'=>'btn btn-primary'])!!}
        &nbsp;&nbsp;
        <a href="/citigate_deposit" class="btn btn-primary">Cancel</a>
    </div>
    {!!Form::close()!!}


</div>
</div>






</div>
<!-- /.inner -->
</div>
</div>
</div>
</div>


























@endsection




