@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '地址验证')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link rel="stylesheet" href="/css/dropzone.css">
<link rel="stylesheet" type="text/css" href="/assets/backEnd/css/notification.css">
@endsection
@section('content')
<div id="notification-ajax">
    <div class="noti-cross"><i class="fa fa-times" id="cross" onclick="closeNotiAjax()" aria-hidden="true"></i></div>
    <div id="noti-body-ajax">
        Document uploaded successfully
    </div>
</div>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-user"></i>
                        验证档案
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
                            <h4>地址验证</h4>
                        </div>
                        <div class="dropFile-notice-head">
                            <div class="dropFile-notice">
                                <button type="button" class="close"><i class="fa fa-close"></i></button>
                                <p> 依照 {{$general_info->company_name}} 遵守AML政策, 每个客户都必须通过验证流程。经验证的客户可以通过所有可用方法随时提取资金或存入交易账户.
                                    <br>
                                    要验证您的居住地址，请上传以下文件之一的照片或扫描副本:
                                    <br>
                                    <ul style="list-style: inside;padding: 0">
                                        <li>公用事业服务付款收据;</li>
                                        <li>银行对账单;</li>
                                        <li>帶有住址的當地護照的頁面（如果在那裡說明的地址與當前地址相符，並且您已上傳當地護照的第一頁作為您的身份證明）。</li>
                                    </ul>
                                    我们只接受彩色高分辨率照片或扫描档副本, 这些照片必须包含全名, 照片, 签名, 出生日期, 到期日期, 并且自申请之日起至少六个月有效。文档的四个边缘应该在照片上可见
                                    <br>
                                    我们将在二十四小时内检查上传的档(周末除外). 
                                </p>
                            </div>
                        </div>
                        <div class="dropFile">
                            <form action="{{LaravelLocalization::localizeURL('/resident-document-upload')}}" method="post" class="dropzone" id="DropZoneFiddle" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <span class="fa fa-download" style="font-size: 50px"></span>
                                <br>
                                <span style="font-size: 25px">将扫描副本放在此处或单击上传</span>
                                <br>
                                <small>(您可以上传jpg, jpeg, png, gif, tif, tiff, pdf格式的图片, 且不大于2MB)</small>
                                <br>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top: 5%">
                <div class="row">
                    <div class="col-md-12">
                        <div class="varification">
                            <h4>已上传档</h4>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>日期</th>
                                            <th>类型</th>
                                            <th>状态</th>
                                            <th>評論</th>
                                            <th>查看文檔</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doc as $key => $documents)
                                        <tr>
                                            <td>
                                                {{ Carbon\Carbon::parse($documents->date_time)->format('d-m-Y') }}</td>
                                                <td>{{$documents->document_type}}</td>
                                                <td>
                                                    @if($documents->status == 0)
                                                    <span style="color: #fc2">有待<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                                                    @elseif($documents->status == 1) 
                                                    <span style="color: green">批准<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span> 
                                                    @else  
                                                    <span style="color: tomato">取消<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                                                    @endif
                                                </td>
                                                <td>{!!$documents->reason!!}</td>
                                                <td>
                                                    <a href="{{$documents->document}}"><img src="/img/picture.png" width="10%"></a></td><img src="{{$documents->document}}" alt="" class="image-show">
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
<script type="text/javascript" src="/assets/backEnd/js/notification.js"></script>
<script src="/js/dropzone.js"></script>
<script type="text/javascript">
    $(function(){
        $('.image-show').hide();
        $('.image-icon').click(function(){
            $('.image-show').show();
            $('.image-show').hide();
        })
    })
</script>
<script>
    $(function(){
        Dropzone.options.DropZoneFiddle = {
  // url: this.location,
  paramName: "file", //the parameter name containing the uploaded file
  clickable: true,
  maxFilesize: 2, //in mb
  uploadMultiple: false, 
  maxFiles: 1, // allowing any more than this will stress a basic php/mysql stack
  acceptedFiles: '.png,.jpg,.jpeg,.gif,.tif,.tiff,.pdf', //allowed filetypes
  dictDefaultMessage: "在此处上传您的档", //override the default text
  init: function() {
    this.on("sending", function(file, xhr, formData) {
        formData.append("_token", document.getElementsByName("_token")[0].value);
      formData.append("step", "upload"); // Append all the additional input data of your form here!
  });
    this.on("success", function(file, responseText) {
      $('#notification-ajax').css('display','block');
      setTimeout(closeNotiAjax,4000);
      location.reload();
  });
}
};
function closeNotiAjax(){
   $('#notification-ajax').css('display','none');
}
$('.close').click(function(event) {
    $('.dropFile-notice-head').hide('slow');
});
});
</script>
@endsection