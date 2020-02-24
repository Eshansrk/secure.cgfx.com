
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Verify Profile')
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
                            <h4>Profil Doğrulama:
                            @if($status==2)
                           
                            <span style="color: green">Doğrulanmış<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span>
                           
                            @elseif($status==0)
                            <span style="color: tomato">Doğrulanmadı<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                            
                             @else
                            <span style="color: #fc2">Kısmen Doğrulanmış<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
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
                                                        <p>kimlik doğrulama</p>
                                                        <p>Kişiliğinizi tam adı, fotoğrafı, imzası, doğum tarihi, son kullanma tarihi ile doğrulayan ve başvurunun yapıldığı andan itibaren en az 6 ay boyunca geçerli olan bir belgenin yüksek çözünürlüklü renkli tarama kopyaları veya fotoğrafları.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="position: relative;">
                                                    <div class="details-button">
                                                        <a href="/identity-documents-details">ayrıntılar</a>
                                                    </div>
                                                    <div class="verify-button">
                                                        <a href="/not-verified">Şimdi doğrulayın</a>
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
                                                        <p>İkamet Doğrulama</p>
                                                        <p>Yüksek çözünürlüklü renkli tarama, tam adınızın ve adresinizin açıkça görüldüğü ve profilinizde belirtilen verileri eşleştiren bir belgenin kopyasını veya fotoğraflarını kopyalar. Belge en geç 3 ay önce yayınlanmalıdır. </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="position: relative;">
                                                    <div class="details-button">
                                                        <a href="/resident-documents-details"> ayrıntılar</a>
                                                    </div>
                                                    <div class="verify-button">
                                                        <a href="/not-verified">Şimdi doğrulayın</a>
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
                                                        <td>{{ Carbon\Carbon::parse($documents->date_time)->format('d-m-Y') }}</td>
                                                        <td>{{$documents->document_type}}</td>
                                                        <td>
                                                            @if($documents->status == 0)
                                                            <span style="color: #fc2">kadar<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
                                                            @elseif($documents->status == 1) 
                                                            <span style="color: green">onaylı<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span> 

                                                            @else  
                                                            <span style="color: tomato">İptal edildi<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
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
