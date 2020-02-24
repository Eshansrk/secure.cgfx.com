
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Bank Transfers')
@section ('page-level-css')
<!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="/vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/switchery/css/switchery.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/radio_css/css/radiobox.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/checkbox_css/css/checkbox.min.css" />
    <!--End of Plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="/css/pages/radio_checkbox.css" />
    
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
                        Bank Transfers
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
                            <label for="">Bezahlsystem</label>
                            <input class="form-control" name="disabled" placeholder="Bank Transfer" disabled="disabled" type="text" style="width: 50%">
                            <label for="" style="margin-top: 5%">Konto</label>
                            <div class="form-group" style="width: 50%">
                                <select class="form-control item">
                                    <option disabled selected value="">Wählen</option>
                                    @foreach($accounts as $key => $accounts)
                                    <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" style="margin-top: 5%">Währung <span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title=" "></i></span></label>

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
                                                <td class="left">Währung:</td>
                                                <td class="left">{{$bank_info->currency}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Gebühren / Kommission:</td>
                                                <td class="left">{{$bank_info->commission}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Bearbeitungszeit:</td>
                                                <td class="left">{{$bank_info->processing_time}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> Zahlungen von Dritten werden nicht akzeptiert. Der Name des Absenders muss mit dem Namen in Ihrem Handelskonto übereinstimmen.</li>
                                    <li> {{$general_info->company_name}} akzeptiert Überweisungen in USD. Gelder, die in einer anderen Währung gesendet werden, werden in die Einzahlungswährung Ihres Kontos konvertiert. Ihnen wird möglicherweise eine Gebühr für die Umstellung in Rechnung gestellt.</li>
                                    <li> Die sendende Bank oder Korrespondenzbank kann eine Gebühr für die Bearbeitung einer Überweisung abziehen. {{$general_info->company_name}} erhebt keine Gebühren und wird den erhaltenen Nettobetrag auf Ihr Konto einzahlen.</li>
                                    <li> Wenn die Transaktion ausgeführt wird, werden die Gelder nach Erhalt von {{$general_info->company_name}} auf Ihr Handelskonto gebucht. Die Bearbeitungszeit beträgt in der Regel 3-5 Werktage. Es kann zu einer Verzögerung kommen, wenn die Bank oder {{$general_info->company_name}} Ihre Informationen nicht bestätigen kann. Bitte speichern Sie Ihre Banküberweisung, damit wir alle Details überprüfen können.</li>
                                    <li> Gelder, die per Überweisung eingezahlt werden, können auf ein Bankkonto in Ihrem Namen eingezogen werden.</li>
                                    <li> Die Quelle der eingehenden Mittel sollte die gleiche sein wie die ausgehenden Mittel. In diesem Zusammenhang kann der Einzug Ihrer Einzahlung nur auf dasselbe Konto erfolgen, von dem Sie ursprünglich eingezahlt haben.</li>
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
