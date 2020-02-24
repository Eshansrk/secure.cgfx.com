
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Open New Account')
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
                        Yeni Hesap Aç
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
                            {{--  <div class="row">
                                <div class="col-md-6">
                                    <div class="show-transfer">
                                        <span><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span>
                                        <a href="#">Show me how</a>
                                        <span class="down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                        <span class="up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="show-transfer-hide">
                                        <a href=""><span><i class="fa fa-play" aria-hidden="true"></i></span>Video</a>
                                        <span>How to Open Account</span>
                                    </div>
                                </div>
                            </div>  --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li selected"> 1. Hesap türünüzü seçin</li>
                                        <li class="second-li"> 2. Ticaret hesabınızı özelleştirin </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card select-account">
                                        <div class="select-account-body">
                                            <h4>Canlı İşlem Hesabı</h4>
                                            <p>Pazarı girin ve birkaç dakika içinde işlem yapmaya başlayın. İhtiyaçlarınıza uygun bir hesap açın.</p>
                                        </div>
                                        <div class="select-account-button">
                                            <a href="/open-trading-account"><button>seçmek</button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card select-account">
                                        <div class="select-account-body">
                                            <h4>Demo Hesabı Aç</h4>
                                            <p>Pazarı girin ve birkaç dakika içinde işlem yapmaya başlayın. İhtiyaçlarınıza uygun bir hesap açın.</p>
                                        </div>
                                        <div class="select-account-button">
                                            <a href="/open-demo-account"><button>seçmek</button></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Starting of Manager account -->
                        <div class="col-md-6">
                            <div class="card select-account">
                                <div class="select-account-body">
                                    <h4>Open Manager Account</h4>
                                    <p>Become a Strategy Manager with and earn more with your successful trading strategies.</p>
                                </div>
                                <div class="select-account-button">
                                    <a href="/open-manager-account"><button>Select</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- End of manager account -->
                        <!-- Starting of Investor account -->
                        <div class="col-md-6">
                            <div class="card select-account">
                                <div class="select-account-body">
                                    <h4>Open Investor Account</h4>
                                    <p>With an Investment Account you don’t need to trade yourself. Choose a Strategy Manager
                                        that suits your goals, follow their account and monitor their results.
                                    </p>
                                </div>
                                <div class="select-account-button">
                                    <a href="/manager-list"><button>Select</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- End of Investor account -->
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
            });
            
    </script>
@endsection




