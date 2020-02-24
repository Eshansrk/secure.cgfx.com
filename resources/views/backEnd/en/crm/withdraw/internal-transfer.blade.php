
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Internal Transfer')
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
                        Internal Transfer
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
                            <!-- <div class="row">
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
                            </div> -->
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
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                        </div>
                        @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/internal-transfer'), 'name' => 'withdrawForm','class'=>'col-md-8','id'=>'netellerForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('transfer_from', 'Transfer From *') !!}
                            <select name="transfer_from" class="form-control input-lg "  id="transfer_from">
                            <option value="">Select Trading Account</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>

                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                         <div class="form-group show-form">
                        
                            {!! Form::label('transfer_to', 'Transfer to *') !!}
                            <select name="transfer_to" class="form-control input-lg" id="transfer_to">
                            <option value="">Select Trading Account</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        <!-- <p style="text-align: justify;">When carrying out non-trading operations between accounts with different deposit currencies, a conversion will take place according to the <a href="" style="color: green">Company exchange rates</a> on the day the funds are credited to Forex Time's account.</p> -->
                            {!! Form::label('amount', 'Amount to Transfer *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Enter Amount','onkeyup'=>'calculatenet()','name' => 'amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        <div class="form-group">
                        {!!Form::button('Transfer',['class'=>'btn btn-primary transfer-button show-form','type'=>'button'])!!}
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
                                <h5>Transfer details:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Currency:</td>
                                                <td class="left">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Transfer from</td>
                                                <td class="left" id="trFrom"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Transfer to</td>
                                                <td class="left" id="trTo"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Amount</td>
                                                <td class="left" id="trAmount"></td>
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
                transfer_from: {required:'Select Trading Account'},
                transfer_to: {required:'Select Trading Account'},
                amount: {required:'Enter Valid Amount'},
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




