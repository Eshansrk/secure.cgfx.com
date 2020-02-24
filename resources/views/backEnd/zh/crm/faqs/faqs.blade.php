@extends('backEnd.'.app()->getLocale().'.dashboard.layout') 
@section('title', '常见问题') 
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
                        <i class="fa fa-question-circle"></i> 常见问题
                    </h4>
                </a>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
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
                                        如何开设IB代理账户?
                                    </a>
                                </div>
                                <div id="card-data-one" class="card-collapse collapse" aria-expanded="false" style="">
                                    <div class="card-block m-t-20">
                                        <p class="text-justify">
                                            访问 <a target="_blank" href="{{$general_info->client_portal_url}}"> {{$general_info->client_portal_url}}</a>                                                并点击打开真实账户。
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-t-20" style="border: none;">
                                <div class="card-header bg-white" role="tab" id="title-two" style="border: none;background: #f9f9f9;">
                                    <a class="accordion-section-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-two" aria-expanded="false">
                                         <i class="fa fa-chevron-up m-t-5"></i>
                                        我在哪里获取我的IB链接？
                                    </a>
                                </div>
                                <div id="card-data-two" class="card-collapse collapse" aria-expanded="false" style="">
                                    <div class="card-block m-t-20">
                                        <p class="text-justify">
                                            登录到您的客户区后，您将看到您的IB推荐链接
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-t-20" style="border: none;">
                                <div class="card-header bg-white" role="tab" id="title-three" style="border: none;background: #f9f9f9;">
                                    <a class="accordion-section-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-three" aria-expanded="false">
                                         <i class="fa fa-chevron-up m-t-5"></i>
                                        如何查看在我下注册的客户？
                                    </a>
                                </div>
                                <div id="card-data-three" class="card-collapse collapse" aria-expanded="false" style="">
                                    <div class="card-block m-t-20">
                                        <p class="text-justify">
                                            从您的合作伙伴仪表板登录您将看到一个名为accounts的图标，它会显示已注册帐户的数量
                                            在您的IB链接下。
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-t-20" style="border: none;">
                                <div class="card-header bg-white" role="tab" id="title-four" style="border: none;background: #f9f9f9;">
                                    <a class="accordion-section-title collapsed" data-toggle="collapse" data-parent="#accordion" href="#card-data-four" aria-expanded="false">
                                         <i class="fa fa-chevron-up m-t-5"></i>
                                        我如何查看我的IB委员会？
                                    </a>
                                </div>
                                <div id="card-data-four" class="card-collapse collapse" aria-expanded="false" style="">
                                    <div class="card-block m-t-20">
                                        <p class="text-justify">
                                            登录您的合作伙伴信息中心，您将看到收入。
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
        $(this).find('i').toggleClass('fa-chevron-down');
    })
  })
</script>
@endsection