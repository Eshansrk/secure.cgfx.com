
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Resident details')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link rel="stylesheet" href="/css/dropzone.css">
<link rel="stylesheet" type="text/css" href="/assets/backEnd/css/notification.css">
@endsection
@section('content')

<div id="notification-ajax">
    <div class="noti-cross"><i class="fa fa-times" id="cross" onclick="closeNotiAjax()" aria-hidden="true"></i></div>
    <div id="noti-body-ajax">
        Belge başarıyla yüklendi
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-user"></i>
                        Profili Doğrula
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
                                            <h4>
                                                İkamet Doğrulama</h4>
                                        </div>
                                        <div class="dropFile-notice-head">
                                            
                                        <div class="dropFile-notice">
                                            <button type="button" class="close"><i class="fa fa-close"></i></button>
                                            <p>Dan beri {{$general_info->company_name}} AML politikasına bağlı, her müşterinin doğrulama prosedürünü geçmesi gerekiyor. Doğrulanmış müşteriler serbestçe para çekerler ve tüm mevcut yöntemlerle ticaret hesaplarını yatırırlar.
                                            <br>
                                            
                                               İkamet adresinizi doğrulamak için lütfen fotoğraf yükleyin veya aşağıdaki belgelerin kopyalarını tarayın:
                                            <br>
                                            <ul style="list-style: inside;padding: 0">
                                                <li>hizmet hizmetleri ödemesinin alınması;</li>
                                                <li>hesap durumu;</li>
                                                <li>Yerleşim adresi bulunan yerel pasaportun sayfası (eğer adreste belirtilen adres mevcut adresle eşleşiyorsa ve kimliğinizin bir kanıtı olarak yerel pasaportun ilk sayfasını yüklediyseniz).</li>
                                            </ul>
                                            
                                            Yüksek çözünürlüklü renkli fotoğrafları kabul ediyoruz veya tam adınız ve adresinizin açıkça görüldüğü ve profilinizde belirtilen verileri eşleştiren belgelerin kopyalarını taramıyoruz. Belge en geç 3 ay önce yayınlanmalıdır. Belgenin 4 kenarı fotoğrafta görünmelidir.
                                            <br>
                                           Yüklenen belgeleri 24 saat içinde kontrol edeceğiz (hafta sonları hariç).
                                            </p>

                                        </div>
                                        </div>
                                        <div class="dropFile">
                                        
                                        <form action="{{LaravelLocalization::localizeURL('/resident-document-upload')}}" method="post" class="dropzone" id="DropZoneFiddle" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                          <span class="fa fa-download" style="font-size: 50px"></span>
                                          <br>
                                          <span style="font-size: 25px">Tarama kopyanızı buraya bırakın veya yüklemek için tıklayın</span>
                                          <br>
                                          <small>Resimleri jpg, jpeg, png, gif, tif, tiff, pdf formatlarında ve 2 МB'den daha büyük olmayan resimlere yükleyebilirsiniz.</small>
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
                                        <h4>Yüklenen dokümanlar</h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>tarih</th>
                                                        <th>tip</th>
                                                        <th>durum</th>
                                                        <th>Yorum Yap</th>
                                                        <th>Belgeyi Görüntüle</th>
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
                                                            <span style="color: #fc2">Pending<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                                                            @elseif($documents->status == 1) 
                                                            <span style="color: green">Approved<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span> 

                                                            @else  
                                                            <span style="color: tomato">Cancelled<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
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
  dictDefaultMessage: "Upload your file here", //override the default text
  init: function() {
    this.on("sending", function(file, xhr, formData) {
    formData.append("_token", document.getElementsByName("_token")[0].value);
      formData.append("step", "upload"); // Append all the additional input data of your form here!
      
    });
    this.on("success", function(file, responseText) {
      //auto remove buttons after upload
      
      //$("#div-files").html(responseText);
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