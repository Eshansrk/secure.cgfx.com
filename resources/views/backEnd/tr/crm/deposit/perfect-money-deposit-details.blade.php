
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Perfect Money Deposit')
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
                        Mükemmel Para Yatırma
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
                                        <li class="first-li"> 1. Transfer Detayları</li>
                                        <li class="second-li selected"> 2. Onay Transferi </li>
                                    </ul>
                                </div>
                            </div>
                            
                            
                            {!! Form::open(['method' => 'POST', 'url' => 'https://perfectmoney.is/api/step1.asp', 'name' => 'withdrawForm','class'=>'col-md-6','id'=>'withdrawForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
        <input type="hidden" name="PAYEE_ACCOUNT" value="U7493427">
                        <input type="hidden" name="PAYEE_NAME" value="Limited">
                        <input type="hidden" name="PAYMENT_ID" value="{{$reference}}">
                        <input type="hidden" name="PAYMENT_AMOUNT" value="{{$request->amount}}">
                        <input type="hidden" name="PAYMENT_UNITS" value="USD">
                        <input type="hidden" name="STATUS_URL" value="{{config('app.url')}}/{{app()->getLocale()}}/perfect_money_deposit_status">
                        <input type="hidden" name="PAYMENT_URL" value="{{config('app.url')}}/{{app()->getLocale()}}/perfect_money_deposit_success">
                        <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
                        <input type="hidden" name="NOPAYMENT_URL" value="{{config('app.url')}}/{{app()->getLocale()}}/perfect_money_deposit_cancel">
                        <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
                        <input type="hidden" name="SUGGESTED_MEMO" value="">
                        <input type="hidden" name="BAGGAGE_FIELDS" value="">
                            
                        <div class="form-group hide-form">
                            <table class="table table-bordered ">
        <thead>
          <tr>
            <td colspan="2" style="text-align: left;"><b>Lütfen aşağıdaki ayrıntıları doğrulayın ve ödeme yapın</b></td>
          </tr></thead>
          <tr>
            <td style="font-weight:bold">Referans Numarası.</td>
            <td>{{$reference}}</td>
          </tr>
      <tr>
            <td style="font-weight:bold">Hesap numarası</td>
            <td>{{$request->deposit_to}}</td>
          </tr>
        <tr>
            <td style="font-weight:bold">Ödeme türü</td>
            <td>Mükemmel Para</td>
          </tr>
          
          <tr> 
            <td style="font-weight:bold">Miktar</td>
            <td>{{$request->amount}} Amerikan Doları</td>
          </tr>
       
       </table>
                            <br>
                            {!!Form::submit('Confirm',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
                        <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Para yatırma detayları:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Para birimi:</td>
                                                <td class="left">Amerikan Doları</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Ücretler / Komisyon:</td>
                                                <td class="left">Komisyonsuz</td>
                                            </tr>
                                            <tr>
                                                <td class="left"> İşlem süresi:</td>
                                                <td class="left">anlık</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> Üçüncü şahıslardan yapılan ödemeler kabul edilmez. Gönderenin adı işlem hesabınızdaki adla eşleşmelidir.</li>
                                    <li> {{$general_info->company_name}} USD cinsinden havale kabul eder. Farklı bir para biriminde gönderilen paralar hesabınızın depozito para birimine dönüştürülür. Dönüşüm için ücret alınabilir.</li>
                                    <li> Gönderen banka veya muhabir banka, bir havale işleminin ücretini düşebilir.{{$general_info->company_name}} herhangi bir ücret uygulanmaz ve hesabınıza alınan net tutarı yatırır.</li>
                                    <li>  İşlem devam ederse, paranın alınmasından sonra paralar işlem hesabınıza gönderilir. {{$general_info->company_name}}.</li>
                                    <li>   Havale ile yatırılan paralar, adınızdaki herhangi bir banka hesabına çekilebilir.</li>
                                    <li>  Fonların geldiği kaynak, fon çıkışı ile aynı olmalıdır. Bu bakımdan, para yatırma işleminizin geri çekilmesi, yalnızca orijinal olarak yatırdığınız hesabın aynısı olarak yapılabilir.</li>
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









