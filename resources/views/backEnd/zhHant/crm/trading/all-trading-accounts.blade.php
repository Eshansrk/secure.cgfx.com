
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Mt4帳戶')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<style type="text/css">
    .dropdown-menu{
        left: -100%;
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
                        <i class="fa fa-university"></i>
                       我的mt4帳號
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class=" ">

                        <div class="col-md-12">
                                <div class="live-account m-b-20 m-t-20" style="">
                                 <div class="" style="background: #fdfdfd;">
                            <div class="">
                            <div class="">
                                <!-- <div class="heading-transiction">
                                    <p> My Accounts </p>
                                </div> -->
                                <div class="main-table table-responsive">
                                    <table class="table">
                                        
                                        <thead>
                                            <tr>
                                                <th>帳戶號 </th>  
                                                <th>種類 </th>  
                                                <th>結餘</th>
                                                <th>Credit</th>
                                                <th>淨值</th>
                                                <th>保證金</th>
                                                <th>槓桿</th>
                                                <th>未平倉訂單</th>
                                                <th>Action</th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>



                                             @foreach($accounts as $account)
                                                <tr>
                                                    


                                           


                                                <td class="frt-td">
                                                    <img src="/img/s-coin.png" alt="" width="40px" height="40px">
                                                    <p><a href="/trading_account-{{$account->account_no}}" style="padding: 0">   {{$account->account_no}}</a></p>
                                                </td>                                                
                                                <td>{{$account->act_type}}</td>
                                                <td>{{round($account->BALANCE,2)}}</td>
                                                <td>{{round($account->CREDIT,2)}}</td>
                                                <td>{{round($account->EQUITY,2)}}</td>
                                                <td>{{round($account->MARGIN_FREE,2)}}</td>
                                                <td>{{round($account->LEVERAGE,2)}}:1</td>
                                                <td>{{$account->running_trades}}</td>
                                                <td class="last-td"><div class="dropdown">
                                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="background-size:cover;width: 50px;">
                                                    <span class="caret"></span>
                                                    
                                                  </button>
                                                  <ul class="dropdown-menu form-dropdown" aria-labelledby="dropdownMenu1">
                                                            <li><a href="/deposit-funds?ac={{$account->account_no}}">入金</a></li>
                                                            <li><a href="/withdraw-funds?ac={{$account->account_no}}">出金</a></li>
                                                            <li><a href="/internal-transfer?ac={{$account->account_no}}">內部轉帳</a></li>
                                                            <li><a href="/change-leverage?ac={{$account->account_no}}">更改 槓桿</a></li>
                                                            <li><a href="/change-mt4-password?ac={{$account->account_no}}">更改 交易密碼</a></li>
                                                            <li><a href="/trading_account-{{$account->account_no}}">帳戶詳情</a></li>
                                                            <li><a href="/verify-profile">驗證資料</a></li>
                                                            <li><a href="/download-platforms">下載平台</a></li>
                                                  </ul>
                                                </div>
                                                    
                                                </td>
                                                
                                                
                                                </td>
                                             </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                            <div class="form-button m-t-5">
                                                <a href="/open-new-account"><button>開設真實/模擬帳戶</button></a>
                                                <!-- <a href=""><button>View All Accounts</button></a> -->
                                            </div>
                                </div>
                            </div>
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
