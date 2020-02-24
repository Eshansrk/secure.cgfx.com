
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Download Platforms')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i style="font-size:20px;" class="fa fa-download"></i>
                        Download Trading Platform
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
                    <div class="col-md-7" style="padding: 30px;">
                         <table class=" table table-striped" width="100%" ">
              <!-- <tr>
                <td><img src="/assets/images/icon/icon1.png" alt="" /></td>
                <td>FXTM Web Trader (MT4)</td>
                <td></td>
                <td><button class="btn btn-success" type="submit">Launch</button></td>
              </tr> -->
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-windows"></i></td>
                <td>Metatrader 4 Trading Terminal for PC</td>
                
                <td><a href="{{$download_link}}"> <button class="btn btn-success" type="submit"> Download</button></a></td>
              </tr>
              
              <!-- <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td>Metatrader 4 Trading Terminal for MAC</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/ios?server=CGFX-Server" target="_blank"><button class="btn btn-success" type="submit">Download</button></a></td>
              </tr> -->
              
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> Metatrader 4 for iPhone</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/ios?server=CGFX-Server" target="_blank"><button class="btn btn-success" type="submit">Download</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>Metatrader 4 for Android</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?server=CGFX-Server" target="_blank"><button class="btn btn-success" type="submit"> Download</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> Metatrader 4 for iPad</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/ios?server=CGFX-Server" target="_blank"><button class="btn btn-success" type="submit">Download</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>Metatrader 4 for Android Tablet</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?server=CGFX-Server" target="_blank"><button class="btn btn-success" type="submit"> Download</button></a></td>
              </tr>
            </table>
            </div>
            <div class="col-md-5 " >
                        <div class="card m-t-25" style="border : 1px solid #f9f9f9">
                            
                            <div class="bank-info" style="padding: 0">
                                <ul style="list-style-type: unset">
                                    <li> Complete control over a trading account.</li>
                                    <li> Access anywhere and anytime.</li>
                                    <li> All order types and MetaTrader 4 execution modes.</li>
                                    <li> 3+ types of charts: Bars, Japanese Candlesticks and a broken line.</li>
                                    <li> 9+ time-frames: M1, M5, M15, M30, H1, H4, D1, W1, and MN.</li>
                                    <li> 30+ technical indicators.</li>
                                    <li> 24+ analytical objects.</li>
                                    <li> Financial market news.</li>
                                    <li> A free chat for communicating with other traders.</li>
                                </ul>
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
