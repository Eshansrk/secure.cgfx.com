@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', '開設新帳戶') 
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
                        <i class="fa fa-home"></i> 開設新帳戶
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
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="up-barcurb">
                                <li class="first-li selected"> 1. 選擇您的帳戶類型 </li>
                                <li class="second-li"> 2. 自定義您的交易賬戶 </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card select-account">
                                <div class="select-account-body">
                                    <h4>真實帳戶</h4>
                                    <p>進入市場，幾分鐘後開始交易。開立一個適合你需要的帳戶
                                    </p>
                                </div>
                                <div class="select-account-button">
                                    <a href="/open-trading-account"><button>選擇</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card select-account">
                                <div class="select-account-body">
                                    <h4>開設模擬帳號</h4>
                                    <p>進入市場，幾分鐘後開始交易。開立一個適合你需要的帳戶</p>
                                </div>
                                <div class="select-account-button">
                                    <a href="/open-demo-account"><button>選擇</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- Starting of Manager account -->
                        <div class="col-md-6">
                            <div class="card select-account">
                                <div class="select-account-body">
                                    <h4>開啟經理帳戶</h4>
                                    <p>您成為一名戰畧經理，並通過成功的交易策略獲得更多收益。</p>
                                </div>
                                <div class="select-account-button">
                                    <a href="/open-manager-account"><button>選擇</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- End of manager account -->
                        <!-- Starting of Investor account -->
                         <div class="col-md-6">
                            <div class="card select-account">
                                <div class="select-account-body">
                                    <h4>開啟投資者帳戶</h4>
                                    <p>有了投資帳戶，您就不需要自己做交易了。選擇一個符合您目標的戰畧經理，跟踪他們的帳戶並監控他們的結果。
                                    </p>
                                </div>
                                <div class="select-account-button">
                                    <a href="/manager-list"><button>選擇</button></a>
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