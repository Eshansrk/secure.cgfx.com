
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
                        下載交易Platform
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
                <td>Metatrader 4 PC交易終端</td>
                
                <td><a href="{{$download_link}}"> <button class="btn btn-success" type="submit"> 下載</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td>Metatrader 4 MAC交易終端</td>
                
                <td><a href="https://www.metatrader4.com/en/trading-platform/help/userguide/install_mac" target="_blank"><button class="btn btn-success" type="submit">下載</button></a></td>
              </tr>
              
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> 適用於iPhone的Metatrader 4</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">下載</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>適用於Android的Metatrader 4</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit">下載</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> 適用於iPad的Metatrader 4</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">下載</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>適用於Android平板電腦的Metatrader 4</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit">下載</button></a></td>
              </tr>
            </table>
            </div>
            <div class="col-md-5 " >
                        <div class="card m-t-25" style="border : 1px solid #f9f9f9">
                            
                            <div class="bank-info" style="padding: 0">
                                <ul style="list-style-type: unset">
                                    <li> 完全控制您的交易賬戶</li>
                                    <li> 隨時隨地訪問。</li>
                                    <li> 所有訂單類型和MetaTrader 4執行模式。</li>
                                    <li> 3+圖表類型：條形圖、日本蠟燭圖和折線圖。</li>
                                    <li> 9個以上時間範圍：M1，M5，M15，M30，H1，H4，D1，W1和MN。</li>
                                    <li> 30多項技術指標。</li>
                                    <li> 24個以上的分析對象。</li>
                                    <li> 金融市場新聞。</li>
                                    <li> 與其他交易者進行免費聊天。</li>
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
