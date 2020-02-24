
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '出金')
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
                        <i class="fa fa-money"></i>
                        出金
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
            <!-- <div class="card-block " style="margin-top: 20px;">
                            <h2>Withdraw Funds</h2>
                            <div class="row m-t-35">
                            <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="background:#071220" class="payhod card"><a href="/neteller_withdraw"><img width="250px" height="120px" src="/img/payment/neteller.svg" alt=""></a></div>
                            </div>
                            <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="background:#071220" class=" payhod card"><a href="/skrill_withdraw"><img width="250px" height="120px" src="/img/payment/skrill.svg" alt=""></a></div>
                            </div>
                           
                            <div class="col-md-3" style="margin-bottom: 30px;">
                            <div style="background:#071220" class=" payhod card"><a href="/bank_transfer"><img width="250px" height="120px" src="/img/payment/bank-transfer.svg" alt=""></a></div>
                            </div>
                            <div class="col-md-3" style="margin-bottom: 30px;">
<div style="background:#071220" class=" payhod card"><a href="/perfect_money_withdraw"><img width="250px" height="120px" src="/img/payment/perfect-money-logo.png" alt=""></a></div>
                        </div>
                    </div>
                                                </div> -->

                     <!-- <div class="card" style="background: #fdfdfd">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="heading-transiction">
                                    <p> Credit / Debit cards </p>
                                </div>
                                <div class="main-table">
                                    <table class="table">
                                        
                                        <thead>
                                            <tr>
                                                <th>Transfer Method </th>
                                                
                                                <th>Currency</th>
                                                <th>Fees / Commission </th>
                                                <th>Processing Time</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="frt-td1"><img src="/img/card_icon.png" alt="" width="120px" height="40px"><span><a href="">Credit / Debit cards</a></span></td>
                                                
                                                <td>EUR, USD, GBP</td>
                                                <td>No Commission</td>
                                                <td>24 hours</td>
                                                <td class="last-td"><a href=""><button>Withdraw</button></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="card" style="background: #fdfdfd;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="heading-transiction">
                                    <p> 銀行轉帳  </p>
                                </div>
                                <div class="main-table">
                                    <table class="table">
                                        <!-- <caption>table title and/or explanatory text</caption> -->
                                        <thead>
                                            <tr>
                                                <th>轉帳方法 </th>
                                                
                                                <th>匯率</th>
                                                <th>手續費 </th>
                                                <th>處理時間</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="frt-td1"><img src="/img/bank_trasfer-513.png" alt="" class="img-responsive" height="40px"><span><a href="/bank-withdraw-funds">銀行轉帳</a></span></td>
                                                
                                                <td>USD</td>
                                                <td>免手續費</td>
                                                <td>24 小時</td>
                                                <td class="last-td">
                                                    @if($selected_account)
                                                    <a href="/bank-withdraw-funds?ac={{$selected_account}}"><button>出金</button></a>
                                                    @else
                                                    <a href="/bank-withdraw-funds"><button>出金</button></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                   <!--  <div class="card" style="background: #fdfdfd;margin-top: 5%">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="heading-transiction">
                                    <p> E-Wallets   </p>
                                </div>
                                <div class="main-table">
                                    <table class="table">
                                        
                                        <thead>
                                            <tr>
                                                <th>Transfer Method </th>
                                                
                                                <th>Currency</th>
                                                <th>Fees / Commission </th>
                                                <th>Processing Time</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="frt-td1"><img src="/img/scrill_2.png" alt="" width="100px" height="40px"><span><a href="/skrill_withdraw">Skrill</a></span></td>
                                                
                                                <td> USD</td>
                                                <td>No Commission</td>
                                                <td>24 hours</td>
                                                <td class="last-td">
                                                    @if($selected_account)
                                                    <a href="/skrill_withdraw?ac={{$selected_account}}"><button>Withdraw</button></a>
                                                    @else
                                                    <a href="/skrill_withdraw"><button>Withdraw</button></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="frt-td1"><img src="/img/ic_neteller.png" alt="" width="100px" height="40px"><span><a href="/neteller_withdraw">Netteler</a></span></td>
                                                
                                                <td>    USD</td>
                                                <td>No Commission</td>
                                                <td>24 hours</td>
                                                <td class="last-td">
                                                     @if($selected_account)
                                                    <a href="/neteller_withdraw?ac={{$selected_account}}"><button>Withdraw</button></a>
                                                    @else
                                                    <a href="/neteller_withdraw"><button>Withdraw</button></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="frt-td1"><img src="/img/logo-standart.png" alt="" width="100px" height="40px"><span><a href="/okpay_withdraw">OK Pay</a></span></td>
                                                
                                                <td>    USD</td>
                                                <td>No Commission</td>
                                                <td>24 hours</td>
                                                <td class="last-td">
                                                     @if($selected_account)
                                                    <a href="/okpay_withdraw?ac={{$selected_account}}"><button>Withdraw</button></a>
                                                    @else
                                                    <a href="/okpay_withdraw"><button>Withdraw</button></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="frt-td1"><img src="/img/Perfectmoney.png" alt="" width="100px" height="40px"><span><a href="/perfect_money_withdraw">Perfect Money</a></span></td>
                                                
                                                <td>    USD</td>
                                                <td>No Commission</td>
                                                <td>24 hours</td>
                                                <td class="last-td">
                                                    @if($selected_account)
                                                    <a href="/perfect_money_withdraw?ac={{$selected_account}}"><button>Withdraw</button></a>
                                                    @else
                                                    <a href="/perfect_money_withdraw"><button>Withdraw</button></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
 -->






    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>





























@endsection




