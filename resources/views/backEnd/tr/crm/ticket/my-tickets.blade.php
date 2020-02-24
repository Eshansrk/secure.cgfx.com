
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title')
Biletlerim
@endsection
@section('page-level-css')

<!--plugin styles-->
    <link type="text/css" rel="stylesheet" href="/vendors/select2/css/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/scroller.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/colReorder.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/dataTables.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/css/pages/dataTables.bootstrap.css" />
    
    <link type="text/css" rel="stylesheet" href="/css/pages/tables.css" />
    <link type="text/css" rel="stylesheet" href="#" id="skin_change" />
    
    <link type="text/css" rel="stylesheet" href="/css/pages/index.css">
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
<style type="text/css">
   table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}

table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after{
    display: none;}
</style>

@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-list-ul"></i>
                        Biletlerim
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class="card ">
                   
                    <div class="card-block">
                        <div class="table-responsive" style="margin-top: 3%">
                       
                                           
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-responsive table-striped no-wrap my-tickets-table" >
                            <thead style="font-weight: bold;">
                                <tr>
                                    <th>At düzenlendi</th>
                                    <th>konu</th>
                                   
                                    
                                    <th>ayrıntılar</th>
                                </tr>
                                                </thead>
                                                <tbody>
                                                
                                                </tbody>                               
                                            </table>

                                            </div>
                                            <!-- /.tab-content -->
                                        
                            
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
@section('page-level-js')
<!--plugin scripts-->

<script type="text/javascript" src="/vendors/select2/js/select2.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/pluginjs/dataTables.tableTools.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="/vendors/datatables/js/dataTables.scroller.min.js"></script>
<script type="text/javascript">
        $('.my-tickets-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{LaravelLocalization::localizeURL('/my-tickets-datatable')}}",
        columns: [
            
            { data: 'created_at', name: 'created_at',"searchable": false },
            { data: 'subject', name: 'subject' },
           
            { data: 'details', name: 'details',"searchable": false },
           
        ],  

    });
    </script>
@endsection