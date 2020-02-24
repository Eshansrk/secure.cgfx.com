
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '更改MT4投資者密碼')
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
                        更改MT4投資者密碼
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <p style="margin-top:50px;line-height: 50px;font-size: 32px;"><span style="color:green;">恭喜</span>您的交易賬戶投資者密碼已被發送至 <span style="font-weight: bold;">{{session('login_email')}}</span>.</p>

<h3>帳戶詳情:</h3>

            <table class="table table-borderd col-md-6">
                <tr>
                    <th>MT4 登錄 ID: </th>
                    <td>{{$login}}</td>

                </tr>
                <tr>
                    <th>MT4 Investor 密碼: </th>
                    <td>{{$investor_password}}</td>
                </tr>
                
            <tr>
                <th>MT4 服務器:</th>
                <td>{{$server}}
</td>
            </tr>
            <tr>
                <th>下載MT4:</th>
                <td><a style="text-decoration: underline;" href="{{$download_link}}">在這裡下載</a></td>
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
