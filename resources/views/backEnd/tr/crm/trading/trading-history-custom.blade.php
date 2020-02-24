<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-responsive table-striped no-wrap" >
    <thead >
            <tr>
              <th>BİLET</th>
              <th>ZAMAN</th>
              <th>TİP</th>
              <th>ÇOK</th>
              <th>SYMBOL</th>
              <th>O/P</th>
              <th>S/L</th>
              <th>T/P</th>
              <th>C/P</th>
              <th>COMM</th>
              <th>takasları</th>
              <th>YORUM YAP</th>
              <th>KAR</th>
              
            </tr>
            </thead>
            <tbody>
            @if(count($histories)>0)
<?php
  
  $total_deposit = $deposit->total_amount;
  $total_withdraw = $withdraw->total_amount;
  if (count($total_deposit)==0) {
    $total_deposit =0;
  }
  if (count($total_withdraw)==0) {
    $total_withdraw =0;
  }
  ?>
                   
            @foreach($histories as $history)
            
            <tr>
              <td>{{$history->TICKET}}</td>
              <td>{{date('m/d/y',strtotime($history->OPEN_TIME))}}</td>
              @if($history->SYMBOL && $history->OPEN_PRICE!=0 && $history->CLOSE_PRICE!=0)
              <td> @if($history->CMD==0)  {{'Buy'}} @elseif ($history->CMD==1) {{'Sell'}}@endif</td>
              <td> @if($history->SYMBOL!='')  {{$history->VOLUME/100}}@endif</td>
              <td>{{$history->SYMBOL}}</td>
              <td>{{$history->OPEN_PRICE}}</td>
              <td>{{$history->SL}}</td>
              <td>{{$history->TP}}</td>
              <td>{{$history->CLOSE_PRICE}}</td>
              <td>{{$history->COMMISSION}}</td>
              <td>{{$history->SWAPS}}</td>
              @else
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              @endif

              <td>{{$history->COMMENT}}</td>
              <td>{{$history->PROFIT}}</td>
              
              
            </tr>
            @endforeach

            <tr><td colspan="12" style="text-align: left;"><strong>Kar: {{$total_profit_h}}, Credit: {{$total_credit_h}}, Deposit: {{$total_deposit}}, Withdraw: {{$total_withdraw}}</strong></td><td colspan="1">{{$total_profit_h}}</td></tr>
            
             @else
            <tr>
              <td colspan="13" style="text-align: center;"><strong>Tarih Bulunamadı</strong></td>
              </tr>
              @endif
              </tbody>
          </table>