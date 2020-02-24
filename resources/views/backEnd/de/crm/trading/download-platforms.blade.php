
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Plattform herunterladen')
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
                        Laden Sie die Handelsplattform herunter
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
                <td>Metatrader 4 Trading Terminal fur PC</td>
                
                <td><a href="{{$download_link}}"> <button class="btn btn-success" type="submit"> Herunterladen</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td>Metatrader 4 Trading Terminal fur MAC</td>
                
                <td><a href="https://www.metatrader4.com/en/trading-platform/help/userguide/install_mac" target="_blank"><button class="btn btn-success" type="submit">Download</button></a></td>
              </tr>
              
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> Metatrader 4 fur iPhone</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">Download</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>Metatrader 4 fur Android</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit"> Download</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-apple"></td>
                <td> Metatrader 4 fur iPad</td>
                
                <td><a href="https://itunes.apple.com/us/app/metatrader-4/id496212596?utm_campaign=www.metatrader4.com" target="_blank"><button class="btn btn-success" type="submit">Download</button></a></td>
              </tr>
              <tr>
                <td><i style="font-size:18px;color:#03A1D1" class="fa fa-android"></td>
                <td>Metatrader 4 fur Android Tablet</td>
                
                <td><a href="https://download.mql5.com/cdn/mobile/mt4/android?utm_source=www.metatrader4.com&utm_campaign=download" target="_blank"><button class="btn btn-success" type="submit"> Download</button></a></td>
              </tr>
            </table>
            </div>
            <div class="col-md-5 " >
                        <div class="card m-t-25" style="border : 1px solid #f9f9f9">
                            
                            <div class="bank-info" style="padding: 0">
                                <ul style="list-style-type: unset">
                                    <li> Vollständige Kontrolle über ein Handelskonto.</li>
                                    <li> Zugriff überall und jederzeit.</li>
                                    <li> Alle Auftragsarten und MetaTrader 4 Ausführungsmodi.</li>
                                    <li> 3+ Arten von Charts: Bars, japanische Candlesticks und eine gestrichelte Linie.</li>
                                    <li> 9+ Zeitrahmen: M1, M5, M15, M30, H1, H4, D1, W1 und MN.</li>
                                    <li> 30+ technische Indikatoren.</li>
                                    <li> 24+ analytische Objekte.</li>
                                    <li> Finanzmarktnachrichten.</li>
                                    <li> Ein kostenloser Chat für die Kommunikation mit anderen Händlern.</li>
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
