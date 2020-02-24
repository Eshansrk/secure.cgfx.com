
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Skrill Deposit')
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
                        Skrill Mevduat
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
                                        <li class="first-li selected">1. Transfer Detayları</li>
                                        <li class="second-li"> 2. Onay Transferi </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- <h2>Skrill Deposit</h2> -->
                            @if(Session::has('msg'))
                            <div class="col-md-12">
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                        </div>
                        @endif
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/skrill_deposit'), 'name' => 'withdrawForm','class'=>'col-md-7','id'=>'skrillForm']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group show-form">
                        
                            {!! Form::label('deposit_to', 'Deposit to *') !!}
                            <select name="deposit_to" class="form-control input-lg"  id="deposit-to">
                            <option value="">İşlem Hesabı Seç</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}" @if($selected_account==$account->account_no) selected="selected" @endif>{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} {{$account->CURRENCY}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('deposit_to') }}</small>
                        </div>
                    <div class="form-group show-form">
                        
                            {!! Form::label('amount', 'Amount to Deposit *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount',  'placeholder' => 'Enter Amount']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        
                        
                        <div class="form-group show-form">
                        {!!Form::submit('Deposit',['class'=>'btn btn-primary transfer-button'])!!}
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
                                                <td class="left">İşlem süresi:</td>
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
                                    <li> Gönderen banka veya muhabir banka, bir havale işleminin ücretini düşebilir. {{$general_info->company_name}} herhangi bir ücret uygulanmaz ve hesabınıza alınan net tutarı yatırır.</li>
                                    <li> İşlem devam ederse, paranın alınmasından sonra paralar işlem hesabınıza gönderilir. {{$general_info->company_name}}.</li>
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
        $('#skrillForm').validate({
            rules:{
                deposit_to: "required",
                amount: "required amount",
            },
            messages:{
                deposit_to: 'Select Trading Account',
                amount: 'Enter valid Amount'
            }

        });

        //form validity check and next
        $('.hide-form').hide();
        
           
        
    });
</script>
@endsection








