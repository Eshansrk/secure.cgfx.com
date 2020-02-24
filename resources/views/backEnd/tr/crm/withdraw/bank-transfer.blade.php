
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', 'Bank Transfer')
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
                       Banka transferi
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
                            <h2>Banka transferi</h2>
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/bank_transfer'), 'name' => 'withdrawForm','class'=>'col-md-4','id'=>'bankTransfer']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group">
                        
                            {!! Form::label('transfer_from', 'Transfer From *') !!}
                            <select name="transfer_from" class="form-control input-lg" required="required" id="">
                            <option value="">İşlem Hesabı Seç</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}}Amerikan Doları</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                    <div class="form-group">
                        
                            {!! Form::label('amount', 'Amount to be withdrawn *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'required' => 'required', 'placeholder' => 'Enter Amount in USD','onchange'=>'calculatenet()']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('net_amount', 'Net Amount') !!}
                        {!! Form::text('net_amount', null, ['class' => 'form-control input-lg','id'=>'net_amount', 'required' => 'required','readonly'=>'readonly']) !!}
                        <small class="text-danger">{{ $errors->first('net_amount') }}</small>
                        </div>

                        
                        <div class="form-group">
                        
                            {!! Form::label('bank_name', 'Bank Name *') !!}
                        {!! Form::text('bank_name', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Name']) !!}
                        <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('bank_country', 'Bank Country *') !!}
                        {!! Form::text('bank_country', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Country']) !!}
                        <small class="text-danger">{{ $errors->first('bank_country') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('bank_acc_name', 'Bank Account Name *') !!}
                        {!! Form::text('bank_acc_name', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Account Name']) !!}
                        <small class="text-danger">{{ $errors->first('bank_acc_name') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('iban_num', 'IBAN Number *') !!}
                        {!! Form::text('iban_num', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter IBAN Number']) !!}
                        <small class="text-danger">{{ $errors->first('iban_num') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('swift_num', 'Bank Swift Code *') !!}
                        {!! Form::text('swift_num', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Swift Code']) !!}
                        <small class="text-danger">{{ $errors->first('swift_num') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('bank_address', 'Bank Address *') !!}
                        {!! Form::textarea('bank_address', null, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Enter Bank Address']) !!}
                        <small class="text-danger">{{ $errors->first('bank_address') }}</small>
                        </div>

                        <div class="form-group">
                        {!!Form::submit('Withdraw',['class'=>'btn btn-primary'])!!}
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



<script>
    function calculatenet(){
  var amt = document.getElementById('amount').value;
  var total = (amt*2.5)/100;
  var total1 = amt - total;
  total1= Math.round(total1 * 100) / 100;
  document.getElementById('net_amount').value = total1;

  
}
</script>

























@endsection




