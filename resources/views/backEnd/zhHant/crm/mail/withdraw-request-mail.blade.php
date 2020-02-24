

@if($payment_type=='Transfer to Trading Account')
<h3>客户新创建的内部转账</h3>
@else
<h3>新取款請求已到達</h3>
@endif
<table>
	<tr>
		<th>名稱: </th>
		<td>{{$name}}</td>
	</tr>
	<tr>
		<th>參攷編號: </th>
		<td>{{$reference}}</td>
	</tr>
	
	<tr>
		<th>電子電子郵箱: </th>
		<td>{{$email}}</td>
	</tr>
	<tr>
		<th>驗證碼: </th>
		<td>{{$verification_code}}</td>
	</tr>
	
	<tr>
		<th>轉自: </th>
		<td>{{$transfer_from}}</td>
	</tr>

	<tr>
		<th>金額: </th>
		<td>$ {{$amount}}</td>
	</tr>
	<tr>
		<th>淨額: </th>
		<td>$ {{$net_amount}}</td>
	</tr>
	<tr>
		<th>手續費: </th>
		<td>$ {{$proccessing_fee}}</td>
	</tr>
	<tr>
		<th>交易方式: </th>
		<td>{{$payment_type}}</td>
	</tr>
	@if($payment_type=='Neteller' )
	<tr>
		<th>帳戶號碼: </th>
		<td>{{$account}}</td>
	</tr>
	@endif
	@if($payment_type=='Neteller' || $payment_type=='Skrill' || $payment_type=='Okpay')
	<tr>
		<th>交易電郵: </th>
		<td>{{$payment_email}}</td>
	</tr>
	@endif
	@if($payment_type=='Bank Wire Transfer')
	<tr>
		<th>銀行名稱: </th>
		<td>{{$bank_name}}</td>
	</tr>
	<tr>
		<th>銀行所在國家: </th>
		<td>{{$bank_country}}</td>
	</tr>
	<tr>
		<th>銀行帳戶姓名: </th>
		<td>{{$bank_acc_name}}</td>
	</tr>
	<tr>
		<th>IBAN程式碼: </th>
		<td>{{$iban_num}}</td>
	</tr>
	<tr>
		<th>銀行Swift程式碼：</th>
		<td>{{$swift_num}}</td>
	</tr>
	<tr>
		<th>銀行開戶行地址: </th>
		<td>{{$bank_address}}</td>
	</tr>
	
	@endif

</table>



