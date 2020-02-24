
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Citigate Deposit')
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
                        <i class="fa fa-home"></i>
                        Citigate Deposit
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
 

            <!--top section widgets-->
           <div class="card">

                        <div class="card-block m-t-35">
                            <h2>Citigate Deposit</h2>
                            @if(Session::has('msg'))
                            <div class="col-md-12">
                        <div class="alert alert-success"><h2 style="color: #fff;padding-top: 20px;">{{Session::get('msg')}}</h2>
                        </div>
                        </div>
                        @endif

                        
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/citigate_deposit'), 'name' => 'withdrawForm','class'=>'col-md-4','id'=>'']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group">
                        
                            {!! Form::label('deposit_to', 'Deposit to *') !!}
                            <select name="deposit_to" class="form-control input-lg" required="required" id="">
                            <option value="">Select Trading Account</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('deposit_to') }}</small>
                        </div>
                    <div class="form-group">
                        
                            {!! Form::label('amount', 'Amount to Deposit *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'required' => 'required', 'placeholder' => 'Enter Amount in USD']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        

                        
                        
                        <div class="form-group">
                        {!!Form::submit('Deposit',['class'=>'btn btn-primary'])!!}
                        </div>
                        {!!Form::close()!!}


                    </div>
                        </div>






    </div>
    <!-- /.inner -->
</div>
</div>
</div>
</div>


























@endsection




