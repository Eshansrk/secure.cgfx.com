@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', 'MT4 Strategic Manager Accounts') 
@section('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<style type="text/css">
    .dropdown-menu {
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
                        <i class="fa fa-university"></i> My MT4 Strategic Manager Accounts
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
                                                    <th>Account No </th>
                                                    <th>Type </th>
                                                    <th>Investors </th>
                                                    <th>Balance</th>
                                                    <th>Credit</th>
                                                    <th>Equity</th>
                                                    <th>Margin</th>
                                                    <th>Leverage</th>
                                                    <th>Running Order</th>
                                                    <th>Action</th>


                                                </tr>
                                            </thead>
                                            <tbody>



                                                @foreach($accounts as $account)
                                                <tr>






                                                    <td class="frt-td">
                                                        <img src="/img/s-coin.png" alt="" width="40px" height="40px">
                                                        <p><a href="/managers/trading_account-{{$account->account_no}}" style="padding: 0">   {{$account->account_no}}</a></p>
                                                    </td>
                                                    <td>{{$account->act_type}}</td>
                                                    <td>{{$account->total_investor}}</td>
                                                    <td>{{round($account->BALANCE,2)}}</td>
                                                    <td>{{round($account->CREDIT,2)}}</td>
                                                    <td>{{round($account->EQUITY,2)}}</td>
                                                    <td>{{round($account->MARGIN_FREE,2)}}</td>
                                                    <td>{{round($account->LEVERAGE,2)}}:1</td>
                                                    <td>{{$account->running_trades}}</td>
                                                    <td class="last-td">
                                                        <div class="dropdown">
                                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="true" style="background-size:cover;width: 50px;">
                                                    <span class="caret"></span>
                                                    
                                                  </button>
                                                            <ul class="dropdown-menu form-dropdown" aria-labelledby="dropdownMenu1">
                                                                <li><a href="/deposit-funds?ac={{$account->account_no}}">Deposit Funds</a></li>
                                                                <li><a href="/withdraw-funds?ac={{$account->account_no}}">Withdraw Funds</a></li>
                                                                <li><a href="/internal-transfer?ac={{$account->account_no}}">Internal Transfer</a></li>
                                                                <li><a href="/change-leverage?ac={{$account->account_no}}">Change leverage</a></li>
                                                                <li><a href="/change-mt4-password?ac={{$account->account_no}}">Change trading password</a></li>
                                                                <li><a href="/trading_account-{{$account->account_no}}">Account Details</a></li>
                                                                <li><a href="/verify-profile">Verify Profile</a></li>
                                                                <li><a href="/download-platforms">Download Platform</a></li>
                                                            </ul>
                                                        </div>

                                                    </td>


                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="form-button m-t-5">
                                            <a href="/open-new-account"><button>Open New Account</button></a>
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