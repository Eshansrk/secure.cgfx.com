@extends('backEnd.'.app()->getLocale().'.dashboard.layout')
@section('title', 'Verification Code')
@section ('page-level-css')
<link type="hidden/css" rel="stylesheet" href="/css/components2.css" />
@endsection
@section('content')
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6">
                        <a href="/internal-transfer"><h4 class="nav_top_align skin_txt">
                            <i class="fa fa-user"></i>
                           Para Çekme
                        </h4>
                        </a>
                    </div>
                    
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="card">

                        <div class="card-block m-t-35">
							<h2>Dogrulama kodunu giriniz</h2>
							<h5>Bir doğrulama kodu gönderilir {!!session('login_email')!!}</h5>
							{!! Form::open(['method' => 'POST', 'url' => LaravelLocalization::localizeURL('/verification'), 'name' => 'verificationForm','class'=>'col-md-4']) !!}
					<div class="form-group">
                        
                            
                        {!! Form::text('verification_code', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter verification code']) !!}
                        
                            

                        <small class="hidden-danger">{{ $errors->first('verification_code') }}</small>
                        </div>
                        @if($errors->any())
                        <h5 style="color:red;">{{$errors->first()}}</h5>
                            @endif
                            {!!Form::hidden('payment_type',$request->payment_type)!!}
                            {!!Form::hidden('transfer_from',$request->transfer_from)!!}
                        {!!Form::hidden('amount',$request->amount)!!}
                        {!!Form::hidden('net_amount',$request->net_amount)!!}
                        {!!Form::hidden('currency',$request->currency)!!}
                        {!!Form::hidden('account',$request->account)!!}
                        {!!Form::hidden('email',$request->email)!!}
                        {!!Form::hidden('bank_name',$request->bank_name)!!}
                        {!!Form::hidden('bank_residence_country',$request->bank_residence_country)!!}
                        {!!Form::hidden('bank_account',$request->bank_account)!!}
                        {!!Form::hidden('bank_iban',$request->bank_iban)!!}
                        
                        
                        {!!Form::hidden('bank_swift',$request->bank_swift)!!}
                        {!!Form::hidden('bank_address',$request->bank_address)!!}
                        
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
                