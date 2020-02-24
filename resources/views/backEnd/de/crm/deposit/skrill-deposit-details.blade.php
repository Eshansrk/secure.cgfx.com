
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Skrill Anzahlung')
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
                        Skrill Anzahlung
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class="card">

            <div class="vogloader" style=" position: absolute;
            display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 100000;
        backface-visibility: hidden;
        background: #ffffff;">
        <div class="vogloader_img" style="max-width: 120%; height:auto;
        position: absolute;
        left: 46%;
        top: 23%;
        background-position: center;
        z-index: 999999">
        <img src="/loader.gif" style=" width: 50px;" alt="loading...">
    </div>
</div>
            <div id="sub3">
<iframe id="vogframe" src="about:blank" name="myFrame" width="100%" height="800px" scrolling="auto" frameborder="0" style="display:none;" ></iframe>
</div>

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
                            
                            
                            {!! Form::open(['method' => 'POST', 'url' => 'https://pay.skrill.com?action=status_trn', 'name' => 'withdrawForm', 'id' => 'withdrawForm','class'=>'col-md-6','target'=>'myFrame']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            
                                    
        <input type="hidden" name="pay_to_email" value="ovy.rahman@gmail.com">
        <input type="hidden" name="transaction_id" value="{{$reference}}">
        <input type="hidden" name="return_url" value="{{config('app.url')}}/skrill_deposit_success">
       
        <input type="hidden" name="cancel_url" value="{{config('app.url')}}/skrill_deposit_cancel">
       
        <input type="hidden" name="status_url" value="{{config('app.url')}}/{{app()->getLocale()}}/skrill_deposit_status">
        <input type="hidden" name="dynamic_descriptor" value="Descriptor">
        <input type="hidden" name="language" value="EN">
        <input type="hidden" name="confirmation_note" value="Thanks for depositing fund into your account">
        <input type="hidden" name="pay_from_email" value="{{session('login_email')}}">
        <input type="hidden" name="amount" value="{{$request->amount}}">
        <input type="hidden" name="currency" value="USD">
        <input type="hidden" name="amount2_description" value="Deposit:">
        <input type="hidden" name="amount2" value="{{$request->amount}} USD">
        <input type="hidden" name="detail1_description" value="Account No:">
        <input type="hidden" name="detail1_text" value="{{$request->deposit_to}}">
        <input type="hidden" name="detail2_description" value="Company:">
        <input type="hidden" name="detail2_text" value="GIC Markets Ltd">
        <input type="hidden" name="detail4_description" value="Special Conditions:">
        <input type="hidden" name="detail4_text" value="3-4 business hours for funding to be affected in account">
        <input type="hidden" name="rec_period" value="1">
        <input type="hidden" name="rec_grace_period" value="1">
        <input type="hidden" name="rec_cycle" value="day">
        <input type="hidden" name="ondemand_max_currency" value="USD">
        <input type="hidden" name="merchant_fields" value="account_no,email">
        <input type="hidden" name="account_no" value="{{$request->deposit_to}}">
        <input type="hidden" name="email" value="{{session('login_email')}}">
                            
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
            <td>Skrill</td>
          </tr>
          
          <tr> 
            <td style="font-weight:bold">Menge</td>
            <td>{{$request->amount}} USD</td>
          </tr>
       
       </table>
                            <br>
                            {!!Form::submit('Bestätigen',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
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
<script type="text/javascript">
    $(document).on('submit','#withdrawForm',function(){
        $('.vogloader').show();
        $('.vogloader img').show();
        $('#vogframe').on("load", function() {
            $('.card-block').hide();
    $('.vogloader').fadeOut();
        $('.vogloader img').fadeOut();
        
        $('#vogframe').fadeIn();
});
    });
    
    
</script>
@endsection








