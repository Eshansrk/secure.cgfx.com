
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Visa / Master Kart Anzahlung')
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
                        Visa / Master Kart Anzahlung
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
                                        <li class="first-li selected"> 1. Details der Übertragung</li>
                                        <li class="second-li"> 2. Übertragung bestätigen</li>
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
            <td colspan="2" style="text-align: left;"><b>Bitte bestätigen Sie die Details unten und zahlen Sie</b></td>
          </tr></thead>
          <tr>
            <td style="font-weight:bold">Referenznummer</td>
            <td>{{$reference}}</td>
          </tr>
      <tr>
            <td style="font-weight:bold">Accountnummer</td>
            <td>{{$request->deposit_to}}</td>
          </tr>
        <tr>
            <td style="font-weight:bold">Zahlungsart</td>
            <td>Visa / Master Kart</td>
          </tr>
          
          <tr> 
            <td style="font-weight:bold">Menge</td>
            <td>{{$request->amount}} USD</td>
          </tr>
       
       </table>
                            <br>
                            <input type="submit" value="Bestätigen" class="btn btn-primary">
                        </div>
                        </form>
                        <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Einzahlungsdetails:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Währung:</td>
                                                <td class="left">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Gebühren / Kommission:</td>
                                                <td class="left">Keine Kommission</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Bearbeitungszeit:</td>
                                                <td class="left">sofort</td>
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
                                    <li> Wenn die Transaktion ausgeführt wird, werden die Gelder nach Erhalt von {{$general_info->company_name}} auf Ihr Handelskonto gebucht.</li>
                                    <li> Gelder, die per Überweisung eingezahlt werden, können auf ein Bankkonto in Ihrem Namen eingezogen werden.</li>
                                    <li> Die Quelle der eingehenden Mittel sollte die gleiche sein wie die ausgehenden Mittel. In diesem Zusammenhang kann der Einzug Ihrer Einzahlung nur auf dasselbe Konto erfolgen, von dem Sie ursprünglich eingezahlt haben.</li>
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








