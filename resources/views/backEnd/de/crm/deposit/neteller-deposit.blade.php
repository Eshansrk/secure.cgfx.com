
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Neteller Anzahlung')
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
                        Neteller Anzahlung
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
                            
                            <!-- <h2>Neteller Anzahlung</h2> -->
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
                        
                            {!! Form::label('deposit_to', 'Einzahlung an *') !!}
                            <select name="deposit_to" class="form-control input-lg"  id="deposit-to-select">
                            <option value="">Wählen Sie Handelskonto</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('deposit_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        
                            {!! Form::label('amount', 'Betrag zur Einzahlung *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Geben Sie den Betrag ein']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        
                        <div class="form-group show-form">
                        
                            {!! Form::label('account', 'Neteller-Konto-ID *') !!}
                        {!! Form::text('account', null, ['class' => 'form-control input-lg','placeholder' => 'Geben Sie die Kontonummer ein']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                       

                        <div class="form-group show-form">
                        
                            {!! Form::label('secure_id', 'Neteller Sichere ID *') !!}
                        {!! Form::text('secure_id', null, ['class' => 'form-control input-lg', 'placeholder' => 'Geben Sie Neteller Secure ID ein']) !!}
                        <small class="text-danger">{{ $errors->first('secure_id') }}</small>
                        </div>

                        <div class="form-group show-form">
                        {!!Form::button('Anzahlung',['class'=>'btn btn-primary transfer-button'])!!}
                        </div>
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
        <thead>
          <tr>
            <td colspan="2" style="text-align: left;"><b>Bitte bestätigen Sie die Details unten und zahlen Sie</b></td>
          </tr></thead>
          <tr>
            <td style="font-weight:bold">Accountnummer</td>
            <td class="deposit-to"></td>
          </tr>
      <tr>
            <td style="font-weight:bold">Menge</td>
            <td class="amount-deposit"></td>
          </tr>
        <tr>
            <td style="font-weight:bold">Neteller-Konto-ID</td>
            <td class="account-id"></td>
          </tr>
         
       
       </table>
                            <br>
                            {{-- {!!Form::button('Confirm',['class'=>'btn btn-primary transfer-button','type'=>'button'])!!} --}}
                            {!!Form::submit('Bestätigen',['class'=>'btn btn-primary transfer-button'])!!}
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
                amount: "required",
                account:"required",
                net_amount:"required"
            },
            messages:{
                deposit_to: "Wählen Sie Handelskonto",
                secure_id: "Dieses Feld wird benötigt",
                amount: "Geben Sie den gültigen Betrag ein",
                account:"Dieses Feld wird benötigt",
                net_amount:"Dieses Feld wird benötigt"
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





