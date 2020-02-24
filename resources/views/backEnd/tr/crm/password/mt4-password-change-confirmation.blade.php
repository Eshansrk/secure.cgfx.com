
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Change MT4 Password')
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
                        MT4 şifresini değiştir
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            
 

            <!--top section widgets-->
           <p style="margin-top:50px;line-height: 50px;font-size: 32px;"><span style="color:green;">Congratulations.</span> Yeni İşlem Hesabı Şifreniz şu adrese gönderildi: <span style="font-weight: bold;">{{session('login_email')}}</span>.</p>

<h3>Hesap detayları:</h3>

            <table class="table table-borderd col-md-6">
                <tr>
                    <th>MT4 Giriş Kimliği: </th>
                    <td>{{$login}}</td>

                </tr>
                <tr>
                    <th>MT4 Şifre: </th>
                    <td>{{$password}}</td>
                </tr>
                
            <tr>
                <th>MT4 Sunucusu: </th>
                <td>{{$server}}
</td>
            </tr>
            <tr>
                <th>MT4 indir:</th>
                <td><a style="text-decoration: underline;" href="{{$download_link}}">Buradan İndirin</a></td>
            </tr>
 

            </table>
           <!--  <p>Note: To access your Trading Account on mobile (Android/Ios), kindly download the MT4 platform and seach for "CAPXM-Real" for Live accounts.</p> -->




    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>





























@endsection
