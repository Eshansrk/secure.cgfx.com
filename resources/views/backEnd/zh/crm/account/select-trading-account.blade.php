@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '开设新账户')
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
                        开设新账户
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer"> 
        <div class="inner bg-container">
           <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="up-barcurb">
                            <li class="first-li selected"> 1. 选择您的账户类型</li>
                            <li class="second-li"> 2. 自定义您的交易账户 </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card select-account">
                            <div class="select-account-body">
                                <h4>实盘交易账户</h4>
                                <p>自定义您的交易账户, 选择市场实时开始交易.</p>
                            </div>
                            <div class="select-account-button">
                                <a href="/open-trading-account"><button>选择</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card select-account">
                            <div class="select-account-body">
                                <h4>开设模拟账户</h4>
                                <p>自定义您的交易账户, 选择市场实时开始交易.</p>
                            </div>
                            <div class="select-account-button">
                                <a href="/open-demo-account"><button>选择</button></a>
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
        </div>
    </div>
</div>
</div>
@endsection
@section ('page-level-js')
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(function(){
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
