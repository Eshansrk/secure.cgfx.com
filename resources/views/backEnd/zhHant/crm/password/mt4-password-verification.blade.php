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
                        <a href="/withdraw"><h4 class="nav_top_align skin_txt">
                            <i class="fa fa-user"></i>
                           更改 MT4 密碼
                        </h4>
                        </a>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class=" ">
                        <div class="row">
                                <div class="col-md-12">
                                    <ul class="up-barcurb">
                                        <li class="first-li "> 1. 選擇您的密碼</li>
                                        <li class="second-li selected"> 2. 確認代碼 </li>
                                    </ul>
                                </div>
                            </div>

                        <div class="card-block">
							<h2>輸入驗證碼</h2>
							<h5>A 驗證碼已發送到 {!!session('login_email')!!}</h5>
							{!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/mt4-password-verification'), 'name' => 'verificationForm','class'=>'col-md-4']) !!}
					<div class="form-group">
                        
                            
                        {!! Form::text('verification_code', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入 驗證碼',]) !!}
                        
                            

                        <small class="text-danger">{{ $errors->first('verification_code') }}</small>
                        </div>
                        @if($errors->any())
                        <h5 style="color:red;">{{$errors->first()}}</h5>
                            @endif
                            
                            {!!Form::hidden('account_no',$request->account_no)!!}
                             {!!Form::hidden('password',$request->password)!!}
                              
                        
                        
                        <div class="form-group">
                        {!!Form::submit('提交表格',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}
					</div>
                        </div>
                    </div>
					</div>
                </div>
                    
                    @endsection
                