
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
                        İşlem Platformunu İndir
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
                <td>PC için Metatrader 4 Ticaret Terminali</td>
                
                <td><a href="{{$download_link}}"> <button class="btn btn-success" type="submit"> İndir</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td>MAC için Metatrader 4 Ticaret Terminali</td>
                
                <td><a href="https://www.metatrader4.com/en/trading-platform/help/userguide/install_mac" target="_blank"><button class="btn btn-success" type="submit">İndir</button></a></td>
              </tr>
              
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> İPhone için Metatrader 4</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">İndir</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>Android için Metatrader 4</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit"> İndir</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> İPad için Metatrader 4</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">İndir</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>Android Tablet için Metatrader 4</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit"> İndir</button></a></td>
              </tr>
            </table>
            </div>
            <div class="col-md-5 " >
                        <div class="card m-t-25" style="border : 1px solid #f9f9f9">
                            
                            <div class="bank-info" style="padding: 0">
                                <ul style="list-style-type: unset">
                                    <li> Bir ticaret hesabı üzerinde tam kontrol.</li>
                                    <li> Her zaman ve her zaman erişin.</li>
                                    <li> Tüm sipariş türleri ve MetaTrader 4 yürütme modları.</li>
                                    <li> 3+ grafik türü: Barlar, Japon Şamdanları ve kırık bir çizgi.</li>
                                    <li> 9+ zaman dilimi: M1, M5, M15, M30, H1, H4, D1, W1 ve MN.</li>
                                    <li> 30+ teknik göstergeler.</li>
                                    <li>24+ analitik nesne.</li>
                                    <li> Finansal piyasa haberleri.</li>
                                    <li> Diğer tüccarlarla iletişim kurmak için ücretsiz sohbet.</li>
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
