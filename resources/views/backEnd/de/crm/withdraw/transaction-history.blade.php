
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Verlauf der Transaktionen')
@section ('page-level-css')
<!-- <link type="text/css" rel="stylesheet" href="/css/components2.css" /> -->
<link rel="stylesheet" type="text/css" href="/css/daterangepicker.css" />

<!--plugin styles-->
    <link type="text/css" rel="stylesheet" href="/vendors/select2/css/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/scroller.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/colReorder.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/dataTables.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/css/pages/dataTables.bootstrap.css" />
    <!-- end of plugin styles -->

    <!--plugin styles-->
    <link type="text/css" rel="stylesheet" href="/vendors/select2/css/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/scroller.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/colReorder.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/vendors/datatables/css/dataTables.bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/css/pages/dataTables.bootstrap.css" />
    
    <link type="text/css" rel="stylesheet" href="/css/pages/tables.css" />
    <link type="text/css" rel="stylesheet" href="#" id="skin_change" />
    <link rel="stylesheet" href="/assets/backEnd/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/assets/backEnd/css/custom-datatable.css">
    <link type="text/css" rel="stylesheet" href="/css/pages/index.css">
    <link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
    <!-- <link type="text/css" rel="stylesheet" href="/css/pages/tables.css" /> -->
    <style type="text/css">
      #transaction_type{
        height: calc(3.1rem - 2px);
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
                        <i class="fa fa-book"></i>
                        Verlauf der Transaktionen
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
                       


                            <form action="#" class="form-group row form_inline">
                              <div class="col-md-2"></div>
                                 <div class="form-group col-md-3">
                                  <label for="transaction_type" class=" form-control-label">Übertragungsart</label>
                                  <select name class="form-control" id="transaction_type">
                                    <option value="all">Alle</option>
                                    <option value="deposit">Einzahlung</option>
                                    <option value="withdraw">Auszahlung</option>
                                    <option value="credit_in">Kredit in</option>
                                    <option value="credit_out">Kredit aus</option>
                                    <option value="int_tx">Interner Transfer</option>
                                  </select>
                                </div>
                                <div class="col-md-1"></div> 
                                <div class="form-group col-md-6">
                                    <label for="">Überweisungsdatum</label>
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 9px;; border: 1px solid rgba(0, 0, 0, 0.15); width: 49%;border-radius: 5px">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>

                                    </div>
                                <div id="dateSearch"  style="position: absolute;top: 50%;left: 50%;line-height: 1.5">
                                  <button class="" style="border-radius: 2px;border: none;background: #4fb7fe;color: #fff;padding: 6px;font-size: 12px;font-weight: bold;cursor: pointer;">
                                            <i class="fa fa-search"></i>
                                            Prüfen
                                    
                                  </button>
                                </div>
                                </div>

                            </form>
                               <div id="commission_table1_wrapper" class="dataTables_wrapper dt-bootstrap no-footer" >
           
            <div class="row">
              <div class="col-sm-12">

                               <table class="display table table-responsive table-bordered nowrap dataTable no-footer" id="transactionHistory" role="grid" aria-describedby="commission_table1_info" style="width: 100%;" width="100%">
                   
                   

                  <thead>
                                    <tr role="row">
                                     
              <th>Zeit</th>
              <th>Konto</th>
              <th>TYP</th>
              <th>Betrag</th>
              <th>Anmerkung</th>
              
              
                                      
                                    </tr>
                               </thead>
                              
                               
                                
                              </table>   
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

@section ('page-level-js')
<script type="text/javascript" src="/js/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker.min.js"></script>
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

    <script src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/pages/moment.js"></script>
    <script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);


    
    var oTable = $('#transactionHistory').DataTable({
                dom: 'frtBp',
                buttons: [
                    {
                        text: 'Print Selected Orders',
                        action: function ( e, dt, node, config )
                              {
                                  alert( 'You clicked me!' );
                              }
                    }
                ],
                stateSave: true,
                paging:     true,
                pagingType: 'simple_numbers',
                lengthMenu: [ [ 15, 50, 100, -1 ], [ 15, 50, 100, "All" ] ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{LaravelLocalization::localizeURL('/transaction-history-datatable')}}",
                        data: function(d) {

                            d.transaction_type = $('select#transaction_type').val();
                            d.from = $('#reportrange span').html().split('-')[0];
                            d.to = $('#reportrange span').html().split('-')[1];
                           
                           
                        }
                    },
                columns: [
                    
                    { data: 'CLOSE_TIME', name: 'CLOSE_TIME' },
                    {data:'LOGIN',name:'LOGIN'},

                   { data: 'Type_c', name: 'Type_c' },
                  
                    { data: 'Amount_c', name: 'Amount_c'},
                    { data: 'COMMENT', name: 'COMMENT'},
                    
                    
                   
                    
                ],
                
                order: [ [0, 'desc'] ],

        "dom": "<'row'<'col-md-5 col-12'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
       
            });


  
        
    $(document).on('click','#dateSearch', function() {
      
                oTable.draw();
               

            });

    $(document).on('change','select#transaction_type',function(){
         oTable.draw();
     });

  
  
    });

</script>








@endsection
