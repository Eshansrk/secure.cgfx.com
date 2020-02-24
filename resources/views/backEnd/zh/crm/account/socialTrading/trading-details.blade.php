@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title',$accounts->account_no.' ('.$accounts->act_type.')')

@section ('page-level-css')
<!--plugin styles-->
<link type="text/css" rel="stylesheet" href="/vendors/select2/css/select2.min.css" />

<link type="text/css" rel="stylesheet" href="/css/pages/tables.css" />
<link type="text/css" rel="stylesheet" href="/css/pages/index.css">
<link type="text/css" rel="stylesheet" href="/social-trading/jquery.dataTables.min.css">
<link type="text/css" rel="stylesheet" href="/social-trading/monthpicker.css">
@endsection
 
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-user"></i> {{$accounts->account_no}} ({{$accounts->act_type}})
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-md-6 m-b-20">
                    <div class="card">
                        <div class="row">

                            <div class="col-md-4">
                                <p class="p-img"><img src="/img/standard-ac-type.png"></p>
                            </div>
                            <div class="col-md-8">
                                <table class="table" id="myTable">
                                    <tbody>

                                        <tr>
                                            <td class="left">Account Type</td>
                                            <td class="left" id="type_account">{{$accounts->act_type}}</td>
                                        </tr>
                                        <tr>
                                            <td class="left">Balance</td>
                                            <td class="left" id="type_account">{{$accounts->BALANCE}}</td>
                                        </tr>

                                        <tr>
                                            <td class="left">Credit</td>
                                            <td class="left" id="leverage_show">{{$accounts->CREDIT}}</td>
                                        </tr>
                                        <tr>
                                            <td class="left">Equity</td>
                                            <td class="left" id="leverage_show">{{$accounts->EQUITY}}</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <div class="fund-button clearfix">
                                    <div class="col-md-4">
                                        <a href="/deposit-funds?ac={{$accounts->account_no}}" class="title-button"><button>Deposit Funds</button></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/internal-transfer?ac={{$accounts->account_no}}"><button>Internal Transfer</button></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="/change-mt4-password?ac={{$accounts->account_no}}"><button>Change Password</button></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card height">
                        <table class="table" id="myTable">
                            <tbody>
                                <tr>
                                    <td class="left">Currency</td>
                                    <td class="left">{{$accounts->CURRENCY}}</td>
                                </tr>

                                <tr>
                                    <td class="left">Leverage</td>
                                    <td class="left" id="leverage_show">1 : {{$accounts->LEVERAGE}}</td>
                                </tr>
                                <tr>
                                    <td class="left">Commission</td>
                                    <td class="left" id=""></td>
                                </tr>
                                <tr>
                                    <td class="left">Minimum Deposit</td>
                                    <td class="left" id=""></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- Investor Details -->
            <!--top section widgets-->
            <div>
                <ul class="nav nav-inline view_user_nav_padding">
                    <li class="nav-item card_nav_hover">
                        <a class="nav-link active tab1" href="#tab_accounts" data-toggle="tab">Investor Accounts</a>
                    </li>
                    <li class="nav-item card_nav_hover">
                        <a class="nav-link tab2" href="#tab_master_orders" data-toggle="tab">Live Orders</a>
                    </li>
                    <li class="nav-item card_nav_hover">
                        <a class="nav-link tab3" href="#tab_reports" data-toggle="tab">Reports</a>
                    </li>
                    <li class="nav-item card_nav_hover">
                        <a class="nav-link tab4" href="#tab_commissions" data-toggle="tab">Commissions</a>
                    </li>
                    <li class="nav-item card_nav_hover">
                        <a class="nav-link tab5" href="#tab_commission_history" data-toggle="tab">Commission History</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane show active" id="tab_accounts" style="position: relative;min-height: 300px;">
                    <div class="card">
                        <div class="card-block">
                            <!-- ManagerTable -->

                            <table class="table table-striped table-responsive" id="investorListTable">
                                <thead>
                                    <tr>
                                        <th>Active</th>
                                        <th>LOGIN </th>
                                        <th>Name</th>
                                        <th>Group</th>
                                        <th>Volume (lot)</th>
                                        <th>%</th>
                                        <th>Balance</th>
                                        <th>Equity</th>
                                        <th>Margin</th>
                                        <th>Running Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($investorDetails)>0) @foreach ($investorDetails as $key => $account)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="logins" cus="{{ $account->id
                                    }}" id="{{ $account->int_id }}" class="is_active" value="{{ $account->account_no }}"
                                                data-margin="{{ $account->MARGIN_FREE }}" data-balance="{{ $account->BALANCE }}"
                                                data-equity="{{ $account->EQUITY }}" {{ ($account->is_active==1)
                                            ? 'checked=checked' : '' }}>
                                        </td>
                                        <td>{{$account->account_no}}</td>
                                        <td>{{ $account->fname }}</td>
                                        <td>{{ $account->GROUP }}</td>
                                        <td><input class="lot_allocation{{ ($account->is_active==1) ? ' lot_active' : '' }}"
                                                type="number" value="{{$account->lot_allocation}}" cus="{{ $account->id
                                        }}" id="lot_{{ $account->id
                                    }}" {{ (($accounts->allocation_type == 0 || $accounts->allocation_type == '' || $accounts->allocation_type
                                            == '4') && $account->is_active == 1 ) ? '' : 'disabled="disabled"' }} style="text-align:center;">
                                            <i id="lot_icon_{{$account->id}}" style="position: relative;display:none;top:7px;right:8%;color: #37D99E; " class="pull-right fa fa-refresh fa-spin "></i>
                                        </td>
                                        <td><input class="percent_allocation{{ ($account->is_active==1) ? ' percent_active' : '' }}"
                                                type="number" value="{{$account->percent_allocation}}" cus="{{ $account->id
                                        }}" id="percent_{{ $account->id
                                        }}" {{ ($accounts->allocation_type != 1 || $account->is_active == 0 ) ? 'disabled="disabled"'
                                            : '' }} style="text-align:center;">
                                            <i id="percent_icon_{{$account->id}}" style="position: relative;display:none;top:7px;right:8%;color: #37D99E; " class="pull-right fa fa-refresh fa-spin "></i>
                                        </td>
                                        <td>{{round($account->BALANCE,2)}}</td>
                                        <td>{{round($account->EQUITY,2)}}</td>
                                        <td>{{round($account->MARGIN_FREE,2)}}</td>
                                        <td>{{ $account->running_trades }}</td>
                                        <td><button type="button" cus="{{$account->id}}" class="btn btn-sm btn-danger remove-btn">Remove</button></td>
                                    </tr>
                                    @endforeach @else
                                    <tr>
                                        <td colspan="11">No investors under this Manager account</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>


                        </div>

                    </div>
                    <!-- End of Investor Details -->

                    <!--Summery-->
                    <div class="card m-t-25">
                        <div class="card-block">
                            <h2 style="text-align: center">Summery</h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Allocation Method</h4>
                                    <p><input id="lot_allocation_checkbox" type="radio" name="allocation_type" value="0" {{
                                            $accounts->allocation_type == 0 || $accounts->allocation_type == '' ? 'checked="checked"'
                                        : ''}} > Lot Allocation</p>
                                    <p><input id="percent_allocation_checkbox" type="radio" name="allocation_type" value="1"
                                            {{ $accounts->allocation_type == 1 ? 'checked="checked"' : ''}} > Percent Allocation</p>
                                    <p><input id="proportional_by_balance_checkbox" type="radio" name="allocation_type" value="2"
                                            {{ $accounts->allocation_type == 2 ? 'checked="checked"' : ''}} > Proportional to
                                        Balance
                                    </p>
                                    <p><input id="proportional_by_equity_checkbox" type="radio" name="allocation_type" value="3"
                                            {{ $accounts->allocation_type == 3 ? 'checked="checked"' : ''}} > Proportional to
                                        Equity
                                    </p>
                                    <p><input id="fixed_lot_checkbox" type="radio" name="allocation_type" value="4" {{ $accounts->allocation_type
                                        == 4 ? 'checked="checked"' : ''}} > Fixed Lot</p>
                                </div>
                                <div class="col-md-4">
                                    <p>Total Account: {{ count($investorDetails) }}</p>
                                    <p>Total Balance: {{ array_sum(array_column($investorDetails, 'BALANCE')) }}</p>
                                    <p>Total Equity: {{ array_sum(array_column($investorDetails, 'EQUITY')) }}</p>
                                    <p>Total Margin: {{ array_sum(array_column($investorDetails, 'MARGIN_FREE')) }}</p>
                                    <p>Total Running Order: {{ array_sum(array_column($investorDetails, 'running_trades')) }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p id="total_active_lot">Total Active Lot: <span>{{ $active_lot }}</span></p>
                                    <p id="total_active_percent">Total Active Percent: <span>{{ $active_percent }}</span></p>
                                    <p>Active Account: <span id="activeAccount">{{ $active_accounts }}</span></p>
                                    <p>Active Balance: <span id="activeBalance">{{ $active_balance }}</span></p>
                                    <p>Active Equity: <span id="activeEquity">{{ $active_equity }}</span></p>
                                    <p>Active Margin: <span id="activeMargin">{{ $active_margin }}</span></p>
                                    <p>Active Running Order: <span id="activeRunningOrder">{{ $active_running }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Summery -->
                </div>
                <div role="tabpanel" class="tab-pane show" id="tab_master_orders" style="position: relative;min-height: 300px;">
                    <div class="card">
                        <div class="card-block">
                            <h4>Master Orders</h4>
                            <table class="table table-striped table-responsive" id="masterOrdersTable">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Login </th>
                                        <th>Symbol</th>
                                        <th>Comment</th>
                                        <th>Type</th>
                                        <th>Lots</th>
                                        <th>Open Time</th>
                                        <th>SL</th>
                                        <th>TP</th>
                                        <th>Commission</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="master_orders">
                                    <tr>
                                        <td colspan="13">
                                            <div class="preload2" style="
                                                width: 100%;
                                                height: 100%;
                                                top: 0;
                                                left: 0;
                                                z-index: 100000;
                                                backface-visibility: hidden;
                                                background: #ffffff;">
                                                <div class="preloader_img" style="width: 200px;
                                                height: 200px;
                                                position: relative;
                                                left: 42%;
                                                top: 35%;
                                                background-position: center;
                                              z-index: 999999">
                                                    <img src="/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card m-t-25">
                        <div class="card-block">
                            <h4>Sub Orders</h4>
                            <table class="table table-striped table-responsive" id="investorOrdersTable">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Login </th>
                                        <th>Symbol</th>
                                        <th>Comment</th>
                                        <th>Type</th>
                                        <th>Lots</th>
                                        <th>Open Time</th>
                                        <th>SL</th>
                                        <th>TP</th>
                                        <th>Commission</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="investor_orders">
                                    <tr>
                                        <td colspan="13">
                                            <div class="preload2" style="
                                                width: 100%;
                                                height: 100%;
                                                top: 0;
                                                left: 0;
                                                z-index: 100000;
                                                backface-visibility: hidden;
                                                background: #ffffff;">
                                                <div class="preloader_img" style="width: 200px;
                                                height: 200px;
                                                position: relative;
                                                left: 42%;
                                                top: 35%;
                                                background-position: center;
                                              z-index: 999999">
                                                    <img src="/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div role="tabpanel" class="tab-pane show" id="tab_reports" style="position: relative;min-height: 300px;">
                    <div class="card">
                        <div class="card-block">
                            <h4>Master Order Reports</h4>
                            <table class="table table-striped table-responsive" id="masterReportsTable">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Login </th>
                                        <th>Symbol</th>
                                        <th>Comment</th>
                                        <th>Type</th>
                                        <th>Lots</th>
                                        <th>Open Time</th>
                                        <th>Open Price</th>
                                        <th>Close Time</th>
                                        <th>Close Price</th>
                                        <th>SL</th>
                                        <th>TP</th>
                                        <th>Commission</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="master_order_reports">
                                    <tr>
                                        <td colspan="16">
                                            <div class="preload2" style="
                                                width: 100%;
                                                height: 100%;
                                                top: 0;
                                                left: 0;
                                                z-index: 100000;
                                                backface-visibility: hidden;
                                                background: #ffffff;">
                                                <div class="preloader_img" style="width: 200px;
                                                height: 200px;
                                                position: relative;
                                                left: 42%;
                                                top: 35%;
                                                background-position: center;
                                              z-index: 999999">
                                                    <img src="/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card m-t-25">
                        <div class="card-block">
                            <h4>Sub Order Reports</h4>
                            <table class="table table-striped table-responsive" id="investorReportsTable">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Login </th>
                                        <th>Symbol</th>
                                        <th>Comment</th>
                                        <th>Type</th>
                                        <th>Lots</th>
                                        <th>Open Time</th>
                                        <th>Open Price</th>
                                        <th>Close Time</th>
                                        <th>Close Price</th>
                                        <th>SL</th>
                                        <th>TP</th>
                                        <th>Commission</th>
                                        <th>Swaps</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody id="investor_order_reports">
                                    <tr>
                                        <td colspan="16">
                                            <div class="preload2" style="
                                                width: 100%;
                                                height: 100%;
                                                top: 0;
                                                left: 0;
                                                z-index: 100000;
                                                backface-visibility: hidden;
                                                background: #ffffff;">
                                                <div class="preloader_img" style="width: 200px;
                                                height: 200px;
                                                position: relative;
                                                left: 42%;
                                                top: 35%;
                                                background-position: center;
                                              z-index: 999999">
                                                    <img src="/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div role="tabpanel" class="tab-pane show" id="tab_commissions" style="position: relative;min-height: 300px;">
                    <div class="card">
                        <div class="card-block">
                            <table class="table table-striped table-responsive" id="commissionsTable">
                                <thead>
                                    <tr>
                                        <th>Login </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Running Week Order ( Total Order ) @else
                                            Running Month Order ( Total Order ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Running Week Lot ( Total Lot ) @else Running
                                            Month Lot ( Total Lot ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Running Week Profit ( Total Profit ) @else
                                            Running Month Profit ( Total Profit ) @endif
                                        </th>
                                        <th>Profit Share</th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Running Week Commission @else Running Month
                                            Commission @endif</th>

                                    </tr>
                                </thead>
                                <tbody id="master_commissions">
                                    <tr>
                                        <td colspan="9">
                                            <div class="preload2" style="
                                                width: 100%;
                                                height: 100%;
                                                top: 0;
                                                left: 0;
                                                z-index: 100000;
                                                backface-visibility: hidden;
                                                background: #ffffff;">
                                                <div class="preloader_img" style="width: 200px;
                                                height: 200px;
                                                position: relative;
                                                left: 42%;
                                                top: 35%;
                                                background-position: center;
                                              z-index: 999999">
                                                    <img src="/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped table-responsive" id="commissionsTableSum">
                                <thead>
                                    <tr>

                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Running Week Total Order ( Sum of Total Orders
                                            ) @else Running Month Total Order ( Sum of Total Orders ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Running Week Total Lot ( Sum of Total Lots
                                            ) @else Running Month Total Lot ( Sum of Total Lots ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Running Week Total Profit ( Sum of Total
                                            Profits ) @else Running Month Total Profit ( Sum of Total Profits ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Running Week Total Commissions @else Running
                                            Month Total Commission @endif</th>

                                    </tr>
                                </thead>
                                <tbody id="master_commissions_sum">

                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{--
                    <div class="card m-t-25">
                        <div class="card-block">

                            <div class="row">
                                <div class="col-md-4">
                                    <p>Last Payment: </p>
                                </div>
                                <div class="col-md-4">
                                    <p>Total Paid Commission: </p>
                                </div>
                                <div class="col-md-4">
                                    <p>Pending Commission: </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
                <div role="tabpanel" class="tab-pane show" id="tab_commission_history" style="position: relative;min-height: 300px;">
                    <div class="card">
                        <div class="card-block m-t-25">
                            {{--
                            <h5 style="margin-left:40%">Pick a month</h5> --}}
                            <input id="month" value="" type="text" placeholder="Last month" />
                            <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="commissionHistoryTable">
                                <thead>
                                    <tr>
                                        <th>Login</th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Weekly Order ( Total Order ) @else Monthly
                                            Order ( Total Order ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Weekly Lot ( Total Lot ) @else Monthly
                                            Lot ( Total Lot ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Weekly Profit ( Total Profit ) @else Monthly
                                            Profit ( Total Profit ) @endif
                                        </th>
                                        <th>Profit Share</th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time=='7') Weekly Commission @else Monthly Commission
                                            @endif
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="master_commission_history">
                                    <tr>
                                        <td colspan="9">
                                            <div class="preload2" style="
                                                        width: 100%;
                                                        height: 100%;
                                                        top: 0;
                                                        left: 0;
                                                        z-index: 100000;
                                                        backface-visibility: hidden;
                                                        background: #ffffff;">
                                                <div class="preloader_img" style="width: 200px;
                                                        height: 200px;
                                                        position: relative;
                                                        left: 42%;
                                                        top: 35%;
                                                        background-position: center;
                                                      z-index: 999999">
                                                    <img src="/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="commissionHistoryTableSum"
                                style="position:relative">
                                <thead>
                                    <tr>

                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Weekly Total Order ( Sum of Total Orders
                                            ) @else Monthly Total Order ( Sum of Total Orders ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Weekly Total Lot ( Sum of Total Lots ) @else
                                            Monthly Total Lot ( Sum of Total Lots ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Weekly Total Profit ( Sum of Total Profits
                                            ) @else Monthly Total Profit ( Sum of Total Profits ) @endif
                                        </th>
                                        <th>
                                            @if(isset($accounts->profit_sharing_time) && $accounts->profit_sharing_time==7) Weekly Total Commission @else Monthly Total
                                            Commission @endif</th>

                                    </tr>
                                </thead>
                                <tbody id="master_commission_history_sum" style="position:relative;">

                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{--
                    <div class="card m-t-25">
                        <div class="card-block m-t-25">

                            <div class="row">
                                <div class="col-md-4">
                                    <p>Last Payment: </p>
                                </div>
                                <div class="col-md-4">
                                    <p>Total Paid Commission: </p>
                                </div>
                                <div class="col-md-4">
                                    <p>Pending Commission: </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>

        </div>
        <!-- /.inner -->
    </div>
</div>
</div>
</div>
{{csrf_field()}}
@endsection
 
@section('page-level-js')
<!--plugin scripts-->
<!--plugin scripts-->

<script type="text/javascript" src="/vendors/select2/js/select2.js"></script>

<script src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/pages/moment.js"></script>
<script type="text/javascript" src="/social-trading/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/social-trading/monthpicker.min.js"></script>
<script type="text/javascript" src="/vendors/sweetalert/js/sweetalert2.min.js"></script>
<script type="text/javascript" src="/js/pages/sweet_alerts.js"></script>

<!-- end of plugin scripts -->
<!--Page level scripts-->

<script>
    $(document).ready(function(){
        var preload_h = 
        '<div id="preload_h" style="width: 100%;height: 100%;top: 0;left: 0;z-index: 100000;backface-visibility: hidden;background: #ffffff;"><div class="preloader_img" style="width: 200px;height: 200px;left: 42%;top: 35%;background-position: center;z-index: 999999;"><img src="/assets/img/loader3.gif" style="width: 40px;position: absolute;left: 50%;top: 50%;margin-left: -20px;margin-top: -20px;" alt="loading..."></div></div>';
        $("#month").Monthpicker({
            onSelect: function() {
                $('#tab_commission_history table tbody#master_commission_history').html(preload_h);   
                $('#tab_commission_history table tbody#master_commission_history_sum').html(preload_h); 
                $.ajax({
                    url: "{{LaravelLocalization::localizeURL('/managers/commission-history')}}",
                    type: "post",
                    dataType: "json",
                    data: {
                        _token:$('input[name=_token]').val(),
                        id: {{ $accounts->int_id }},
                        month: $('#month').val()
                    },
                    success: function(data){     
                        
                        $('#tab_commission_history table tbody#master_commission_history').html(data.data1);   
                        $('#tab_commission_history table tbody#master_commission_history_sum').html(data.data2); 
                        {{-- console.log(document.getElementById('commissionHistoryTable'));   --}}
                        $('#commissionHistoryTable').DataTable(); 
                    }
                });
              }
            });



        allocation_type = [];
         allocation_type = {{ isset($accounts->allocation_type) ? $accounts->allocation_type : 0 }} ;
        // Allocation Type
       $(document).on('click','input[name="allocation_type"]',function(){
           //alert($(this).val())
           var id={{ $accounts->int_id }};
            allocation_type = $(this).val();
            $('.percent_allocation').prop("disabled", true)
            $('.lot_allocation').prop("disabled", true)
            //console.log($('.is_active'))
            
            $.ajax({
                url: "{{LaravelLocalization::localizeURL('/managers/change-allocation-type')}}"+"/"+id+"/"+allocation_type,
                success: function(data){
                    $.each($("input[name='logins']:checked"), function(){            
                        //console.log($(this).attr('id'))
                        if(allocation_type == 0 || allocation_type == '' || allocation_type == 4)
                        { 
                            $('#lot_'+$(this).attr('cus')).prop('disabled', false)
                            totalActive('lot_active','total_active_lot','Total Active Lot: ');
                    }
                        else if(allocation_type == 1) 
                        {
                            $('#percent_'+$(this).attr('cus')).prop('disabled', false)
                        }
                    });

                    if(allocation_type == 1){
                    sum = totalActive('percent_active','total_active_percent','Total Active Percent: ');
                    if(sum > 100){
                        alert("More than 100 percent. Trade won't open.");
                    }
                }
                }
            })
       });
        
       
        //   Active Account Details Calculation

                $(document).on('click','.is_active',function(){
                    var id = ($(this).attr('cus'))
                    var activeAccountNo = $(this).val()
                        var activeMargin = $(this).data('margin')
                        var activeBalance = $(this).data('balance')
                        var activeEquity = $(this).data('equity')
                        var self = this
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/enable-disable-investor')}}"+"/"+id,
                        success : function(data){
                            
                    if($(self).prop("checked") == true){
                        //alert(allocation_type)
                        if(allocation_type==0 || allocation_type=='' || allocation_type==4){
                            $('#percent_'+id).prop("disabled",true)
                       $('#lot_'+id).addClass('lot_active')
                       $('#lot_'+id).prop("disabled",false)
                       totalActive('lot_active','total_active_lot','Total Active Lot: ');
                        }
                       else if(allocation_type==1){
                       $('#percent_'+id).addClass('percent_active')
                       $('#percent_'+id).prop("disabled",false)
                       sum = totalActive('percent_active','total_active_percent','Total Active Percent: ');
                            if(sum > 100){
                                alert("More than 100 percent. Trade won't open.");
                            }
                       }
                        // updating active summery
                       // document.getElementById('actives').innerHTML = +document.getElementById('activeAccount').innerHTML + +1
                        document.getElementById('activeAccount').innerHTML = +document.getElementById('activeAccount').innerHTML + +1
                        document.getElementById('activeBalance').innerHTML = parseFloat(+document.getElementById('activeBalance').innerHTML + +activeBalance).toFixed(2)
                        document.getElementById('activeMargin').innerHTML = parseFloat(+document.getElementById('activeMargin').innerHTML + +activeMargin).toFixed(2)
                        document.getElementById('activeEquity').innerHTML = parseFloat(+document.getElementById('activeEquity').innerHTML + +activeEquity).toFixed(2)
                    }
                    else if($(self).prop("checked") == false){
                        if(allocation_type==0 || allocation_type=='' || allocation_type==4){
                        $('#lot_'+id).removeClass('lot_active')
                       $('#lot_'+id).prop("disabled",true)
                       totalActive('lot_active','total_active_lot','Total Active Lot: ');
                    }
                       else if(allocation_type==1){
                        $('#percent_'+id).removeClass('percent_active')
                       $('#percent_'+id).prop("disabled",true)
                       totalActive('percent_active','total_active_percent','Total Active Percent: ');
                     }
                        // updating active summery
                        //document.getElementById('actives').innerHTML = +document.getElementById('activeAccount').innerHTML - 1
                        document.getElementById('activeAccount').innerHTML = +document.getElementById('activeAccount').innerHTML - 1
                        document.getElementById('activeBalance').innerHTML = parseFloat(+document.getElementById('activeBalance').innerHTML - activeBalance).toFixed(2)
                        document.getElementById('activeMargin').innerHTML = parseFloat(+document.getElementById('activeMargin').innerHTML - activeMargin).toFixed(2)
                        document.getElementById('activeEquity').innerHTML = parseFloat(+document.getElementById('activeEquity').innerHTML - activeEquity).toFixed(2)
                        
                    }
                        }
                    });
                });

                // Inline Update
                // Lot Allocation
                $(document).on('keyup','.lot_active',function(){
                   
                   totalActive('lot_active','total_active_lot','Total Active Lot: ');

                    var id = $(this).attr('cus');
                    var lot_allocation = $(this).val();
                    $('#lot_icon_'+id).show();
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/update-allocation')}}",
                        type:'post',
                        data:{
                            _token:$('input[name=_token]').val(),
                            id:id,
                            allocation:lot_allocation,
                            allocation_type:0
                        },
                        success: function(data){ 
                                       
                            $('#lot_icon_'+id).fadeOut('fast');

                                          }
                    });                
                });

                

                // Percent Allocation
                $(document).on('keyup','.percent_active',function(){
                    sum = totalActive('percent_active','total_active_percent','Total Active Percent: ');
                            if(sum > 100){
                                alert("More than 100 percent. Trade won't open.");
                            }
                            else{
                    var id = $(this).attr('cus');
                    var percent_allocation = $(this).val();
                    $('#percent_icon_'+id).show();
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/update-allocation')}}",
                        type:'post',
                        data:{
                            _token:$('input[name=_token]').val(),
                            id:id,
                            allocation:percent_allocation,
                            allocation_type:1
                        },
                        success: function(data){ 
                                       
                            $('#percent_icon_'+data).fadeOut('fast');

                                          }
                    });     
                }           
                });

                // Function to calculate sum of total active lot / percent
                function totalActive(activeClass,tdId,html){
                    var sum = 0;
                            $('.'+activeClass).each(function() {
                                var val = $.trim( $(this).val() );

                                if ( val ) {
                                    val = parseFloat( val.replace( /^\$/, "" ) );

                                    sum += !isNaN( val ) ? val : 0;
                                }
                            });
                            $('p#'+tdId).html(html+''+sum);
                            return sum;
                }

        // Remove Client from Investor List

        
  $(document).on("click", '.remove-btn', function(event) {
    //var link=$(this).attr('href'); 
      var id=$(this).attr('cus');
      if (confirm("Are you sure you want to remove this investor ?")) {
        $.ajax({
    
            type:"post",
            url: "{{LaravelLocalization::localizeURL('/managers/remove-investor-account')}}",
            data:{
                _token:$('input[name=_token]').val(),
                id:id
        },
            success: function(data){ 
                           
                location.reload();
                     }
        });
        
      }
      
        
    });
    

        ///    Master & Investor Running Orders

                $(document).one('click','.tab2',function(){
                    
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/live-trades')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token:$('input[name=_token]').val(),
                            id: {{ $accounts->int_id }}
                        },
                        success: function(data){
                            $('#tab_master_orders table tbody#master_orders').html(data.data1);
                            $('#tab_master_orders table tbody#investor_orders').html(data.data2);
                            $('#masterOrdersTable').DataTable();
                            $('#investorOrdersTable').DataTable();
                        }
                    });


                    setInterval(function(){
                        $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/live-trades')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token:$('input[name=_token]').val(),
                            id: {{ $accounts->int_id }}
                        },
                        success: function(data){
                            $('#tab_master_orders table tbody#master_orders').html(data.data1);
                            $('#tab_master_orders table tbody#investor_orders').html(data.data2);
                            $('#masterOrdersTable').DataTable();
                            $('#investorOrdersTable').DataTable();
                        }
                    });
                    },10000);
                    
                });

        ///    Master & Investor Reports

                $(document).one('click','.tab3',function(){
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/reports')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token:$('input[name=_token]').val(),
                            id: {{ $accounts->int_id }}
                        },
                        success: function(data){
                            $('#tab_reports table tbody#master_order_reports').html(data.data1);
                            $('#tab_reports table tbody#investor_order_reports').html(data.data2);            
                            $('#masterReportsTable').DataTable();
                            $('#investorReportsTable').DataTable();
                        }
                    });
                    
                });

                 ///    Master Commision Statistics

                 $(document).one('click','.tab4',function(){
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/commissions')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token:$('input[name=_token]').val(),
                            id: {{ $accounts->int_id }}
                        },
                        success: function(data){      
                            $('#tab_commissions table tbody#master_commissions').html(data.data1);   
                            $('#tab_commissions table tbody#master_commissions_sum').html(data.data2);   
                            $('#commissionsTable').DataTable();
                        }
                    });
                    
                });

                ///    Master Commision Statistics History
    
                $(document).one('click','.tab5',function(){
                    $.ajax({
                        url: "{{LaravelLocalization::localizeURL('/managers/commission-history')}}",
                        type: "post",
                        dataType: "json",
                        data: {
                            _token:$('input[name=_token]').val(),
                            id: {{ $accounts->int_id }}
                        },
                        success: function(data){      
                            $('#tab_commission_history table tbody#master_commission_history').html(data.data1);   
                            $('#tab_commission_history table tbody#master_commission_history_sum').html(data.data2);   
                            $('#commissionHistoryTable').DataTable();
                        }
                    });
                    
                });

                // datatable
                $('#investorListTable').DataTable();

            });

</script>
@endsection