@extends(app()->getLocale().'.layouts.fixed_menu_header') {{-- Page title --}} 
@section('title') Investors @parent 
@stop
{{-- page level styles --}} 
@section('header_styles')
<link rel="stylesheet" href="/assets/invest/jquery.dataTables.min.css"> 
@stop 
@section('content')
<header class="head">
    <div class="main-bar">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-th"></i> Investors
                </h4>
            </div>
            <div class="col-lg-6 col-md-8 col-sm-8">
                <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                    <li class="breadcrumb-item">
                        <a href="/">
                                    <i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
                                </a>
                    </li>

                    <li class="breadcrumb-item active">Investors</li>
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
                        <i class="fa fa-table"></i> Investors
                    </div>
                    <div class="card-block m-t-35">


                        <table id="investorTable" class="display table table-stripped table-bordered nowrap cusTableStyle" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Account</th>
                                    <th>Name</th>
                                    <th>Manager</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($investors as $key => $i)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $i->account_no }}</td>
                                    <td>{{ $i->fname }} {{ $i->lname }}</td>
                                    <td>{{ $i->st_username }}</td>
                                    <td>
                                        <a href="/investor-details/{{ $i->int_id }}">
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
    $('#investorTable').dataTable();
})

</script>




@stop