
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Bank Deposit')
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
    <style type="text/css">
    table#bank-table > tbody > tr > td:first-child {
        white-space:nowrap;
    }
</style>
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-money"></i>
                        Para Yatırma İsteği
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
                        <form action="">
                            <label for="">Ödeme sistemi</label>
                            <input class="form-control" name="disabled" placeholder="Bank Transfer" disabled="disabled" type="text" style="width: 50%">
                            <label for="" style="margin-top: 5%">hesap</label>
                            <div class="form-group" style="width: 50%">
                                <select class="form-control item">
                                    <option disabled selected value="">seçmek</option>
                                    @foreach($accounts as $key => $accounts)
                                    <option value="{{$accounts->account_no}}" @if($selected_account==$accounts->account_no) selected="selected" @endif>{{$accounts->acc_no}} ${{$accounts->balance}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="" style="margin-top: 5%">Para birimi<span class="bank-span"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Please indicate the currency in which you would like to make your transfer "></i></span></label>

                            <div class="radio">
                                <label>
                                    <input name="o3" class="rad" value="" type="radio">
                                    <span class="cr" style="font-size: 18px;cursor: pointer;" id="hi"><i class="cr-icon fa fa-circle"></i></span>
                                    Amerikan Doları
                                </label>
                            </div>

                            <div class="bank-info" id="printable">
                                
                                
                                <div class="bank-table" >
                                    <table class="table" id="bank-table">
                                        <tbody>
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">LEHTAR</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left">Yararlanıcı Adı</td>
                                                <td class="left">{{$bank_info->beneficiary_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Faydalanıcı Adresi</td>
                                                <td class="left">{{$bank_info->beneficiary_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Faydalanan Hesap</td>
                                                <td class="left">{{$bank_info->beneficiary_account}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Faydalanıcı IBAN</td>
                                                <td class="left">{{$bank_info->beneficiary_IBAN}}</td>
                                            </tr>
                                        </tbody>
                                        <tbody style="margin-top: 5%">
                                            <tr>
                                                <td class="left" style="border-top: none">
                                                    <h5 style="font-weight: 600">YARARLANICI BANKASI</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left"> Lehtarlı Banka Adı</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Faydalanıcı Banka Adresi</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Faydalanıcı Banka SWIFT</td>
                                                <td class="left">{{$bank_info->beneficiary_bank_swift}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Yorum / Referans</td>
                                                <td class="left" id="tr_acc">Ticari hesap</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-5">
                        <div class="">
                            <div class="">
                                <h5>Transfer detayları:</h5>
                                <div class="bank-table">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="left">Para birimi:</td>
                                                <td class="left">{{$bank_info->currency}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">Ücretler / Komisyon:</td>
                                                <td class="left">{{$bank_info->commission}}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">İşlem süresi:</td>
                                                <td class="left">{{$bank_info->processing_time}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="bank-info" style="padding: 0">
                                <ol>
                                    <li> Üçüncü şahıslardan yapılan ödemeler kabul edilmez. Gönderenin adı işlem hesabınızdaki adla eşleşmelidir.</li>
                                    <li> {{$general_info->company_name}} USD cinsinden havale kabul eder. Farklı bir para biriminde gönderilen paralar hesabınızın depozito para birimine dönüştürülür. Dönüşüm için ücret alınabilir.</li>
                                    <li> Gönderen banka veya muhabir banka, bir havale işleminin ücretini düşebilir. {{$general_info->company_name}} herhangi bir ücret uygulanmaz ve hesabınıza alınan net tutarı yatırır.</li>
                                    <li>  İşlem devam ederse, paranın alınmasından sonra paralar işlem hesabınıza gönderilir. {{$general_info->company_name}}. 
                                        İşlem süresi genellikle 3-5 iş günüdür. Bankada gecikme olabilir veya {{$general_info->company_name}} bilgilerinizi doğrulayamıyor. Lütfen banka havalesi onayınızı kaydedin, böylece gerekirse tüm ayrıntıları kontrol edebiliriz.</li>
                                    <li>   Havale ile yatırılan paralar, adınızdaki herhangi bir banka hesabına çekilebilir.</li>
                                    <li>   Fonların geldiği kaynak, fon çıkışı ile aynı olmalıdır. Bu bakımdan, para yatırma işleminizin geri çekilmesi, yalnızca orijinal olarak yatırdığınız hesabın aynısı olarak yapılabilir.</li>
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

<script>
$(document).ready(function(){
    $('select.item').on('change',function(){
        $('#tr_acc').html("Trading account "+$(this).val());
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('#printable').css({'display':'none'});


    $('.item option:selected').val(function(){
       if($('.rad').is(":checked", true)){
        // alert('hi');
        $('#printable').css({'display':'block'});
        $('#bank-info').css({'display':'block'});
       } else{
        $('#printable').css({'display':'none'});
        $('#bank-info').css({'display':'none'});
       }
    });

    $('select.item').on('change',function(){
        if ($(this).val()) {
            if($('.rad').is(":checked", true)){
                $('#printable').css({'display':'block'});
                $('#bank-info').css({'display':'block'});
            }
            else {
                $('#printable').css({'display':'none'});
                $('#bank-info').css({'display':'none'});
            }
        }
    })

    $('.rad').change(function(){
        if ($(".item option:selected").val()) {
            $('#printable').css({'display':'block'});
            $('#bank-info').css({'display':'block'}); 
        }
        else {
            $('#printable').css({'display':'none'});
            $('#bank-info').css({'display':'none'});
        }
    });
    
            
});
</script>
@endsection
