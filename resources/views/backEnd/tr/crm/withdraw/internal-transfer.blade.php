
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Internal Transfer')
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
                       
                          İç transfer
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
                                        <a href="#">Show me how</a>
                                        <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="show-transfer-hide">
                                        <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                        <span>İç transfer nasıl yapılır</span>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected">1. Transfer Detayları</li>
                                        <li class="second-li"> 2. Onay Transferi </li>
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
                        
                            {!! Form::label('transfer_from', 'Transfer From *') !!}
                            <select name="transfer_from" class="form-control input-lg "  id="transfer_from">
                            <option value="">İşlem Hesabı Seç</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} Amerikan Doları</option>
                            @endforeach
                        </select>

                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                         <div class="form-group show-form">
                        
                            {!! Form::label('transfer_to', 'Transfer to *') !!}
                            <select name="transfer_to" class="form-control input-lg" id="transfer_to">
                            <option value="">İşlem Hesabı Seç</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} 
                                Amerikan Doları</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        <!-- <p style="text-align: justify;">When carrying out non-trading operations between accounts with different deposit currencies, a conversion will take place according to the <a href="" style="color: green">Company exchange rates</a> on the day the funds are credited to Forex Time's account.</p> -->
                            {!! Form::label('amount', 'Amount to Transfer *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'placeholder' => 'Enter Amount','onkeyup'=>'calculatenet()','name' => 'amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        <div class="form-group">
                        {!!Form::button('Transfer',['class'=>'btn btn-primary transfer-button show-form','type'=>'button'])!!}
                        </div>
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
                                <thead>
                                  <tr>
                                    <td colspan="2" style="text-align: left;"><b>Lütfen aşağıdaki ayrıntıları doğrulayın ve ödeme yapın</b></td>
                                  </tr>
                              </thead>
                                  <tr>
                                    <td style="font-weight:bold"> Transfer Form *</td>
                                    <td class="deposit-from"></td>
                                  </tr>
                                <tr>
                                    <td style="font-weight:bold">Transfer To *</td>
                                    <td class="amount-withdraw"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight:bold">Net tutar</td>
                                    <td class="amount"></td>
                                  </tr>

                                  
                               
                               </table>
                            <br>
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary transfer-button','type'=>'button'])!!}
                        </div>
                        {!!Form::close()!!}
                        <div class="col-md-4">
                        <div class="">
                            <div class="">
                                <h5>Transfer detayları:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Para birimi:</td>
                                                <td class="left">Amerikan Doları</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Transfer from</td>
                                                <td class="left" id="trFrom"></td>
                                            </tr>
                                            <tr>
                                                <td class="left">Transfer to</td>
                                                <td class="left" id="trTo"></td>
                                            </tr>
                                            <tr>
                                                <td class="left"></td>Miktar</td>
                                                <td class="left" id="trAmount"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> 
                                        Üçüncü şahıslardan yapılan ödemeler kabul edilmez. Gönderenin adı işlem hesabınızdaki adla eşleşmelidir.</li>
                                    <li> {{$general_info->company_name}} USD cinsinden havale kabul eder. Farklı bir para biriminde gönderilen paralar hesabınızın depozito para birimine dönüştürülür. Dönüşüm için ücret alınabilir.</li>
                                    <li> Gönderen banka veya muhabir banka, bir havale işleminin ücretini düşebilir. {{$general_info->company_name}} 
                                        herhangi bir ücret uygulanmaz ve hesabınıza alınan net tutarı yatırır.</li>
                                    <li>  
                                        İşlem devam ederse, paranın alınmasından sonra paralar işlem hesabınıza gönderilir. {{$general_info->company_name}}. İşlem süresi genellikle 3-5 iş günüdür. Bankada gecikme olabilir veya {{$general_info->company_name}} 
                                        bilgilerinizi doğrulayamıyor. Lütfen banka havalesi onayınızı kaydedin, böylece gerekirse tüm ayrıntıları kontrol edebiliriz.</li>
                                    <li>  Havale ile yatırılan paralar, adınızdaki herhangi bir banka hesabına çekilebilir.</li>
                                    <li>   Fonların geldiği kaynak, fon çıkışı ile aynı olmalıdır. Bu bakımdan, para yatırma işleminizin geri çekilmesi, yalnızca orijinal olarak yatırdığınız hesabın aynısı olarak yapılabilir.</li>
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



<script type="text/javascript">
  $('select').change(function() {

    var value = $(this).val();

    $('select').not(this).children('option').each(function() {
        if ( $(this).val() === value ) {
            $(this).attr('disabled', true).siblings().removeAttr('disabled');   
        }
    });

});
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
        $('#netellerForm').validate({
            rules:{
                transfer_from: "required",
                transfer_to: "required",
                amount: "required amount",
            },
            messages:{
                transfer_from: {required:'Select Trading Account'},
                transfer_to: {required:'Select Trading Account'},
                amount: {required:'Enter Valid Amount'},
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




