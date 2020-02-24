
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '下载平台')
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
                        下载平台
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
                <td>MT4 PC客户端</td>
                
                <td><a href="{{$download_link}}"> <button class="btn btn-success" type="submit"> 下载</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td>MT4 MAC客户端</td>
                
                <td><a href="https://www.metatrader4.com/en/trading-platform/help/userguide/install_mac" target="_blank"><button class="btn btn-success" type="submit">下载</button></a></td>
              </tr>
              
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> MT4 iPhone客户端</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">下载</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>MT4 Android客户端</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit"> 下载</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> MT4 iPad客户端</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">下载</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>MT4 Android  平板客户端</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit"> 下载</button></a></td>
              </tr>
            </table>
            </div>
            <div class="col-md-5 " >
                        <div class="card m-t-25" style="border : 1px solid #f9f9f9">
                            
                            <div class="bank-info" style="padding: 0">
                                <ul style="list-style-type: unset">
                                    <li> 交易账户完全掌控</li>
                                    <li> 随时随地访问</li>
                                    <li> 所有订单类型和MetaTrader 4执行模式</li>
                                    <li> 3种以上类型的图表：条形图，蜡烛图和折线。</li>
                                    <li> 9+以上的时间窗口选择：M1,  M5,  M15,  M30,  H1,  H4,  D1,  W1, MN</li>
                                    <li> 30+种以上技术指标</li>
                                    <li> 24+中以上的分析工具</li>
                                    <li> 金融市场新闻</li>
                                    <li> 与其他交易者进行免费聊天系统</li>
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
