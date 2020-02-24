@extends(app()->getLocale().'.layouts.fixed_menu_header') {{-- Page title --}} 
@section('title') Managers @parent 
@stop {{--
page level styles --}} 
@section('header_styles')
<link rel="stylesheet" href="/assets/invest/jquery.dataTables.min.css"> 
@stop 
@section('content')
<header class="head">
    <div class="main-bar">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-th"></i> Managers
                </h4>
            </div>
            <div class="col-lg-6 col-md-8 col-sm-8">
                <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                    <li class="breadcrumb-item">
                        <a href="/">
                                    <i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
                                </a>
                    </li>

                    <li class="breadcrumb-item active">Managers</li>
                </ol>
            </div>
        </div>
    </div>
</header>
<div class="outer simple">
    <div class="inner bg-light lter bg-container">
        <div class="row">
            <div class="col-12 data_tables">
                <div class="card">
                    <div class="card-header bg-white">
                        <i class="fa fa-table"></i> Managers
                    </div>
                    <div class="card-block m-t-35">


                        <table id="managerTable" class="display table table-stripped table-bordered nowrap cusTableStyle" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th></th>
                                    <th>Account Name</th>
                                    <th>Account No</th>
                                    <th>Age (in days)</th>
                                    <th>Profit (All time)</th>
                                    <th>Profit (This month)</th>
                                    <th>Investors</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($managers as $key => $manager)
                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    {{--
                                    <td>{{ $manager->fname }} {{ $manager->lname }}</td> --}}
                                    <td><img src="http://social-trading.netcoden.com/images/graphs/{{ $manager->account_no }}.png"
                                            alt="{{ $manager->account_no }}"></td>
                                    <td>

                                        {{ $manager->st_username }}

                                    </td>
                                    <td>{{ $manager->account_no }}</td>

                                    <td>
                                        @php $created = new Carbon\Carbon($manager->date_time); $now = Carbon\Carbon::now(); $difference = $created->diffInDays($now);
                                        
@endphp {{ $difference }}
                                    </td>
                                    {{--
                                    <td>{{ $manager->date_time }}</td> --}}
                                    <td>{{ round($manager->totalProfit, 2) }}</td>
                                    <td>{{ round($manager->totalMonthlyProfit, 2) }}</td>
                                    <td>{{ ($manager->totalInvestor) ? $manager->totalInvestor : 0 }}</td>
                                    <td>
                                        <a target="_blank" href="/manager-statistics/{{$manager->int_id}}">
                                          <button type="button" class="btn btn-success">
                                              Stats
                                            </button>
                                        </a>
                                        <a target="_blank" href="/manager-details/{{$manager->int_id}}">
                                          <button type="button" class="btn btn-primary">
                                              Details
                                            </button>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach

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
<!--plugin scripts-->
<script src="/assets/invest/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
    $('#managerTable').dataTable();
})

</script>
















@stop