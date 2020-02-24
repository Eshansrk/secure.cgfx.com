
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
                        Geri çekme talebi
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

                        
                        <label for="payment_system">Ödeme sistemi</label>
                        <input class="form-control" name="payment_system" placeholder="Bank Payment" disabled="disabled" type="text" style="width: 50%">
                        <label for="" style="margin-top: 5%">hesap</label>
                        <div class="form-group" style="width: 50%">
                            <select class="form-control item" name="transfer_from">
                                <option disabled selected value="">seçmek</option>
                                @foreach($accounts as $key => $accounts)
                                <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="" style="margin-top: 5%">Para birimi <span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Please indicate the currency in which you would like to make your transfer "></i></span></label>

                        <div class="radio">
                            <label>
                                <input name="currency" class="rad" value="USD" type="radio">
                                <span class="cr" style="font-size: 18px;cursor: pointer;" id="hi"><i class="cr-icon fa fa-circle"></i></span>
                                Amerikan Doları
                            </label>
                        </div>

                        <div class="bank-info" id="bank-info">


                            
                                <div class="form-group col-md-12">

                                    {!! Form::label('amount', 'Amount to Withdraw *') !!}
                                    {!! Form::text('amount', '', ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Amount']) !!}
                                    
                                </div>
                          

                            <div class="form-group col-md-6">
                                
                                    {!! Form::label('bank_acc_name', 'Bank Account Name *') !!}
                                    {!! Form::text('bank_acc_name', $info->bank_acc_name, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Account Name']) !!}
                                    
                                
                            </div>
                            
                                <div class="col-md-6 form-group">

                                    {!! Form::label('bank_acc_num', 'Account No (IBAN) *') !!}
                                    {!! Form::text('bank_acc_num', $info->bank_acc_num, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Account No']) !!}
                                    
                                </div> 
                           

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_name', 'Bank Name *') !!}
                                {!! Form::text('bank_name', $info->bank_name, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Name']) !!}
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_country', 'Bank Country *') !!}

                                <select name="bank_residence_country" id="country" class="form-control" required="required">
                                    <option selected="selected" disabled="disabled">Banka Ülke *</option>
                                    @foreach($countries as $country)
                                    <option id="{{$country->countries_id}}" value="{{$country->countries_name}}" {{($info->bank_residence_country==$country->countries_name)?'selected="selected"':''}}>{{$country->countries_name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>

                            <div class="clearfix"></div>


                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_state', 'State Province *') !!}

                                <select name="bank_residence_state" id="state" class="form-control" required="required">

                                </select>

                                <!--  {!! Form::text('bank_residence_state', $info->bank_residence_state, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank State Province']) !!} -->
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_city', 'City *') !!}
                                <select name="bank_residence_city" id="city" class="form-control" required="required">

                                </select>

                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('bank_residence_code', 'Postal Code *') !!}
                                {!! Form::text('bank_residence_code', $info->bank_residence_code, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Postal Code']) !!}
                                
                            </div>

                            <div class="form-group col-md-6">

                                {!! Form::label('swift_num', 'Bank Swift Code *') !!}
                                {!! Form::text('swift_num', $info->swift_num, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Swift Code']) !!}
                                
                            </div>


                            <div class="form-group col-md-12">

                                {!! Form::label('bank_address', 'Bank Address *') !!}
                                {!! Form::textarea('bank_address', $info->bank_address, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Address']) !!}
                                
                            </div>




                            <div class="form-group col-md-12">
                                {!!Form::submit('Withdraw',['class'=>'btn btn-primary'])!!}
                            </div>
                            {!!Form::close()!!}
                        </div>

                    </form>
                </div>


                <div class="col-md-5">
                    <div class="">
                        <div class="bank-info">
                            <h5>Transfer detayları:</h5>
                            <div class="bank-table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="left">Para birimi:</td>
                                            <td class="left">Amerikan Doları</td>
                                        </tr>
                                        <tr>
                                            <td class="left">Ücretler / Komisyon:</td>
                                            <td class="left">2.5%</td>
                                        </tr>
                                        <tr>
                                            <td class="left">İşlem süresi:</td>
                                            <td class="left">24 saat</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bank-info" style="padding: 0">
                            <ol>
                                <li> Üçüncü şahıslardan yapılan ödemeler kabul edilmez. Gönderenin adı işlem hesabınızdaki adla eşleşmelidir.</li>
                                <li> Parayı adınızdaki herhangi bir banka hesabına aktarabilirsiniz. İlk para yatırmanızın geri çekilmesi, yalnızca orijinal olarak yatırdığınız banka hesabına yatırılabilir.</li>
                                <li> Banka Havalesi ile Para Çekme Ödemesinin Amacı:
                                    <ul>
                                        <li>{{$general_info->company_name}} Aktar</li>
                                        <li>Müşteri kimlik numarası</li>
                                        <li>tarih</li>
                                    </ul>

                                </li>
                                <li>  
                                    Minimum para çekme tutarı yoktur. Para çekme işlemlerinin işleme alınacak ücretin, geri çekilen tutardan düşüleceğini lütfen unutmayın.</li>
                                <li>   Çekilmenizi karşılamak için hesabınızda yeterli serbest marjınız olduğundan emin olun. Aksi takdirde, hesabınızdaki açık pozisyonları kapatmayı tercih edebilirsiniz.</li>
                                <li>  
                                    Para çekme işlemleri tarafından işlenir {{$general_info->company_name}} 
                                    isteğinizin 24 saat içinde. Para, bizim tarafımızdan işlenmekte olduğu 3-5 iş günü içinde banka hesabınıza gönderilecektir. Bilgilerinizi doğrulayamazsak gecikme olabilir.</li>
                                <li>Müşterinin talebi doğrultusunda {{$general_info->company_name}} rezervler, uygun gördüğü takdirde, müşterinin istediği banka dışındaki herhangi bir bankadan para çekme hakkını saklı tutar. Banka masraflarındaki herhangi bir farklılık {{$general_info->company_name}}.</li>
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
        var form = $('#bank-withdraw-funds');
        
        form.validate({
            rules : {
                amount : "required"
            },
            messages : {
                amount : "Please enter amount"
            }
        });


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
