
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Skrill Withdraw')
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
                        Skrill Para Çekme
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
                                        <a href="#">Bana nasıl olduğunu göster</a>
                                        <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="show-transfer-hide">
                                        <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                        <span>Skrill aktarımı nasıl yapılır?</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected"> 1. Transfer Detayları</li>
                                        <li class="second-li"> 2. Onay Transferi </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- <h2>Skrill Withdraw</h2> -->
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/skrill_withdraw'), 'name' => 'withdrawForm','class'=>'col-md-7','id'=>'skrillForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('transfer_from', 'Transfer From *') !!}
                            <select name="transfer_from" class="form-control input-lg" required="required" id="transfer_from">
                            <option value="">
                                İşlem Hesabı Seç</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->acc_no}} {{$account->balance}} 
                                Amerikan Doları</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                    <div class="form-group show-form">
                        
                            {!! Form::label('amount', 'Amount to be withdrawn *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount',  'placeholder' => 'Enter Amount in USD','onchange'=>'calculatenet()']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        <div class="form-group show-form">
                        
                            {!! Form::label('net_amount', 'Net Amount') !!}
                        {!! Form::text('net_amount', null, ['class' => 'form-control input-lg','id'=>'net_amount', 'readonly'=>'readonly']) !!}
                        <small class="text-danger">{{ $errors->first('net_amount') }}</small>
                        </div>

                        
                        

                        <div class="form-group show-form">
                        
                            {!! Form::label('email', 'Skrill Email *') !!}
                        {!! Form::email('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Enter Skrill Email Address']) !!}
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="form-group">
                        {!!Form::button('Withdraw',['class'=>'btn btn-primary transfer-button show-form'])!!}
                        </div>
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
                                <thead>
                                  <tr>
                                    <td colspan="2" style="text-align: left;"><b>Lütfen aşağıdaki ayrıntıları doğrulayın ve ödeme yapın</b></td>
                                  </tr>
                              </thead>
                                  <tr>
                                    <td style="font-weight:bold">Transfer From *</td>
                                    <td class="deposit-from"></td>
                                  </tr>
                                <tr>
                                    <td style="font-weight:bold">Çekilecek miktar *</td>
                                    <td class="amount-withdraw"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight:bold">Net tutar</td>
                                    <td class="amount"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-weight:bold">Skrill Email *</td>
                                    <td class="email"></td>
                                  </tr>
                                
                               
                               </table>
                            <br>
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
                        <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Çekilme ayrıntıları:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Para birimi:</td>
                                                <td class="left">
                                                    Amerikan Doları</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Ücretler / Komisyon:</td>
                                                <td class="left">2.5%</td>
                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    İşlem süresi:</td>
                                                <td class="left"> 3-5 iş günü</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> Üçüncü şahıslardan yapılan ödemeler kabul edilmez. Gönderenin adı işlem hesabınızdaki adla eşleşmelidir.</li>
                                    <li> {{$general_info->company_name}} USD cinsinden havale kabul eder. Farklı bir para biriminde gönderilen paralar hesabınızın depozito para birimine dönüştürülür. Dönüşüm için ücret alınabilir.</li>
                                    <li> Gönderen banka veya muhabir banka, bir havale işleminin ücretini düşebilir. {{$general_info->company_name}} 
                                        herhangi bir ücret uygulanmaz ve hesabınıza alınan net tutarı yatırır.</li>
                                    <li>  İşlem devam ederse, paranın alınmasından sonra paralar işlem hesabınıza gönderilir. {{$general_info->company_name}}. 
                                        İşlem süresi genellikle 3-5 iş günüdür. Bankada gecikme olabilir veya {{$general_info->company_name}} 
                                        bilgilerinizi doğrulayamıyor. Lütfen banka havalesi onayınızı kaydedin, böylece gerekirse tüm ayrıntıları kontrol edebiliriz.</li>
                                    <li>   Havale ile yatırılan paralar, adınızdaki herhangi bir banka hesabına çekilebilir.</li>
                                    <li>   
                                        Fonların geldiği kaynak, fon çıkışı ile aynı olmalıdır. Bu bakımdan, para yatırma işleminizin geri çekilmesi, yalnızca orijinal olarak yatırdığınız hesabın aynısı olarak yapılabilir.</li>
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
            });

        $.validator.addMethod('amount', function (value) { 
            return /^[0-9]+(\.[0-9]{1,2})?$/.test(value); 
        }, 'Please enter a valid US or Canadian postal code.');
            //form validation
            $('#skrillForm').validate({
                rules:{
                    transfer_from: "required",
                    amount: "required amount",
                    email: "required",
                    
                },
                messages:{
                    transfer_from: 'Select Trading Account',
                    amount: "Please enter valid amount",
                    email: "Enter your email",
                    
                }

            });

            //form validity check and next
            $('.hide-form').hide();
            
            $('.transfer-button').click(function(){
               if($('#skrillForm').valid()==true) {
                    $('.first-li').removeClass('selected');
                    $('.second-li').addClass('selected');
                    $('.hide-form').show(500);
                    $('.show-form').hide(300);
                    var from = $('#transfer_from').val();
                    var amount = $('input[name=net_amount]').val();
                    var email = $('input[name=email]').val();

                    $('.t_from').html(from);
                    $('.t_amount').html(amount);
                    $('.t_email').html(email);

                    $('.deposit-from').html($('#transfer_from').val());
                    $('.amount-withdraw').html($('#amount').val());
                    $('.amount').html($('#net_amount').val());
                    $('.email').html($('#email').val());
                }
               });
    </script>
@endsection




