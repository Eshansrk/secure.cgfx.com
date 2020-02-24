
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Perfect Money Withdraw')
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
                        Perfektes Geld Abheben
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="show-transfer">
                                <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                                <a href="#">Zeig mir wie</a>
                                <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                            </div>
                            <div class="show-transfer-hide">
                                <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                <span>Wie man eine interne Übertragung vornimmt</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="up-barcurb">
                                <li class="first-li selected"> 1.Details übertragen</li>
                                <li class="second-li"> 2.Übertragung bestätigen </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <h2>Perfect Money Withdraw</h2> -->
                    {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/perfect_money_withdraw'), 'name' => 'withdrawForm','class'=>'col-md-7','id'=>'perfectMoneyForm']) !!}
                    @if($errors->any())
                    <h4 style="color:red;">{{$errors->first()}}</h4>
                    @endif
                    <div class="form-group show-form">
                        
                        {!! Form::label('transfer_from', 'Übertragen von *') !!}
                        <select name="transfer_from" class="form-control input-lg"  id="transfer_from">
                            <option value="">Wählen Sie Handelskonto</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->acc_no}} {{$account->balance}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                    </div>
                    <div class="form-group show-form">
                        
                        {!! Form::label('amount', 'Betrag, der abgehoben werden muss *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Geben Sie den Betrag in USD ein','onchange'=>'calculatenet()']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                    </div>

                    <div class="form-group show-form">
                        
                        {!! Form::label('net_amount', 'Netto-Betrag') !!}
                        {!! Form::text('net_amount', null, ['class' => 'form-control input-lg','id'=>'net_amount', 'readonly'=>'readonly']) !!}
                        <small class="text-danger">{{ $errors->first('net_amount') }}</small>
                    </div>

                    
                    <div class="form-group show-form">
                        
                        {!! Form::label('account', 'Perfekte Geldkonto-ID *') !!}
                        {!! Form::text('account', null, ['class' => 'form-control input-lg',  'placeholder' => 'Geben Sie die Kontonummer ein']) !!}
                        <small class="text-danger">{{ $errors->first('account') }}</small>
                    </div>

                    <div class="form-group show-form">
                        
                        {!! Form::label('email', 'Perfekte Geld Email *') !!}
                        {!! Form::email('email', null, ['class' => 'form-control input-lg',  'placeholder' => 'Geben Sie die perfekte E-Mail-Adresse ein']) !!}
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>

                    <div class="form-group">
                        {!!Form::button('Withdraw',['class'=>'btn btn-primary transfer-button show-form'])!!}
                    </div>
                    <div class="form-group hide-form">
                        <table class="table table-bordered ">
                            <thead>
                              <tr>
                                <td colspan="2" style="text-align: left;"><b>Bitte bestätigen Sie die Details unten und zahlen Sie</b></td>
                            </tr>
                        </thead>
                        <tr>
                            <td style="font-weight:bold">Übertragen von *</td>
                            <td class="deposit-from"></td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Betrag, der abgehoben werden muss *</td>
                            <td class="amount-withdraw"></td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold">Netto-Betrag</td>
                            <td class="amount"></td>
                        </tr>

                        

                        <tr>
                            <td style="font-weight:bold">Perfekte Geld Email *</td>
                            <td class="email"></td>
                        </tr>
                        
                        
                    </table>
                    <br>
                    {!!Form::submit('Confirm',['class'=>'btn btn-primary transfer-button'])!!}
                </div>
                {!!Form::close()!!}
                <div class="col-md-5">
                        <h5>Details zur Einzahlung:</h5>
                        <div class="bank-table">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="left">Währung:</td>
                                        <td class="left">USD</td>
                                    </tr>
                                    <tr>
                                        <td class="left">Gebühren / Kommission:</td>
                                        <td class="left">Kommission (2.5%)</td>
                                    </tr>
                                    <tr>
                                        <td class="left">Bearbeitungszeit:</td>
                                        <td class="left">3-5 Arbeitstage</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bank-info" style="padding: 0">
                            <ol>
                                <li> Zahlungen von Dritten werden nicht akzeptiert. Der Name des Absenders muss mit dem Namen in Ihrem Handelskonto übereinstimmen.</li>
                                <li> {{$general_info->company_name}} akzeptiert Überweisungen in USD. Gelder, die in einer anderen Währung gesendet werden, werden in die Einzahlungswährung Ihres Kontos konvertiert. Ihnen wird möglicherweise eine Gebühr für die Umstellung in Rechnung gestellt.</li>
                                <li> Die sendende Bank oder Korrespondenzbank kann eine Gebühr für die Bearbeitung einer Überweisung abziehen. {{$general_info->company_name}} erhebt keine Gebühren und hinterlegt auf Ihrem Konto den erhaltenen Nettobetrag.</li>
                                <li>  Wenn die Transaktion ausgeführt wird, werden die Gelder nach Eingang bei Ihrem Handelskonto gebucht {{$general_info->company_name}}. Die Bearbeitungszeit beträgt in der Regel 3-5 Werktage. Es kann eine Verzögerung geben, wenn die Bank oder {{$general_info->company_name}} kann Ihre Daten nicht verifizieren. Bitte speichern Sie Ihre Banküberweisung, damit wir alle Details überprüfen können.</li>
                                <li>   Mit Überweisung eingezahlte Gelder können auf ein Bankkonto in Ihrem Namen eingezogen werden.</li>
                                <li>   Die Quelle der eingehenden Mittel sollte die gleiche sein wie die ausgehenden Mittel. In diesem Zusammenhang kann der Einzug Ihrer Einzahlung nur auf dasselbe Konto erfolgen, von dem Sie ursprünglich eingezahlt haben.</li>
                            </ol>
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



<script>
    function calculatenet(){
      var amt = document.getElementById('amount').value;
      var total = (amt*2.5)/100;
      var total1 = amt - total;
      total1= Math.round(total1 * 100) / 100;
      document.getElementById('net_amount').value = total1;

      
  }
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
        $('#perfectMoneyForm').validate({
            rules:{
                transfer_from: "required",
                net_amount: "required",
                amount: "required amount",
                email: "required",
                account: "required"
            },
            messages:{
                transfer_from: 'Select Trading Account',
                // transfer_to: 'Select Trading Account',
                amount: 'Enter valid Amount'
            }

        });

        //form validity check and next
        $('.hide-form').hide();
        
        $('.transfer-button').click(function(){
         if($('#perfectMoneyForm').valid()==true) {
            $('.first-li').removeClass('selected');
            $('.second-li').addClass('selected');
            $('.hide-form').show(500);
            $('.show-form').hide(300);
            $('.deposit-from').html($('#transfer_from').val());
            $('.amount-withdraw').html($('#amount').val());
            $('.amount').html($('#net_amount').val());
            $('.email').html($('#email').val());
        }
    });
        
        
    });
</script>
@endsection





