
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Interner Transfer')
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
                        Interner Transfer
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
                                        <a href="#">Zeig mir wie</a>
                                        <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="show-transfer-hide">
                                        <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                        <span>Wie man Konto öffnet Transfer</span>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected"> 1.Details übertragen</li>
                                        <li class="second-li"> 2.Übertragung bestätigen</li>
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
                        
                            {!! Form::label('transfer_from', 'Übertragen von *') !!}
                            <select name="transfer_from" class="form-control input-lg "  id="transfer_from">
                            <option value="">Wählen Sie Handelskonto</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>

                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                         <div class="form-group show-form">
                        
                            {!! Form::label('transfer_to', 'Übertragen an *') !!}
                            <select name="transfer_to" class="form-control input-lg" id="transfer_to">
                            <option value="">Wählen Sie Handelskonto</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        <!-- <p style="text-align: justify;">Bei Transaktionen außerhalb des Handels zwischen Konten mit unterschiedlichen Einzahlungswährungen erfolgt eine Umrechnung gemäß den Wechselkursen der Gesellschaft an dem Tag, an dem die Gelder dem Konto von Forex Time gutgeschrieben werden.</p> -->
                            {!! Form::label('amount', 'Betrag zum überweisen *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Geben Sie den Betrag ein','onkeyup'=>'calculatenet()','name' => 'amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        <div class="form-group">
                        {!!Form::button('Überweisung ein',['class'=>'btn btn-primary transfer-button show-form','type'=>'button'])!!}
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
                                    <td style="font-weight:bold">Übertragen an *</td>
                                    <td class="amount-withdraw"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight:bold">Betrag</td>
                                    <td class="amount"></td>
                                  </tr>

                                  
                               
                               </table>
                            <br>
                            {!!Form::submit('Bestätigen',['class'=>'btn btn-primary transfer-button','type'=>'button'])!!}
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
                                                <td class="left">Währung:</td>
                                                <td class="left">USD</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Übertragen von</td>
                                                <td class="left" id="trFrom"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Übertragen an</td>
                                                <td class="left" id="trTo"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Betrag</td>
                                                <td class="left" id="trAmount"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> Zahlungen von Dritten werden nicht akzeptiert. Der Name des Absenders muss mit dem Namen in Ihrem Handelskonto übereinstimmen.</li>
                                    <li> {{$general_info->company_name}} akzeptiert Überweisungen in USD. Gelder, die in einer anderen Währung gesendet werden, werden in die Einzahlungswährung Ihres Kontos konvertiert. Sie können für die Konvertierung in Rechnung gestellt werden.</li>
                                    <li> Die sendende Bank oder Korrespondenzbank kann eine Gebühr für die Bearbeitung einer Überweisung abziehen. {{$general_info->company_name}} gilt nicht für irgendwelche Gebühren.</li>
                                    <li>  Wenn die Transaktion ausgeführt wird, werden die Gelder nach Eingang bei {{$general_info->company_name}} auf Ihrem Handelskonto gebucht. Die Bearbeitungszeit beträgt in der Regel 3-5 Werktage. Es kann zu einer Verzögerung kommen, wenn die Bank oder {{$general_info->company_name}} Ihre Informationen nicht bestätigen kann. Bitte speichern Sie Ihre Bankverbindung, damit wir alle Details überprüfen können.</li>
                                    <li> Gelder, die per Überweisung eingezahlt werden, können auf jedes Bankkonto in Ihrem Namen ausgezahlt werden.</li>
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

@section('page-level-js')

<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('select').change(function() {

    var value = $(this).val();

    $('select').not(this).children('option').each(function() {
        if ( $(this).val() === value ) {
            $(this).attr('disabled', true).siblings().removeAttr('disabled');   
        }
    });

    });
});
 
</script>
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
                transfer_from: {required : 'Wählen Sie Handelskonto'},
                transfer_to: {required : 'Wählen Sie Handelskonto'},
                amount: {required : 'Geben Sie den gültigen Betrag ein'}
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




