@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '账户提款')
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
                        账户提款
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card" style="background: #fdfdfd;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading-transiction">
                            <p>银行转款</p>
                        </div>
                        <div class="main-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>转款方式</th>
                                        <th>币种</th>
                                        <th>费用/佣金</th>
                                        <th>处理时间</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="frt-td1"><img src="/img/bank_trasfer-513.png" alt="" class="img-responsive" height="40px"><span><a href="/bank-withdraw-funds">银行转款</a></span></td>
                                        <td>USD</td>
                                        <td>无佣金</td>
                                        <td>24小时</td>
                                        <td class="last-td">
                                            @if($selected_account)
                                            <a href="/bank-withdraw-funds?ac={{$selected_account}}"><button>收回</button></a>
                                            @else
                                            <a href="/bank-withdraw-funds"><button>收回</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="background: #fdfdfd;margin-top: 5%">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading-transiction">
                            <p>電子錢包</p>
                        </div>
                        <div class="main-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>转款方式</th>
                                        <th>币种</th>
                                        <th>费用/佣金</th>
                                        <th>处理时间</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="frt-td1"><img src="/img/scrill_2.png" alt="" width="100px" height="40px"><span><a href="/skrill_withdraw">Skrill</a></span></td>
                                        <td>USD</td>
                                        <td>无佣金</td>
                                        <td>24小时</td>
                                        <td class="last-td">
                                            @if($selected_account)
                                            <a href="/skrill_withdraw?ac={{$selected_account}}"><button>收回</button></a>
                                            @else
                                            <a href="/skrill_withdraw"><button>收回</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="frt-td1"><img src="/img/ic_neteller.png" alt="" width="100px" height="40px"><span><a href="/neteller_withdraw">Netteler</a></span></td>
                                        <td>USD</td>
                                        <td>无佣金</td>
                                        <td>24小时</td>
                                        <td class="last-td">
                                           @if($selected_account)
                                           <a href="/neteller_withdraw?ac={{$selected_account}}"><button>收回</button></a>
                                           @else
                                           <a href="/neteller_withdraw"><button>收回</button></a>
                                           @endif
                                       </td>
                                   </tr>
                                   <tr>
                                    <td class="frt-td1"><img src="/img/logo-standart.png" alt="" width="100px" height="40px"><span><a href="/okpay_withdraw">OK Pay</a></span></td>
                                    <td>USD</td>
                                    <td>无佣金</td>
                                    <td>24小时</td>
                                    <td class="last-td">
                                       @if($selected_account)
                                       <a href="/okpay_withdraw?ac={{$selected_account}}"><button>收回</button></a>
                                       @else
                                       <a href="/okpay_withdraw"><button>收回</button></a>
                                       @endif
                                   </td>
                               </tr>
                               <tr>
                                <td class="frt-td1"><img src="/img/Perfectmoney.png" alt="" width="100px" height="40px"><span><a href="/perfect_money_withdraw">Perfect Money</a></span></td>
                                <td>USD</td>
                                <td>无佣金</td>
                                <td>24小时</td>
                                <td class="last-td">
                                    @if($selected_account)
                                    <a href="/perfect_money_withdraw?ac={{$selected_account}}"><button>收回</button></a>
                                    @else
                                    <a href="/perfect_money_withdraw"><button>收回</button></a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
