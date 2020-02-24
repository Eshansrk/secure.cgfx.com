@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '存款申请')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
<link type="text/css" rel="stylesheet" href="/vendors/switchery/css/switchery.min.css" />
<link type="text/css" rel="stylesheet" href="/vendors/radio_css/css/radiobox.min.css" />
<link type="text/css" rel="stylesheet" href="/vendors/checkbox_css/css/checkbox.min.css" />
<link type="text/css" rel="stylesheet" href="/css/pages/radio_checkbox.css" />
<link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
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
                        存款申请
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card " style="padding: 20px">
                <div class="row">
                    <div class="col-md-7">
                        <form action="">
                            <label for="">支付系统</label>
                            <input class="form-control" name="disabled" placeholder="Bank Transfer" disabled="disabled" type="text" style="width: 50%">
                            <label for="" style="margin-top: 5%">账户</label>
                            <div class="form-group" style="width: 50%">
                                <select class="form-control item">
                                    <option disabled selected value="">选择</option>
                                    @foreach($accounts as $key => $accounts)
                                    <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" style="margin-top: 5%">币种 
                                <span class="bank-span">
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="请说明您希望转帐的货币"></i>
                                </span>
                            </label>
                            <div class="radio">
                                <label>
                                    <input name="o3" class="rad" value="" type="radio">
                                    <span class="cr" style="font-size: 18px;cursor: pointer;" id="hi">
                                        <i class="cr-icon fa fa-circle"></i>
                                    </span>
                                    USD
                                </label>
                            </div>
                            <div class="bank-info" id="printable">
                                
                                <div class="bank-table" >
                                    <table class="table" id="bank-table">
                                        <tbody>
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">受益人</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">受益人姓名</td>
                                                <td class="left">{{$bank_info->beneficiary_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">受益人地址</td>
                                                <td class="left">{{$bank_info->beneficiary_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">受益人帐户</td>
                                                <td class="left">{{$bank_info->beneficiary_account}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">受益人IBAN</td>
                                                <td class="left">{{$bank_info->beneficiary_IBAN}}</td>
                                            </tr>
                                        </tbody>
                                        <tbody style="margin-top: 5%">
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">收款银行</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">收款银行名称</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">收款银行地址</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">受益银行SWIFT</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_swift}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">评论/参考</td>
                                                <td class="left" id="tr_acc">交易账户</td>
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
                                <h5>转账细节:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">币种:</td>
                                                <td class="left">{{$bank_info->currency}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">费用/佣金:</td>
                                                <td class="left">{{$bank_info->commission}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">处理时间:</td>
                                                <td class="left">{{$bank_info->processing_time}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> 不接受第三方付款。汇款人的姓名必须与您的交易账户名称一致。</li>
                                    <li> {{$general_info->company_name}} 接受美元电汇。以其他货币发送的资金将转换为您账户的存款货币。您可能需要支付转换费</li>
                                    <li> 汇款银行或代理行可以扣除处理电汇的费用。 {{$general_info->company_name}} 不收取任何费用，并将收到的净金额存入您的账户。</li>
                                    <li>  .如果交易完成，资金将在{{$general_info->company_name}}收到后存入到您的交易账户。处理时间一般为3-5个工作日。如果银行或{{$general_info->company_name}}无法验证您的信息，可能会有延迟。请保存您的银行电汇确认，以便我们在必要时查看所有详细信息。</li>
                                    <li>通过电汇存入的资金可以提取到您名下的任何银行账户</li>
                                    <li>资金的来源应与资金的转出接收方相同。您的取款接受账户只能与您最初存入的账户相同</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
</div>
</div>
</div>
@endsection
@section ('page-level-js')
<script type="text/javascript" src="/vendors/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="/vendors/switchery/js/switchery.min.js"></script>
<script type="text/javascript" src="/js/pages/radio_checkbox.js"></script>

<script>
    $(document).ready(function(){
        $('select.item').on('change',function(){
            $('#tr_acc').html("Trading account "+$(this).val());
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('#printable').css({'display':'none'});
        $('.item option:selected').val(function(){
           if($('.rad').is(":checked", true)){
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