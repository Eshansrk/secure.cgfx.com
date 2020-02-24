
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Open Ticket')
@section('page-level-css')

<!-- <link type="text/css" rel="stylesheet" href="/css/components2.css" /> -->

<link rel="stylesheet" type="text/css" href="{{asset('assets/backEnd/css/notification.css')}}">
<link href="/css/summernote.css" rel="stylesheet">
<style type="text/css">
    .modal-backdrop{
        position: relative;
    }
    .modal-open .modal{
        margin-top: 5%
    }
</style>
@endsection
@section('content')



<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-envelope-open"></i>
                        Açık bilet
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class="card">

                        <div class="card-block">

                        <!-- ticket opening form -->

                        <form class="form form-horizontal striped-rows form-bordered" action="{{LaravelLocalization::localizeURL('/store-ticket')}}" method="post">
                            {{csrf_field()}}
                            @if(session()->has('msg'))
                            <div class="alert alert-success">
                                {{session()->get('msg')}}
                            </div>
                            @endif
                <div class="row">
                	<div class="col-md-12">
                    <label class="label-control" style="padding-left: 0px;">konu</label>
                    
                        <select id="subject" name="subject" class="form-control" style="width: 25%" required>
                        	<option value="deposit">Depozito</option>
                        	<option value="withdraw">Çekil</option>
                            <option value="payment method">Ödeme şekli</option>
                        	<option value="other">Diğerleri</option>
                        </select>
                    
                	</div>
                	
                </div>  <br>

                <div class="row" id="other" style="display: none;">
                    <!-- <label class="col-md-2 label-control">Description</label> -->
                    <div class="col-md-12">
                        <input type="text" name="subject_other" class="form-control" style="width: 25%" placeholder="Specify Subject">
                    </div>
                </div> <br>

                <div class="row">
                    <label class="col-md-2 label-control">Açıklama</label>
                    <div class="col-md-12">
                        <textarea name="description" class="form-control ckeditor" id="summernote" required></textarea>
                    </div>
                </div> <br>

                

                
        	</div>
	        <div class="modal-footer">
	          <button type="submit" name="submit" class="btn btn-success">Gönder</button>
	        </div>
        	</form>
                            
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

<script src="/js/summernote.js"></script>
<!-- <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script> -->
<!-- <script type="text/javascript">

    function validate(form) {
    CKEDITOR.instances.newstext.updateElement();
    $('#newstext').toggle();
    validated = $(form).validationEngine('validate');
    $('#newstext').toggle();

    return validated;
}

$(function() {
    if (typeof CKEDITOR != 'undefined') {
        $('form').on('reset', function(e) {
            if ($(CKEDITOR.instances).length) {
                for (var key in CKEDITOR.instances) {
                    var instance = CKEDITOR.instances[key];
                    if ($(instance.element.$).closest('form').attr('name') == $(e.target).attr('name')) {
                        instance.setData(instance.element.$.defaultValue);
                    }
                }
            }
        });
    }
});
</script> -->
<script>
  $(document).ready(function() {
  $('#summernote').summernote({popover: {
         image: [],
         link: [],
         air: []
       }
   });
});
</script>
<script type="text/javascript">
 $(document).ready(function(){
    $('#subject').on('change',function(){
        var val = $('#subject').val();
        if (val == 'other') {
            $('#other').show('slow');
        } else{
            $('#other').hide('slow');
        }
    });
    var val = $('#subject').val();
        if (val == 'other') {
            $('#other').show('slow');
        } else{
            $('#other').hide('slow');
        }
    });
 </script>


@endsection



