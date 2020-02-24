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
                                                    <td>
                                                        <a href="/managers/trading_account-{{$account->account_no}}">
                                                            <button type="button" class="btn btn-primary">
                                                                Details
                                                              </button>
                                                          </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="form-button m-t-5">
                                            <a href="/open-manager-account"><button>Open New Account</button></a>
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