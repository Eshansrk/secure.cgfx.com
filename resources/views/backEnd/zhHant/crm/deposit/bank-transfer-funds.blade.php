
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '入金 請求')
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
                        入金 請求
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
                            <label for="">支付方法</label>
                            <input class="form-control" name="disabled" placeholder="Bank Transfer" disabled="disabled" type="text" style="width: 50%">
                            <label for="" style="margin-top: 5%">帳戶</label>
                            <div class="form-group" style="width: 50%">
                                <select class="form-control item">
                                    <option disabled selected value="">選擇</option>
                                    @foreach($accounts as $key => $accounts)
                                    <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" style="margin-top: 5%">匯率 <span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Please indicate the currency in which you would like to make your transfer "></i></span></label>

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
                                                    <h5 style="font-weight: 600">公司</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司名稱</td>
                                                <td class="left">{{$bank_info->beneficiary_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司地址</td>
                                                <td class="left">{{$bank_info->beneficiary_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司帳戶</td>
                                                <td class="left">{{$bank_info->beneficiary_account}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司IBAN</td>
                                                <td class="left">{{$bank_info->beneficiary_IBAN}}</td>
                                            </tr>
                                        </tbody>
                                        <tbody style="margin-top: 5%">
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">公司 銀行</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司收款銀行名稱</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司收款銀行地址</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">公司收款銀行SWIFT</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_swift}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">評論 / 參考</td>
                                                <td class="left" id="tr_acc">實盤帳戶</td>
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
                                <h5>轉帳 詳情:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">匯率:</td>
                                                <td class="left">{{$bank_info->currency}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">手續費:</td>
                                                <td class="left">{{$bank_info->commission}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">處理時間:</td>
                                                <td class="left">{{$bank_info->processing_time}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> 不接受第三方付款。發送方的名稱必須與您交易帳戶上的名稱匹配。</li>
                                    <li> {{$general_info->company_name}} 接受美元電匯。以不同貨幣發送的資金將轉換為您帳戶的存款貨幣。轉換時可能會收取費用。</li>
                                    <li> 發送行或代理行可扣除電匯手續費。 {{$general_info->company_name}} 不收取任何費用，並將收到的淨金額存入您的帳戶。</li>
                                    <li>  如果交易完成，資金將在 {{$general_info->company_name}} 收到後發佈到您的交易賬戶. 處理時間一般為3-5個工作日。 如果銀行或 {{$general_info->company_name}} 無法驗證您的信息，可能會有延遲。 請保存您的銀行電匯確認，以便我們在必要時查看所有詳細信息。</li>
                                    <li>   以電匯方式存入的資金可以以您的名義存入任何銀行帳戶。</li>
                                    <li>   資金的流入來源應與資金的流出來源相同。在這方面，您的存款只能選取到您原來存入的同一帳戶。</li>
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
