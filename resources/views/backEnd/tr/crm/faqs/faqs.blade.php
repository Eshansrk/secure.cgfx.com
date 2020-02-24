@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', 'Faqs') 
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<style>
    @media (min-width: 1367px) {
        #outer {
            position: absolute;
            width: 100%;
            top: 100%;
            margin-top: 0px
        }
    }
</style>
@endsection
 
@section('content')

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6">
                <a href="/faqs">
                    <h4 class="nav_top_align skin_txt">
                        <i class="fa fa-question-circle"></i> sık sorulan Sorular
                    </h4>
                </a>
            </div>

        </div>
    </header>
    <div class="outer">
        <div class="row">
            <div class="col-lg-10 m-t-35">
                <div class="card" style="border: none;">

                    <div class="card-block">
                        <div class="col-md-8 m-t-10 accordian_alignment">
                            <div id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="card" style="border: none;">
                                    <div class="card-header bg-white" role="tab" id="title-one" style="border: none;background: #f9f9f9;">
                                        <a class="accordion-section-title first-icon collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-one"
                                            aria-expanded="false">
                                            
                                             <i class="fa fa-chevron-up  m-t-5"></i>
                                            
                                            Bir Partners Hesabını nasıl açılırum?
                                        </a>

                                    </div>
                                    <div id="card-data-one" class="card-collapse collapse" aria-expanded="false" style="">
                                        <div class="card-block m-t-20">
                                            <p class="text-justify">
                                                Visit <a target="_blank" href="{{$general_info->client_portal_url}}"> {{$general_info->client_portal_url}}</a>                                             ve açık canlı hesabı tıklayın.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card m-t-20" style="border: none;">
                                    <div class="card-header bg-white" role="tab" id="title-two" style="border: none;background: #f9f9f9;">
                                        <a class="accordion-section-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-two" aria-expanded="false">
                                             <i class="fa fa-chevron-up m-t-5"></i>
                                            IB bağlantımı nereden alırım?
                                        </a>
                                    </div>
                                    <div id="card-data-two" class="card-collapse collapse" aria-expanded="false" style="">
                                        <div class="card-block m-t-20">
                                            <p class="text-justify">
                                                Müşteri alanınıza girdikten sonra, IB Yönlendirme Bağlantınızı göreceksiniz.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card m-t-20" style="border: none;">
                                    <div class="card-header bg-white" role="tab" id="title-three" style="border: none;background: #f9f9f9;">
                                        <a class="accordion-section-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-three" aria-expanded="false">
                                             <i class="fa fa-chevron-up m-t-5"></i>
                                            Altında kayıtlı müşterileri nasıl görebilirim?
                                        </a>
                                    </div>
                                    <div id="card-data-three" class="card-collapse collapse" aria-expanded="false" style="">
                                        <div class="card-block m-t-20">
                                            <p class="text-justify">
                                                Ortaklar Sunucunuza Giriş Yapın Hesaplardan bir simge göreceksiniz, bu size kayıtlı hesap sayısını gösterir
                                                IB bağlantınızın altında.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card m-t-20" style="border: none;">
                                    <div class="card-header bg-white" role="tab" id="title-four" style="border: none;background: #f9f9f9;">
                                        <a class="accordion-section-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-four" aria-expanded="false">
                                             <i class="fa fa-chevron-up m-t-5"></i>
                                            IB Komisyonlarımı Nasıl Görüntüleyebilirim?
                                        </a>
                                    </div>
                                    <div id="card-data-four" class="card-collapse collapse" aria-expanded="false" style="">
                                        <div class="card-block m-t-20">
                                            <p class="text-justify">
                                                Partners Dashboard'unuza giriş yapın ve Kazançları göreceksiniz.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
 
@section('page-level-js')
<script type="text/javascript">
    $(function(){
                          $('.accordion-section-title').click(function(){
                            // $(this).find('i').toggleClass('fa-chevron-up');
                            $(this).find('i').toggleClass('fa-chevron-down');
                          })
                    })
</script>
@endsection