@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', 'Verification Code')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6">
                        <a href="/withdraw"><h4 class="nav_top_align skin_txt">
                            <i class="fa fa-user"></i>
                            Yatırımcı MT4 Parolasını Değiştirin
                        </h4>
                        </a>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="">
                        <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li "> 1. Şifrenizi Değiştirin</li>
                                        <li class="second-li selected">2. Kodu Onayla </li>
                                    </ul>
                                </div>
                            </div>

                        <div class="card-block">
							<h2>Dogrulama kodunu giriniz</h2>
							<h5>Bir doğrulama kodu gönderilir {!!session('login_email')!!}</h5>
							{!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/mt4-investor-password-verification'), 'name' => 'verificationForm','class'=>'col-md-4']) !!}
					<div class="form-group">
                        
                            
                        {!! Form::text('verification_code', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter verification code']) !!}
                        
                            

                        <small class="text-danger">{{ $errors->first('verification_code') }}</small>
                        </div>
                        @if($errors->any())
                        <h5 style="color:red;">{{$errors->first()}}</h5>
                            @endif
                            
                            {!!Form::hidden('account_no',$request->account_no)!!}
                             
                              {!!Form::hidden('investor_password',$request->investor_password)!!}
                        
                        
                        <div class="form-group">
                        {!!Form::submit('Submit',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
					</div>
                        </div>
                    </div>
					</div>
                </div>
                    
                    @endsection
                