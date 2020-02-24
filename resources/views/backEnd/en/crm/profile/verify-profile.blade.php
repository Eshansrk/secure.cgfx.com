
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
                            <h4>Profile Verification : 
                            @if($status==2)
                           
                            <span style="color: green">Verified<i class="fa fa-check profile-verification-icon" aria-hidden="true"></i></span>
                           
                            @elseif($status==0)
                            <span style="color: tomato">Not Verified<i class="fa fa-times profile-verification-icon" aria-hidden="true"></i></span>
                            
                             @else
                            <span style="color: #fc2">Partially Verified<i class="fa fa-info profile-verification-icon" aria-hidden="true"></i></span>
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
                                                        <p>Identity Verification</p>
                                                        <p>Color high-resolution scan copies or photos of a document, which verifies your personality with full name, photo, signature, date of birth, expiration date are clearly seen and which is valid for at least 6 months from the moment of applying.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="position: relative;">
                                                    <div class="details-button">
                                                        <a href="/identity-documents-details">Details</a>
                                                    </div>
                                                    <div class="verify-button">
                                                        <a href="/not-verified">Verify Now</a>
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
                                                        <p>Residence Verification</p>
                                                        <p>Color high-resolution scan copies or photos of a document where your full name and address are clearly seen and match the data indicated in your profile. The document should be issued not later than 3 months ago. </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="position: relative;">
                                                    <div class="details-button">
                                                        <a href="/resident-documents-details">Details</a>
                                                    </div>
                                                    <div class="verify-button">
                                                        <a href="/not-verified">Verify Now</a>
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
                                                @foreach($doc as $key => $documents)
                                                    <tr>
                                                        <td>{{ Carbon\Carbon::parse($documents->date_time)->format('d-m-Y') }}</td>
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
