@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title')
门票详情
@endsection
@section('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/backEnd/css/ticket_details.css')}}">
@endsection
@section('content')
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-user"></i>
                        门票详情
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <!--top section widgets-->
            <section id="text-inputs">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" style="font-weight: normal;">{{$tickets['subject']}}</h4>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <!-- comment box -->
                                    <div>
                                        <p>{!!$tickets['description']!!}</p> <span style="opacity: .5">{{Carbon\Carbon::createFromTimeStamp(strtotime($tickets['created_at']))->diffForHumans()}}</span>
                                        <ul id="comments-list" class="comments-list">
                                            <li>
                                                @foreach($comments as $key => $comment)
                                                @if($comment->commentator == 'admin')
                                                <ul class="comments-list reply-list admin-comment">
                                                    <li>
                                                        <div class="comment-avatar"><img src="{{asset('assets/img/user.png')}}" alt=""></div>
                                                        <!-- header -->
                                                        <div class="comment-box admin-comment-box">
                                                            <div class="comment-head">
                                                                <h6 class="comment-name">Admin</h6>
                                                                <span>{{Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}</span>
                                                            </div>
                                                            <div class="comment-content">
                                                             {!!$comment->comment!!}
                                                         </div>
                                                     </div>
                                                 </li>
                                             </ul>
                                             @else
                                             <!-- admin reply -->
                                             <ul class="comments-list reply-list">
                                                <li>
                                                    <!-- admin image -->
                                                    <div class="comment-avatar"><img src="{{asset('assets/img/admin.png')}}" alt=""></div>
                                                    <!-- admin header -->
                                                    <div class="comment-box">
                                                        <div class="comment-head">
                                                            <h6 class="comment-name">You</h6>
                                                            <span>{{Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}</span>
                                                        </div>
                                                        <div class="comment-content">
                                                         {!!$comment->comment!!}
                                                     </div>
                                                 </div>
                                             </li>
                                         </ul>
                                         @endif
                                         @endforeach
                                     </li>
                                 </ul>
                                 <form class="form" action="{{LaravelLocalization::localizeURL('/store-ticket-message')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="reply">答复</label>
                                                    <textarea id="reply" class="form-control border-primary" name="reply" required="required" style="width: 99.8%"></textarea>
                                                </div>
                                                <input type="number" name="ticket_id" value="{{$tickets->id}}" style="display: none;">
                                                <input type="number" name="user_id" value="{{$tickets->user_id}}" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button type="submit" name="submit" class="btn btn-primary" style="margin-left: 1%;">
                                                <i class="icon-check2"></i> 提交
                                            </button>
                                        </div>
                                    </div>
                                </form> 
                            </div><!-- end comment box --> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 
</div>
<!-- /.inner -->
</div>
</div>
</div>
</div>
@endsection
@section('page-level-js')
@endsection