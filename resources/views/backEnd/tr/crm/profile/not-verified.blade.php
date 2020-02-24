
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Profile details')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link rel="stylesheet" href="/css/dropzone.css">
@endsection
@section('content')

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
                                            <h4>kimlik doğrulama</h4>
                                        </div>
                                        <div class="dropFile-notice-head">
                                            
                                        <div class="dropFile-notice">
                                            <button type="button" class="close"><i class="fa fa-close"></i></button>
                                            <p>ForexCRM, AML politikasına bağlı olduğundan, her müşterinin doğrulama prosedürünü geçmesi gerekir. Doğrulanmış müşteriler serbestçe para çekerler ve tüm mevcut yöntemlerle ticaret hesaplarını yatırırlar.
                                            <br>
                                            Kişiliğinizi doğrulamak için lütfen fotoğraf yükleyin veya aşağıdaki belgelerin kopyalarını tarayın:
                                            <br>
                                            <ul style="list-style: inside;padding: 0">
                                                <li>yerel pasaport (ID, IC);</li>
                                                <li>Uluslararası pasaport;</li>
                                                <li>Ehliyet.</li>
                                            </ul>
                                            
                                            Yalnızca yüksek çözünürlüklü renkli fotoğrafları kabul eder veya tam ad, fotoğraf, imza, doğum tarihi, son kullanma tarihi içermesi ve başvuru tarihinden itibaren en az 6 ay boyunca geçerli olması gereken belgelerin kopyalarını kabul ederiz. Belgenin 4 kenarı fotoğrafta görünmelidir.
                                            <br>
                                           
                                             Yüklenen belgeleri 24 saat içinde kontrol edeceğiz (hafta sonları hariç).
                                            </p>

                                        </div>
                                        </div>
                                        <div class="dropFile">

                                        <form action="" class="dropzone" id="DropZoneFiddle">
                                          <span class="fa fa-download" style="font-size: 50px"></span>
                                          <br>
                                          <span style="font-size: 25px">Tarama kopyanızı buraya bırakın veya yüklemek için tıklayın</span>
                                          <br>
                                          <small>
                                            Resimleri jpg, jpeg, png, gif, tif, tiff formatlarında yükleyebilir ve 10МB'dan daha büyük değildir.</small>
                                          <br>
                                        </form>

                                        <div class="upload_button">
                                            <a href="" style="padding: 12px;background: #26C281;color: #fff;border-radius: 5px;font-size: 16px">Yükleme</a>
                                        </div>
                                            
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
                                                    <tr>
                                                        <td>20.10.18</td>
                                                        <td>Normal</td>
                                                        <td>Doğrulanmış</td>
                                                        <td>N/A</td>
                                                        <td><img src="/img/house.png" alt="" width="30px"></td>
                                                    </tr>
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
<script src="/js/dropzone.js"></script>
<script>
    $(function(){
        Dropzone.options.DropZoneFiddle = {
  url: this.location,
  paramName: "file", //the parameter name containing the uploaded file
  clickable: true,
  maxFilesize: 10, //in mb
  uploadMultiple: false, 
  maxFiles: 1, // allowing any more than this will stress a basic php/mysql stack
  addRemoveLinks: true,
  acceptedFiles: '.png,.jpg,.jpeg,.gif,.tif,.tiff', //allowed filetypes
  dictDefaultMessage: "Upload your file here", //override the default text
  init: function() {
    this.on("sending", function(file, xhr, formData) {
      //formData.append("step", "upload"); // Append all the additional input data of your form here!
      //formData.append("id", "1"); // Append all the additional input data of your form here!
      //alert('hd');
    });
    this.on("success", function(file, responseText) {
      //auto remove buttons after upload
      
      //$("#div-files").html(responseText);
      //var _this = this;
      //_this.removeFile(file);
      alert('done');
    });
    // this.on("addedfile", function(file){
    //     alert('Upload File?');
    // });
  }
};

$('.close').click(function(event) {
    $('.dropFile-notice-head').hide('slow');
});
    });
</script>
@endsection