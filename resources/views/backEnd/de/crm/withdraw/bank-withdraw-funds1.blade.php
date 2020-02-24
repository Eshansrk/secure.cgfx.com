
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Bank Withdraw')
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
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-money"></i>
                        Anfrage zurückziehen
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
                        {!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/bank-withdraw-funds'), 'name' => 'bankForm','class'=>'col-md-10','id'=>'bankWithdrawFunds']) !!}

                        @if($errors->any())
                        <h4 style="color:red;">{{$errors->first()}}</h4>
                        @endif

                        {{csrf_field()}}

                        @if(Session::has('success'))
                        <span class="text-success">
                            {{Session::get('success')}}
                        </span>
                        @endif

                        
                        <label for="payment_system">Bezahlsystem</label>
                        <input class="form-control" name="payment_system" placeholder="Bankbezahlung" disabled="disabled" type="text" style="width: 50%">
                        <label for="" style="margin-top: 5%">Konto</label>
                        <div class="form-group" style="width: 50%">
                            <select class="form-control item" name="transfer_from">
                                <option disabled selected value="">Wählen</option>
                                @foreach($accounts as $key => $accounts)
                                <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="" style="margin-top: 5%">Währung <span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Bitte geben Sie die Währung an, in der Sie Ihre Überweisung tätigen möchten "></i></span></label>

                        <div class="radio">
                            <label>
                                <input name="currency" class="rad" value="USD" type="radio">
                                <span class="cr" style="font-size: 18px;cursor: pointer;" id="hi"><i class="cr-icon fa fa-circle"></i></span>
                                USD
                            </label>
                        </div>

                        <div class="bank-info" id="bank-info">


                            
                                <div class="form-group col-md-12">

                                    {!! Form::label('amount', 'Betrag zum Zurückziehen *') !!}
                                    {!! Form::text('amount', '', ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Menge eingeben']) !!}
                                    
                                </div>
                          

                            <div class="form-group col-md-6">
                                
                                    {!! Form::label('bank_acc_name', 'Kontoname *') !!}
                                    {!! Form::text('bank_acc_name', $info->bank_acc_name, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Geben Sie den Namen des Bankkontos ein']) !!}
                                    
                                
                            </div>
                            
                                <div class="col-md-6 form-group">

                                    {!! Form::label('bank_acc_num', 'Kontonummer (IBAN) *') !!}
                                    {!! Form::text('bank_acc_num', $info->bank_acc_num, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Geben Sie die Bankkontonummer ein']) !!}
                                    
                                </div> 
                           

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_name', 'Bank Name *') !!}
                                {!! Form::text('bank_name', $info->bank_name, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Namen']) !!}
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_country', 'Bankland *') !!}

                                <select name="bank_residence_country" id="country" class="form-control" required="required">
                                    <option selected="selected" disabled="disabled">Bankland *</option>
                                    @foreach($countries as $country)
                                    <option id="{{$country->countries_id}}" value="{{$country->countries_name}}" {{($info->bank_residence_country==$country->countries_name)?'selected="selected"':''}}>{{$country->countries_name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            <div class="clearfix"></div>


                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_state', 'Bundesland *') !!}

                                <select name="bank_residence_state" id="state" class="form-control" required="required">

                                </select>

                                <!--  {!! Form::text('bank_residence_state', $info->bank_residence_state, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank State Province']) !!} -->
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_city', 'Stadt *') !!}
                                <select name="bank_residence_city" id="city" class="form-control" required="required">

                                </select>

                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_code', 'Postleitzahl *') !!}
                                {!! Form::text('bank_residence_code', $info->bank_residence_code, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Geben Sie die Bank-Postleitzahl ein']) !!}
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('swift_num', 'Bank SWIFT-Code *') !!}
                                {!! Form::text('swift_num', $info->swift_num, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank SWIFT-Code']) !!}
                                
                            </div>


                            <div class="form-group col-md-12">

                                {!! Form::label('bank_address', 'Bankadresse *') !!}
                                {!! Form::textarea('bank_address', $info->bank_address, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Geben Sie die Bankadresse ein']) !!}
                                
                            </div>




                            <div class="form-group col-md-12">
                                {!!Form::submit('Withdraw',['class'=>'btn btn-primary'])!!}
                            </div>
                            {!!Form::close()!!}
                        </div>

                    </form>
                </div>


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
<script type="text/javascript">

    var selected_state=<?php echo json_encode($info->bank_residence_state, JSON_HEX_TAG); ?>;
    var selected_city=<?php echo json_encode($info->bank_residence_city, JSON_HEX_TAG); ?>;


    var id=$('option:selected', '#country').attr('id');
    $.ajax({
        url: "{{LaravelLocalization::localizeURL('/get-states')}}",
        type:'post',
        data:{
            _token:$('input[name=_token]').val(),
            id:id
        },
        success: function(data){ 

          $('#state').html( data );

          $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});


          var id=$('option:selected', '#state').attr('id');

          $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#city').html( data );
              $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});


          }
      });

      }
  });
    $(document).on('change','#country',function(){
        var id=$('option:selected', '#country').attr('id');
        $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-states')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#state').html( data );
              $('#state option').each(function(){
    if($(this).val()==selected_state){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});

          }
      });
    })





    $(document).on('change','#state',function(){

        var id=$('option:selected', '#state').attr('id');

        $.ajax({
            url: "{{LaravelLocalization::localizeURL('/get-cities')}}",
            type:'post',
            data:{
                _token:$('input[name=_token]').val(),
                id:id
            },
            success: function(data){ 

              $('#city').html( data );
              $('#city option').each(function(){
    if($(this).val()==selected_city){ // EDITED THIS LINE
        $(this).attr("selected","selected");    
    }
});

          }
      });
    })
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $('#bank-info').css({'display':'none'});

        $('.rad').click(function() {
            var item = $(".item option:selected").val();
            if($(this).is(':checked')) { 
                if (item=='') {
                    $('#bank-info').css({'display':'none'});}
                    else{
                        $('#bank-info').css({'display':'block'});}
                    }
                    else{
                        $('#bank-info').css({'display':'none'});
                    }
                });

        if ($(".item option:selected").val() && $('.rad').is(':checked') ) {
            $('#bank-info').css({'display':'block'});
        }else{
            $('#bank-info').css({'display':'none'});
        }


        $('.item').click(function() {
            var rad = $('.rad').is(':checked');
            if($('.item option:selected').val()) { 
                if (rad=='') {
                    $('#bank-info').css({'display':'none'});}
                    else{
                        $('#bank-info').css({'display':'block'});}
                    }
                    else{
                        $('#bank-info').css({'display':'none'});
                    }

                });

    });
</script>
@endsection
