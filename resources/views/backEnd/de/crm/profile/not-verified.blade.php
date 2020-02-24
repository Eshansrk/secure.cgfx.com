
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
                        Verify Profile
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
                                            <h4>Identity Verification</h4>
                                        </div>
                                        <div class="dropFile-notice-head">
                                            
                                        <div class="dropFile-notice">
                                            <button type="button" class="close"><i class="fa fa-close"></i></button>
                                            <p>Since ForexCRM adheres to AML policy, each client has to pass verification procedure. Verified clients withdraw funds freely and deposit trading accounts via all available methods.
                                            <br>
                                            To verify your personality, please, upload photos or scan copies of one of the following documents:
                                            <br>
                                            <ul style="list-style: inside;padding: 0">
                                                <li>local passport (ID, IC);</li>
                                                <li>international passport;</li>
                                                <li>driver's license.</li>
                                            </ul>
                                            
                                            We accept only color high-resolution photos or scan copies of documents which should surely contain full name, photo, signature, date of birth, expiration date and be valid for at least 6 months from the moment of applying. The 4 edges of the document should be visible on the photo.
                                            <br>
                                            We will check uploaded documents within 24 hours (except from weekends). 
                                            </p>

                                        </div>
                                        </div>
                                        <div class="dropFile">

                                        <form action="" class="dropzone" id="DropZoneFiddle">
                                          <span class="fa fa-download" style="font-size: 50px"></span>
                                          <br>
                                          <span style="font-size: 25px">Drop your scan copy here or click to upload</span>
                                          <br>
                                          <small>You can upload pictures in jpg, jpeg, png, gif, tif, tiff formats and which is not larger than 10МB</small>
                                          <br>
                                        </form>

                                        <div class="upload_button">
                                            <a href="" style="padding: 12px;background: #26C281;color: #fff;border-radius: 5px;font-size: 16px">Upload</a>
                                        </div>
                                            
                                        </div>
                                        
                                    
                                    </div>

                                                                        
                                </div>
                            
                        </div>

                        <div class="card" style="margin-top: 5%">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="varification">
                                        <h4>Uploaded documents</h4>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>Comment</th>
                                                        <th>View Document</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>20.10.18</td>
                                                        <td>Normal</td>
                                                        <td>Verified</td>
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