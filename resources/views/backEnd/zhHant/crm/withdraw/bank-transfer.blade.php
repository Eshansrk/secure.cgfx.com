
@extends('backEnd.'.app()->getLocale().'.dashboard.layout')

@section('title', '銀行轉帳')
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
                        銀行轉帳
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
                            <h2>銀行轉帳</h2>
                            {!! Form::open(['method' => 'POST','files' => true, 'url' => LaravelLocalization::localizeURL('/bank_transfer'), 'name' => 'withdrawForm','class'=>'col-md-4','id'=>'bankTransfer']) !!}
                            @if($errors->any())
                            <h4 style="color:red;">{{$errors->first()}}</h4>
                            @endif
                            <div class="form-group">
                        
                            {!! Form::label('transfer_from', 'Transfer From *') !!}
                            <select name="transfer_from" class="form-control input-lg" required="required" id="">
                            <option value="">選擇交易帳戶</option>
                            @foreach($accounts as $account)
                            <option value="{{$account->account_no}}">{{$account->account_no}} ({{$account->act_type}}) {{$account->BALANCE}} USD</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('transfer_from') }}</small>
                        </div>
                    <div class="form-group">
                        
                            {!! Form::label('amount', '待提取金額 *') !!}
                        {!! Form::text('amount', null, ['class' => 'form-control input-lg','id'=>'amount', 'required' => 'required', 'placeholder' => '以美元輸入金額','onchange'=>'calculatenet()']) !!}
                        <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('net_amount', '金額') !!}
                        {!! Form::text('net_amount', null, ['class' => 'form-control input-lg','id'=>'net_amount', 'required' => 'required','readonly'=>'readonly']) !!}
                        <small class="text-danger">{{ $errors->first('net_amount') }}</small>
                        </div>

                        
                        <div class="form-group">
                        
                            {!! Form::label('bank_name', '銀行名稱 *') !!}
                        {!! Form::text('bank_name', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入銀行名稱']) !!}
                        <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('bank_country', '銀行國家 *') !!}
                        {!! Form::text('bank_country', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '選擇銀行國家']) !!}
                        <small class="text-danger">{{ $errors->first('bank_country') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('bank_acc_name', '銀行帳戶名稱 *') !!}
                        {!! Form::text('bank_acc_name', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '入境銀行帳戶名稱']) !!}
                        <small class="text-danger">{{ $errors->first('bank_acc_name') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('iban_num', 'IBAN號碼 *') !!}
                        {!! Form::text('iban_num', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入IBAN號碼']) !!}
                        <small class="text-danger">{{ $errors->first('iban_num') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('swift_num', '銀行代碼 *') !!}
                        {!! Form::text('swift_num', null, ['class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入Bank Swift Code']) !!}
                        <small class="text-danger">{{ $errors->first('swift_num') }}</small>
                        </div>

                        <div class="form-group">
                        
                            {!! Form::label('bank_address', '銀行地址 *') !!}
                        {!! Form::textarea('bank_address', null, ['rows'=>'5','class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => '輸入銀行地址']) !!}
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




