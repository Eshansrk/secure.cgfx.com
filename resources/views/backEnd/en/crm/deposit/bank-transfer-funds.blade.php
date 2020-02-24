
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Bank Deposit')
@section ('page-level-css')
<!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="/vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/switchery/css/switchery.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/radio_css/css/radiobox.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/checkbox_css/css/checkbox.min.css" />
    <!--End of Plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="/css/pages/radio_checkbox.css" />
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
    <!--End of Page level styles-->
    <style type="text/css">
    table#bank-table > tbody > tr > td:first-child {
        white-space:nowrap;
    }
</style>
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-money"></i>
                        Deposit Request
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
        <!--top section widgets-->
            <div class="card " style="padding: 20px">
                <div class="row">
                    <div class="col-md-7">
                        <form action="">
                            <label for="">Payment System</label>
                            <input class="form-control" name="disabled" placeholder="Bank Transfer" disabled="disabled" type="text" style="width: 50%">
                            <label for="" style="margin-top: 5%">Account</label>
                            <div class="form-group" style="width: 50%">
                                <select class="form-control item">
                                    <option disabled selected value="">Select</option>
                                    @foreach($accounts as $key => $accounts)
                                    <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" style="margin-top: 5%">Currency <span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Please indicate the currency in which you would like to make your transfer "></i></span></label>

                            <div class="radio">
                                <label>
                                    <input name="o3" class="rad" value="" type="radio">
                                    <span class="cr" style="font-size: 18px;cursor: pointer;" id="hi"><i class="cr-icon fa fa-circle"></i></span>
                                    USD
                                </label>
                            </div>

                            <div class="bank-info" id="printable">
                                
                                
                                <div class="bank-table" >
                                    <table class="table" id="bank-table">
                                        <tbody>
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">BENEFICIARY</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary Name</td>
                                                <td class="left">{{$bank_info->beneficiary_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary Address</td>
                                                <td class="left">{{$bank_info->beneficiary_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary Account</td>
                                                <td class="left">{{$bank_info->beneficiary_account}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary IBAN</td>
                                                <td class="left">{{$bank_info->beneficiary_IBAN}}</td>
                                            </tr>
                                        </tbody>
                                        <tbody style="margin-top: 5%">
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">BENEFICIARY BANK</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary Bank Name</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary Bank Address</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Beneficiary Bank SWIFT</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_swift}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Comment / Reference</td>
                                                <td class="left" id="tr_acc">Trading account</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Transfer details:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Currency:</td>
                                                <td class="left">{{$bank_info->currency}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Fees / Commission:</td>
                                                <td class="left">{{$bank_info->commission}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Processing Time:</td>
                                                <td class="left">{{$bank_info->processing_time}}</td>
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
    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>
@endsection

@section ('page-level-js')
<!--Plugin scripts-->
<script type="text/javascript" src="/vendors/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="/vendors/switchery/js/switchery.min.js"></script>
<!--End of plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="/js/pages/radio_checkbox.js"></script>
<!--End of Page level scripts-->
<!-- end page level scripts -->

<script>
$(document).ready(function(){
    $('select.item').on('change',function(){
        $('#tr_acc').html("Trading account "+$(this).val());
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('#printable').css({'display':'none'});


    $('.item option:selected').val(function(){
       if($('.rad').is(":checked", true)){
        // alert('hi');
        $('#printable').css({'display':'block'});
        $('#bank-info').css({'display':'block'});
       } else{
        $('#printable').css({'display':'none'});
        $('#bank-info').css({'display':'none'});
       }
    });

    $('select.item').on('change',function(){
        if ($(this).val()) {
            if($('.rad').is(":checked", true)){
                $('#printable').css({'display':'block'});
                $('#bank-info').css({'display':'block'});
            }
            else {
                $('#printable').css({'display':'none'});
                $('#bank-info').css({'display':'none'});
            }
        }
    })

    $('.rad').change(function(){
        if ($(".item option:selected").val()) {
            $('#printable').css({'display':'block'});
            $('#bank-info').css({'display':'block'}); 
        }
        else {
            $('#printable').css({'display':'none'});
            $('#bank-info').css({'display':'none'});
        }
    });
    
            
});
</script>
@endsection
