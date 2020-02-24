


<h3>客戶新存款</h3>


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
		<th>電子電子郵箱： </th>
		<td>{{$email}}</td>
	</tr>
	
	
	<tr>
		<th>入金至: </th>
		<td>{{$deposit_to}}</td>
	</tr>

	<tr>
		<th>金額: </th>
		<td>$ {{$amount}}</td>
	</tr>
	
	
	<tr>
		<th>交易方式: </th>
		<td>{{$payment_type}}</td>
	</tr>
	@if($payment_type=='Neteller' )
	<tr>
		<th>賬號: </th>
		<td>{{$account}}</td>
	</tr>
	@endif
	
	{{-- <tr>
		<th>Transaction Email: </th>
		<td>{{$payment_email}}</td>
	</tr> --}}

	@if($transaction_id)
	<tr>
		<th>交易编号: </th>
		<td>{{$transaction_id}}</td>
	</tr>
	@endif

	@if($payment_type=='Bank Wire Transfer')
	<tr>
		<th>銀行名稱: </th>
		<td>{{$bank_name}}</td>
	</tr>
	<tr>
		<th>銀行國家: </th>
		<td>{{$bank_country}}</td>
	</tr>
	<tr>
		<th>銀行帳戶名: </th>
		<td>{{$bank_acc_name}}</td>
	</tr>
	<tr>
		<th>帳戶號 (IBAN): </th>
		<td>{{$iban_num}}</td>
	</tr>
	<tr>
		<th>銀行代碼 : </th>
		<td>{{$swift_num}}</td>
	</tr>
	<tr>
		<th>銀行地址: </th>
		<td>{{$bank_address}}</td>
	</tr>
	
	@endif

</table>



