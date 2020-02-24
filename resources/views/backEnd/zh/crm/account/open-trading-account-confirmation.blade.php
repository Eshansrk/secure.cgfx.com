@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '开立交易账户')
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
                        开立交易账户
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <p style="margin-top:50px;line-height: 50px;font-size: 32px;">
                <span style ="color: green;">祝贺。</span>
                您的模拟账户明细已发送至
                <span style ="font-weight：bold;"> {{session（'login_email'）}} </span>
            </p>
            <h3>帐户详细资料:</h3>
            <table class="table table-borderd col-md-6">
                <tr>
                    <th>MT4登录ID: </th>
                    <td>{{$login_id}}</td>
                </tr>
                <tr>
                    <th>MT4密码: </th>
                    <td>{{$password}}</td>
                </tr>
                <tr>
                    <th>MT4投资者密码: </th>
                    <td>{{$investor_password}}</td>
                </tr>
                <tr>
                    <th>MT4服务器: </th>
                    <td>{{$server_client}}
                    </td>
                </tr>
                <tr>
                    <th>下载MT4:</th>
                    <td><a style="text-decoration: underline;" href="{{$download_link}}">在这里下载</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
</div>
@endsection