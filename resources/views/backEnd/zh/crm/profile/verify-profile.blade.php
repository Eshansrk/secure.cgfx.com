@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '验证账户信息')
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
                        <i class="fa fa-check-square-o"></i>
                        验证账户信息
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <!--top section widgets-->
            <div class="card">                                 
                <div class="row">
                    <div class="col-md-12">
                        <div class="varification">
                            <h4>个人资料验证 : 
                                @if($status==2)
                                <span style="color: green">已验证<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span>
                                @elseif($status==0)
                                <span style="color: tomato">未驗證<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                                @else
                                <span style="color: #fc2">部分驗證<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                                @endif
                            </h4>
                        </div>
                        <div class="row">
                            <div class="identity-verification m-b-20">
                                <div class="col-md-1">
                                    <div class="left-img">
                                        <img src="/img/user-avatar-with-check-mark.png" alt="">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="des-identity">
                                        <p>身份验证</p>
                                        <p>彩色高分辨率扫描副本或文档照片, 可以清楚地看到您的身份, 包括全名, 照片, 签名, 出生日期, 到期日期, 并且自申请之日起至少有效期为六个月</p>
                                    </div>
                                </div>
                                <div class="col-md-3" style="position: relative;">
                                    <div class="details-button">
                                        <a href="/identity-documents-details">细节</a>
                                    </div>
                                    <div class="verify-button">
                                        <a href="/not-verified">立即驗證</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="identity-verification">
                                <div class="col-md-1">
                                    <div class="left-img">
                                        <img src="/img/house.png" alt="">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="des-identity">
                                        <p>已验证住址信息</p>
                                        <p>彩色高分辨率扫描副本或文档照片, 其中可以清楚地看到您的全名和地址, 并与您的个人资料中指示的数据相匹配。档日期应在最近三个月内。 </p>
                                    </div>
                                </div>
                                <div class="col-md-3" style="position: relative;">
                                    <div class="details-button">
                                        <a href="/resident-documents-details">细节</a>
                                    </div>
                                    <div class="verify-button">
                                        <a href="/not-verified">立即驗證</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top: 5%">
                <div class="row">
                    <div class="col-md-12">
                        <div class="varification">
                            <h4>上传档</h4>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>日期</th>
                                            <th>类型</th>
                                            <th>状态</th>
                                            <th>评论</th>
                                            <th>查看文檔</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doc as $key => $documents)
                                        <tr>
                                            <td>{{ Carbon\Carbon::parse($documents->date_time)->format('d-m-Y') }}</td>
                                            <td>{{$documents->document_type}}</td>
                                            <td>
                                                @if($documents->status == 0)
                                                <span style="color: #fc2">有待<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                                                @elseif($documents->status == 1) 
                                                <span style="color: green">已批准<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span> 
                                                @else  
                                                <span style="color: tomato">已取消<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                                                @endif
                                            </td>
                                            <td>{!!$documents->reason!!}</td>
                                            <td>
                                                <a href="{{$documents->document}}"><img src="/img/picture.png" width="10%"></a></td><img src="{{$documents->document}}" alt="" class="image-show lazy">
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
@section('page-level-js')
<script type="text/javascript">
    $(function(){
        $('.image-show').hide();
        $('.image-icon').click(function(){
            $('.image-show').show();
            $('.image-show').hide();
        });
        $('.lazy').Lazy();
    });
</script>
@endsection