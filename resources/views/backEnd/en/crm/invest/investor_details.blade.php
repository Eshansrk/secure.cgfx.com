@extends(app()->getLocale().'.layouts.fixed_menu_header') {{-- Page title --}} 
@section('title') Investor Details @parent

@stop {{-- page level styles --}} 
@section('header_styles')
<link rel="stylesheet" href="/assets/invest/jquery.dataTables.min.css">
<link rel="stylesheet" href="/assets/invest/monthpicker.css"> 
@stop 
@section('content')
<header class="head">
    <div class="main-bar">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-th"></i> Investor Details
                </h4>
            </div>
            <div class="col-lg-6 col-md-8 col-sm-8">
                <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                    <li class="breadcrumb-item">
                        <a href="/">
                                    <i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
                                </a>
                    </li>

                    <li class="breadcrumb-item active">Investor Details</li>
                </ol>
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

                        <div class="col-md-12">

                            <table class="table" id="myTable">
                                <tbody>
                                    <tr>
                                        <td class="left">Account No</td>
                                        <td class="left" id="account_no">{{$accounts->account_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="left">Account Type</td>
                                        <td class="left" id="type_account">{{$accounts->act_type}}</td>
                                    </tr>
                                    <tr>
                                        <td class="left">Balance</td>
                                        <td class="left" id="balance">{{$accounts->BALANCE}}</td>
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
        {{csrf_field()}}
        <!-- Investor Details -->
        <!--top section widgets-->
        <div>
            <ul class="nav nav-inline view_user_nav_padding">

                <li class="nav-item card_nav_hover">
                    <a class="nav-link tab2 active" href="#tab_master_orders" data-toggle="tab">Live Orders</a>
                </li>
                <li class="nav-item card_nav_hover">
                    <a class="nav-link tab3" href="#tab_reports" data-toggle="tab">Reports</a>
                </li>
                <li class="nav-item card_nav_hover">
                    <a class="nav-link tab4" href="#tab_commissions" data-toggle="tab">Commission History</a>
                </li>

            </ul>
        </div>
        <div class="tab-content m-t-15">

            <div role="tabpanel" class="tab-pane show active" id="tab_master_orders" style="position: relative;min-height: 300px;">
                <div class="card">
                    <div class="card-block m-t-25">
                        <h4>Master Orders</h4>
                        <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="masterOrdersTable">
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
                                                <img src="/assets/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card m-t-25">
                    <div class="card-block m-t-25">
                        <h4>Sub Orders</h4>
                        <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="investorOrdersTable">
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
                                                <img src="/assets/img/loader3.gif" style=" width: 40px;" alt="loading...">
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
                    <div class="card-block m-t-25">
                        <h4>Master Order Reports</h4>
                        <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="masterReportsTable">
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
                                                <img src="/assets/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card m-t-25">
                    <div class="card-block m-t-25">
                        <h4>Sub Order Reports</h4>
                        <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="investorReportsTable">
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
                                                <img src="/assets/img/loader3.gif" style=" width: 40px;" alt="loading...">
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
                    <div class="card-block m-t-25">
                        <table class="display table table-stripped table-bordered nowrap cusTableStyle dataTable no-footer" id="commissionsTable">
                            <thead>
                                <tr>

                                    <th>Date</th>
                                    <th>Manager account</th>
                                    <th>Amount</th>
                                    <th>Month</th>

                                </tr>
                            </thead>
                            <tbody id="investor_commissions">
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
                                                <img src="/assets/img/loader3.gif" style=" width: 40px;" alt="loading...">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>


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
                                                <img src="/assets/img/loader3.gif" style=" width: 40px;" alt="loading...">
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


            </div>
        </div>

    </div>
    <!-- /.inner -->
</div>
<!-- /.outer -->


























































































































@stop 
@section('footer_scripts')
<script src="/assets/invest/jquery.dataTables.min.js"></script>
<script src="/assets/invest/monthpicker.min.js"></script>
<script>
    $(document).ready(function(){

            ///    Master & Investor Running Orders
    
                        
                        $.ajax({
                            url: "{{LaravelLocalization::localizeURL('/investor-live-trades')}}",
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
                                url: "{{LaravelLocalization::localizeURL('/investor-live-trades')}}",
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
                         }, 10000);
                        
                 
    
            ///    Master & Investor Reports
    
                    $(document).one('click','.tab3',function(){
                        $.ajax({
                            url: "{{LaravelLocalization::localizeURL('/investor-reports')}}",
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
                            url: "{{LaravelLocalization::localizeURL('/investor-commissions')}}",
                            type: "post",
                            data: {
                                _token:$('input[name=_token]').val(),
                                id: {{ $accounts->int_id }}
                            },
                            success: function(data){     
                                console.log(data) 
                                $('#tab_commissions table tbody#investor_commissions').html(data);   
                                $('#commissionsTable').DataTable();
                            }
                        });
                        
                    });

    
                });

</script>


















































































































































@stop