@php
use Illuminate\Support\Facades\DB;
@endphp
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '真實交易')
@section ('page-level-css')
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
@endsection
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-level-up"></i>
                        真實交易
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        
        <div class="inner bg-container">
          <div class="col-md-12">
                                <div class="live-account m-b-20" style="">
                                 <div class="" style="background: #fdfdfd;">
                            <div class="">
                            <div class="">
                                <div class="heading-transiction">
                                    <p> 我的真實帳戶 </p>
                                </div>
                                <div class="main-table table-responsive">
                                    <table class="table">
                                        
                                        <thead>
                                            <tr>
                                                <th>帳戶</th>
                                                <th>帳戶類型 </th>
                                                <th>匯率</th>  
                                                <th>結餘</th>
                                                <th>淨值</th>
                                                <th>槓桿</th>
                                                <th></th>
                                                
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @if(count($accounts)>0)
                                            @foreach($accounts as $key => $account)
                                            <tr>
                                                <td>{{$account->account_no}}</td>
                                                <td class="frt-td">
                                                    <img src="/img/s-coin.png" alt="" width="40px" height="40px">
                                                    <p><a href="" style="padding: 0">{{$account->act_type}}</a></p>
                                                </td>
                                                <td>USD</td>
                                                
                                                <td>{{$account->BALANCE}}</td>
                                                <td>{{$account->EQUITY}}</td>
                                                <td>{{$account->LEVERAGE}}</td>
                                                <td class="last-td"><div class="dropdown">
                                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                                    style="background-size:cover;width: 50px;">
                                                    <span class="caret"></span>
                                                    
                                                  </button>
                                                  <ul class="dropdown-menu form-dropdown" aria-labelledby="dropdownMenu1">
                                                    <li><a href="/deposit-funds?ac={{$account->account_no}}">入金</a></li>
                                                            <li><a href="/withdraw-funds?ac={{$account->account_no}}">出金</a></li>
                                                            <li><a href="/internal-transfer?ac={{$account->account_no}}">內部轉帳</a></li>
                                                            <li><a href="/verify-profile">驗證資料</a></li>
                                                            <li><a href="/change-leverage?ac={{$account->account_no}}">更改 槓桿</a></li>
                                                            <li><a href="/change-mt4-password?ac={{$account->account_no}}">更改 交易密碼</a></li>
                                                            <li><a href="/profile">帳戶詳情</a></li>
                                                            <li><a href="/download-platforms">下載平台</a></li>
                                                  </ul>
                                                </div>
                                                    
                                                </td>
                                              
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                               <td colspan="14" style="text-align:center;"><strong>No Running Trades</strong></td>
                                            </tr>
                                            @endif
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
      <div class="card-block">

          <div id="commission_table1_wrapper" class="dataTables_wrapper dt-bootstrap no-footer" >
            <div class="row">
              <!-- <div class="col-sm-6">
                <div class="dataTables_length" id="commission_table1_length">
                  <label>Show <select name="commission_table1_length" aria-controls="commission_table1" class="form-control input-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select> entries</label>
                </div>
              </div> -->
              <!-- <div class="col-sm-6">
                <div id="commission_table1_filter" class="dataTables_filter">
                  <label>Search:<input class="form-control input-sm" placeholder="" aria-controls="commission_table1" type="search"></label>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table class="display table table-bordered nowrap  no-footer" id="commission_table1" role="grid" aria-describedby="commission_table1_info" style="width: 100%;" width="100%">
                                 <thead style="white-space:nowrap;">
                                    <tr role="row">
                                      <th class="sorting_asc" rowspan="1" colspan="1" style="width: 49.5px;" aria-label="SR No."><span>帳戶</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 112.5px;" aria-label="Name(IB Code): activate to sort column ascending">訂單</th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 88.5px;" aria-label="Account No.: activate to sort column ascending">時間</th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 102.5px;" aria-label="Account Type.: activate to sort column ascending">種類</th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 56.5px;" aria-label="Volume: activate to sort column ascending">Lots</th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 89.5px;" aria-label="Commission: activate to sort column ascending">苻號</th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 59.5px;" aria-label="Country: activate to sort column ascending">Open Price</th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>S/L</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>T/P</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>Running Price</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>Comm</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>Swap</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>Profit</span></th>
                                      <th class="sorting" tabindex="0" aria-controls="commission_table1" rowspan="1" colspan="1" style="width: 72.5px;" aria-label="Reg. Date: activate to sort column ascending"><span>Equity</span></th>
                                    </tr>
                               </thead>
                              
                               
                                <tbody id="live-trade-page">
                                   @php
                                    $running='No';
  
   $accounts=DB::table('cms_account')->where([
            ['email',session('login_email')],
            ['account_no','<>','0'],
            ['act_type','<>','IB'],
            ['act_type','<>','DEMO']
            ])->get();
  
  foreach($accounts as $account){

  $trades=DB::table('mt4_trades')->where([
    ['LOGIN',$account->account_no],
    ['CLOSE_TIME','1970-01-01 00:00:00']
    ])->orderBy('TICKET', 'desc')->get();

 if(count($trades)>0){
  $running='Yes';
  
 }
  

     
        foreach($trades as $trade){
      if($trade->CMD=='0'){
      $cmd='Buy';
      }
      elseif ($trade->CMD=='1'){
      $cmd='Sell';
      }
      else{
        $cmd='';
      }
      $equity=DB::table('mt4_users')->where(
        'LOGIN',$account->account_no)->first();
      $open_time=$trade->OPEN_TIME;
      $open_time=strtotime($open_time);
      $open_time=date('m/d/y',$open_time);
      $lots=$trade->VOLUME/100;
            
 
       echo '
    <tr>
      <td>'.$trade->LOGIN.'</td>
      <td>'.$trade->TICKET.'</td>
      <td>'.$open_time.'</td>
      <td>'.$cmd.'</td>
      <td>'.$lots.'</td>
      <td>'.$trade->SYMBOL.'</td>
      <td>'.$trade->OPEN_PRICE.'</td>
      <td>'.$trade->SL.'</td>
      <td>'.$trade->TP.'</td>
      <td>'.$trade->CLOSE_PRICE.'</td>
      <td>'.$trade->COMMISSION.'</td>
      <td>'.$trade->SWAPS.'</td>
      <td>'.$trade->PROFIT.'</td>
      <td>'.$equity->EQUITY.'</td>
      </tr>';

  
  
      }


      
}  
if($running=='No'){
echo '<tr><td colspan="14" style="text-align:center;"><strong>No Running Trades</strong></td></tr>';
      
       } 
                                  @endphp
                                </tbody>
                              </table>
                              <div id="commission_table1_processing" class="dataTables_processing panel panel-default" style="display: none;">Processing...</div>
                            </div>
                          </div>
                          <div class="row">
                            <!-- <div class="col-sm-5">
                              <div class="dataTables_info" id="commission_table1_info" role="status" aria-live="polite">Showing 0 to 0 of 0 entries</div>
                            </div> -->
                            <!-- <div class="col-sm-7">
                              <div class="dataTables_paginate paging_simple_numbers" id="commission_table1_paginate">
                                <ul class="pagination">
                                  <li class="paginate_button previous disabled" id="commission_table1_previous">
                                    <a href="#" aria-controls="commission_table1" data-dt-idx="0" tabindex="0">Previous</a>
                                  </li>
                                  <li class="paginate_button next disabled" id="commission_table1_next">
                                    <a href="#" aria-controls="commission_table1" data-dt-idx="1" tabindex="0">Next</a>
                                  </li>
                                </ul>
                              </div>
                            </div> -->
                          </div>
                        </div>
      </div>
          
 

            <!--top section widgets-->
          
                </div> 

                






    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>
























@endsection


@section ('page-level-js')
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

    <script src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/pages/moment.js"></script>
    <!-- end of plugin scripts -->
    <!--Page level scripts-->
@endsection