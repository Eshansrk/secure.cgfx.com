
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Open Demo Account')
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
                        Demo Hesabı Aç
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <p style="margin-top:50px;line-height: 50px;font-size: 32px;"><span style="color:green;">Tebrikler.</span> Demo Hesap Ayrıntıları'na gönderildi <span style="font-weight: bold;">{{session('login_email')}}</span>.</p>
            <h3>Hesap detayları:</h3>

            <table class="table table-borderd col-md-6">
                <tr>
                    <th>MT4 Giriş Kimliği: </th>
                    <td>{{$login_id}}</td>

                </tr>
                <tr>
                    <th>MT4 Şifre: </th>
                    <td>{{$password}}</td>
                </tr>
                <tr>
                    <th>MT4 Yatırımcı Şifresi: </th>
                    <td>{{$investor_password}}</td>
                </tr>
                <tr>
                    <th>MT4 Sunucusu: </th>
                    <td>{{$server}}</td>
                </tr>
                
            
            <tr>
                <th>MT4 indir:</th>
                <td><a style="text-decoration: underline;" href="{{$download_link}}">Buradan İndirin</a></td>
            </tr>
 

            </table>
            

    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>





























@endsection
