@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', '驗證碼')
@section ('page-level-css')
<link type="text/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6">
                        <a href="/change-password"><h4 class="nav_top_align skin_txt">
                            <i class="fa fa-user"></i>
                           更改密碼
                        </h4>
                        </a>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="card">

                        <div class="card-block m-t-35">
							<h2>輸入驗證碼</h2>
							<h5>A 驗證碼已發送到 {!!session('login_email')!!}</h5>
							{!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/password-verification'), 'name' => 'verificationForm','class'=>'col-md-4']) !!}
					<div class="form-group">
                        
                            
                        {!! Form::text('verification_code', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入驗證碼']) !!}
                        
                            

                        <small class="text-danger">{{ $errors->first('verification_code') }}</small>
                        </div>
                        @if($errors->any())
                        <h5 style="color:red;">{{$errors->first()}}</h5>
                            @endif
                            
                            {!!Form::hidden('new_password',$request->new_password)!!}
                             
                        
                        
                        <div class="form-group">
                        {!!Form::submit('提交表格',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
					</div>
                        </div>
                    </div>
					</div>
                    
                    @endsection
                