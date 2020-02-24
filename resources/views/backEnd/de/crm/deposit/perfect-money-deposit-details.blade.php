
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Perfect Money Deposit Details')
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
                        Perfect Money Deposit Details
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
                            <h2>Perfect Money Deposit Details</h2>
                            @if(Session::has('msg'))
                            <div class="col-md-12">
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                        </div>
                        @endif
                            {!! Form::open(['method' => 'POST', 'url' => 'http://perfectmoney.is/api/step1.asp', 'name' => 'withdrawForm','class'=>'col-md-6','id'=>'']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            
                                    
        
        


        <input type="hidden" name="PAYEE_ACCOUNT" value="U7493427">
                        <input type="hidden" name="PAYEE_NAME" value="Limited">
                        <input type="hidden" name="PAYMENT_ID" value="{{$reference}}">
                        <input type="hidden" name="PAYMENT_AMOUNT" value="{{$request->amount}}">
                        <input type="hidden" name="PAYMENT_UNITS" value="USD">
                        <input type="hidden" name="STATUS_URL" value="http://demo-client-crm.netcoden.com/perfect_money_deposit_status">
                        <input type="hidden" name="PAYMENT_URL" value="http://demo-client-crm.netcoden.com/perfect_money_deposit_success">
                        <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
                        <input type="hidden" name="NOPAYMENT_URL" value="http://demo-client-crm.netcoden.com/perfect_money_deposit_cancel">
                        <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
                        <input type="hidden" name="SUGGESTED_MEMO" value="">
                        <input type="hidden" name="BAGGAGE_FIELDS" value="">
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
           
      
                        
                            

                        

                        
                        
                        <div class="form-group">
                        {!!Form::submit('Confirm',['class'=>'btn btn-primary'])!!}
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




