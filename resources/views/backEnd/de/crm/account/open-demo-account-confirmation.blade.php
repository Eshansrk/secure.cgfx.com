
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Öffnen Sie das Demo-Konto')
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
                        <i class="fa fa-home"></i>
                        Öffnen Sie das Demo-Konto
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <p style="margin-top:50px;line-height: 50px;font-size: 32px;"><span style="color:green;">Herzliche Glückwünsche.</span> Ihre Handelskontodaten werden an <span style="font-weight: bold;">{{session('login_email')}}</span> gesendet.</p>
            <h3>Kontodetails:</h3>

            <table class="table table-borderd col-md-6">
                <tr>
                    <th>MT4 Anmelde-ID: </th>
                    <td>{{$login_id}}</td>

                </tr>
                <tr>
                    <th>MT4 Passwort: </th>
                    <td>{{$password}}</td>
                </tr>
                <tr>
                    <th>MT4 Investor Passwort: </th>
                    <td>{{$investor_password}}</td>
                </tr>
                <tr>
                    <th>MT4 Server: </th>
                    <td>{{$server}}</td>
                </tr>
                
            
            <tr>
                <th>Download MT4:</th>
                <td><a style="text-decoration: underline;" href="{{$download_link}}">Hier herunterladen</a></td>
            </tr>
 

            </table>
            





    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>





























@endsection
