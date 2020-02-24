
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '身份資料')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link rel="stylesheet" href="/css/dropzone.css">
<link rel="stylesheet" type="text/css" href="/assets/backEnd/css/notification.css">
@endsection
@section('content')
<div id="notification-ajax">
    <div class="noti-cross"><i class="fa fa-times" id="cross" onclick="closeNotiAjax()" aria-hidden="true"></i></div>
    <div id="noti-body-ajax">
        檔案已成功上載
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-user"></i>
                        驗證資料
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
                                            <h4>身份驗證</h4>
                                        </div>
                                        <div class="dropFile-notice-head">
                                            
                                        <div class="dropFile-notice">
                                            <button type="button" class="close"><i class="fa fa-close"></i></button>
                                            <p>由於 {{$general_info->company_name}}遵循AML政策，每個客戶都必須通過驗證程式。經核實的客戶可以自由選取資金，並通過各種方式存入交易帳戶。
                                            <br>
                                            若要驗證您的個性，請上載照片或掃描以下檔案之一的副本:
                                            <br>
                                            <ul style="list-style: inside;padding: 0">
                                                <li>本地護照（身份證、IC；</li>
                                                <li>國際護照；</li>
                                                <li>駕駛執照.</li>
                                            </ul>
                                            
                                            我們只接受彩色高解析度照片或掃描檔案副本，這些檔案必須包含全名、照片、簽名、出生日期、有效期，並且自申請之日起至少6個月內有效。檔案的4個邊緣應在照片上可見。
                                            <br>
                                            我們將在24小時內檢查上傳的檔案（週末除外）。
                                            </p>

                                        </div>
                                        </div>
                                        <div class="dropFile">
                                       

                                        <form action="{{LaravelLocalization::localizeURL('/identity-document-upload')}}" method="post" class="dropzone" id="DropZoneFiddle" enctype="multipart/form-data">
                                        	{{csrf_field()}}
                                          <span class="fa fa-download" style="font-size: 50px"></span>
                                          <br>
                                          <span style="font-size: 25px">將掃描副本放在此處或按一下以上載</span>
                                          <br>
                                          <small>您可以上傳JPG、JPEG、PNG、GIF、TIF、TIFF、PDF格式的圖片，圖片大小不超過2 mM B。</small>
                                          <br>
                                          

                                        <!-- <div class="upload_button">
                                            <button type="submit" style="padding: 12px;background: #26C281;color: #fff;border-radius: 5px;font-size: 16px">Upload</button>
                                        </div> -->
                                        </form>  
                                        </div>
                                    </div>
                                 
                                </div>
                            
                        </div>

                        <div class="card" style="margin-top: 5%">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="varification">
                                        <h4>已上傳文件</h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>日期</th>
                                                        <th>種類</th>
                                                        <th>狀態</th>
                                                        <th>評論</th>
                                                        <th>查看文件</th>
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
                                                            <span style="color: #fc2">待確定<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
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
  // addRemoveLinks: true,
  acceptedFiles: '.png,.jpg,.jpeg,.gif,.tif,.tiff,.pdf', //allowed filetypes
  dictDefaultMessage: "在此處上載檔案", //override the default text
  init: function() {
    this.on("sending", function(file, xhr, formData) {
    formData.append("_token", document.getElementsByName("_token")[0].value);
      formData.append("step", "upload"); // Append all the additional input data of your form here!
      
    });
    this.on("success", function(file, responseText) {
      //auto remove buttons after upload
      // alert(responseText);
      // $("#div-files").html(responseText);
      //var _this = this;
      //_this.removeFile(file);
      $('#notification-ajax').css('display','block');
      setTimeout(closeNotiAjax,4000);
      location.reload();
    });
    // this.on("addedfile", function(file){
    //     alert('Upload File?');
    // });
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