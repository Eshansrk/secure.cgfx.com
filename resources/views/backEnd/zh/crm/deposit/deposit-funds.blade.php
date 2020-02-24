@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '账户存款')
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
                        <i class="fa fa-credit-card"></i>
                        账户存款
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card" style="background: #fdfdfd">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading-transiction">
                            <p> 信用卡/借记卡 </p>
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
                                        <td class="frt-td1">
                                            <img src="/img/card_icon.png" alt="" class="img-responsive" height="40px">
                                            <span>
                                                @if($selected_account)
                                                <a href="/voguepay_deposit?ac={{$selected_account}}">Visa/Master卡</a>
                                                @else
                                                <a href="/voguepay_deposit">Visa/Master卡</a>
                                                @endif
                                            </span>
                                        </td>
                                        <td>USD</td>
                                        <td>无佣金</td>
                                        <td>即刻</td>
                                        <td class="last-td">
                                            @if($selected_account)
                                            <a href="/voguepay_deposit?ac={{$selected_account}}"><button>存款</button></a>
                                            @else
                                            <a href="/voguepay_deposit"><button>存款</button></a>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="frt-td1"><img src="/img/upaycard.png" alt="" class="img-responsive" height="40px"><span>
                                            @if($selected_account)
                                                    <a href="/upaycard-deposit?ac={{$selected_account}}">
                                            @else
                                                            <a href="/upaycard-deposit">
                                            @endif
                                            UPay Card</a></span></td>

                                        <td>USD</td>
                                        <td>无佣金</td>
                                        <td>    即刻</td>
                                        <td class="last-td">
                                            @if($selected_account)
                                                <a href="/upaycard-deposit?ac={{$selected_account}}"><button>存款</button></a>
                                            @else
                                                <a href="/upaycard-deposit"><button>存款</button></a>
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
                            <p> 银行转款 </p>
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
                                        <td class="frt-td1"><img src="{{$bank_info->methods_logo_url}}" alt="" class="img-responsive" height="40px" width="100px"><span><a href="/bank-transfer-funds">{{$bank_info->transfer_method}}</a></span></td>
                                        <td>{{$bank_info->currency}}</td>
                                        <td>{{$bank_info->commission}}</td>
                                        <td>{{$bank_info->processing_time}}</td>
                                        <td class="last-td">
                                         @if($selected_account)
                                         <a href="/bank-transfer-funds?ac={{$selected_account}}"><button>存款</button></a>
                                         @else
                                         <a href="/bank-transfer-funds"><button>存款</button></a>
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
                        <p> 电子钱包  </p>
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
                                    <td class="frt-td1"><img src="/img/scrill_2.png" alt="" width="100px" height="40px"><span><a href="/skrill_deposit">Skrill</a></span></td>
                                    <td>USD</td>
                                    <td>费用/佣金</td>
                                    <td>即刻</td>
                                    <td class="last-td">
                                        @if($selected_account)
                                        <a href="/skrill_deposit?ac={{$selected_account}}"><button>存款</button></a>
                                        @else
                                        <a href="/skrill_deposit"><button>存款</button></a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="frt-td1"><img src="/img/ic_neteller.png" alt="" width="100px" height="40px"><span><a href="/neteller_deposit">Netteller</a></span></td>
                                    <td>    USD</td>
                                    <td>费用/佣金</td>
                                    <td>即刻</td>
                                    <td class="last-td">
                                        @if($selected_account)
                                        <a href="/neteller_deposit?ac={{$selected_account}}"><button>存款</button></a>
                                        @else
                                        <a href="/neteller_deposit"><button>存款</button></a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="frt-td1"><img src="/img/Perfectmoney.png" alt="" width="100px" height="40px"><span><a href="/perfect_money_deposit">Perfect Money</a></span></td>
                                    <td>USD</td>
                                    <td>费用/佣金</td>
                                    <td>即刻</td>
                                    <td class="last-td">
                                        @if($selected_account)
                                        <a href="/perfect_money_deposit?ac={{$selected_account}}"><button>存款</button></a>
                                        @else
                                        <a href="/perfect_money_deposit"><button>存款</button></a>
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
</div>
</div>
</div>
</div>
@endsection
