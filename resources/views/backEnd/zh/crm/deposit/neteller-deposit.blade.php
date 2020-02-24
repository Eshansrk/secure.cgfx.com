
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Neteller Deposit')
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
                        Neteller Deposit
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
                                        <li class="first-li selected"> 1. Transfer Details</li>
                                        <li class="second-li"> 2. Confirm Transfer </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- <h2>Neteller Deposit</h2> -->
                            @if(Session::has('msg'))
                            <div class="col-md-12">
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                        </div>
                        @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/neteller_deposit'), 'name' => 'withdrawForm','class'=>'col-md-7','id'=>'netellerForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('deposit_to', 'Deposit to *') !!}
                            <select name="deposit_to" class="form-control input-lg"  id="deposit-to-select">
                            <option value="">Select Trading Account</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('deposit_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        
                            {!! Form::label('amount', 'Amount to Deposit *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Enter Amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        
                        <div class="form-group show-form">
                        
                            {!! Form::label('account', 'Neteller Account Id *') !!}
                        {!! Form::text('account', null, ['class' => 'form-control input-lg','placeholder' => 'Enter Account Id']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                       

                        <div class="form-group show-form">
                        
                            {!! Form::label('secure_id', 'Neteller Secure Id *') !!}
                        {!! Form::text('secure_id', null, ['class' => 'form-control input-lg', 'placeholder' => 'Enter Neteller Secure Id']) !!}
                        <small class="text-danger">{{ $errors->first('secure_id') }}</small>
                        </div>

                        <div class="form-group show-form">
                        {!!Form::button('Deposit',['class'=>'btn btn-primary transfer-button'])!!}
                        </div>
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
        <thead>
          <tr>
            <td colspan="2" style="text-align: left;"><b>Please confirm the details below and pay</b></td>
          </tr></thead>
          <tr>
            <td style="font-weight:bold">Deposit to</td>
            <td class="deposit-to"></td>
          </tr>
      <tr>
            <td style="font-weight:bold">Amount to Deposit</td>
            <td class="amount-deposit"></td>
          </tr>
        <tr>
            <td style="font-weight:bold">Neteller Account ID</td>
            <td class="account-id"></td>
          </tr>
         
       
       </table>
                            <br>
                            {{-- {!!Form::button('Confirm',['class'=>'btn btn-primary transfer-button','type'=>'button'])!!} --}}
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary transfer-button'])!!}
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
                                                <td class="left">Instant</td>
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
        //form validation
        $('#netellerForm').validate({
            rules:{
                deposit_to: "required",
                secure_id: "required",
                amount: "required amount",
                account:"required",
                net_amount:"required"
            },
            messages:{
                transfer_from: 'Select Trading Account',
                transfer_to: 'Select Trading Account',
                amount: 'Enter valid Amount'
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
                $('.deposit-to').html($('#deposit-to-select').val());
                $('.amount-deposit').html($('#amount').val());
                $('.account-id').html($('#account').val());
               
            }
           });
    
        
    });
</script>
@endsection





