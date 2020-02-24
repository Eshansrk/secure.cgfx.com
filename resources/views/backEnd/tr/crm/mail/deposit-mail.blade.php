


<h3>İstemciden Yeni Para Yatırma</h3>


<table>
	<tr>
		<th>Adı: </th>
		<td>{{$name}}</td>
	</tr>
	<tr>
		<th>Referans Numarası: </th>
		<td>{{$reference}}</td>
	</tr>
	
	<tr>
		<th>E-posta: </th>
		<td>{{$email}}</td>
	</tr>
	
	
	<tr>
		<th>Depozito: </th>
		<td>{{$deposit_to}}</td>
	</tr>

	<tr>
		<th>Miktar: </th>
		<td>$ {{$amount}}</td>
	</tr>
	
	
	<tr>
		<th>İşlem yöntemi: </th>
		<td>{{$payment_type}}</td>
	</tr>
	@if($payment_type=='Neteller' )
	<tr>
		<th>Hesap no: </th>
		<td>{{$account}}</td>
	</tr>
	@endif
	
	{{-- <tr>
		<th>Transaction Email: </th>
		<td>{{$payment_email}}</td>
	</tr> --}}

	@if($transaction_id)
	<tr>
		<th>İşlem Kimliği: </th>
		<td>{{$transaction_id}}</td>
	</tr>
	@endif

	@if($payment_type=='Bank Wire Transfer')
	<tr>
		<th>Banka adı: </th>
		<td>{{$bank_name}}</td>
	</tr>
	<tr>
		<th>Banka Ülke Adı: </th>
		<td>{{$bank_country}}</td>
	</tr>
	<tr>
		<th>Banka Hesap Adı: </th>
		<td>{{$bank_acc_name}}</td>
	</tr>
	<tr>
		<th>IBAN numarası: </th>
		<td>{{$iban_num}}</td>
	</tr>
	<tr>
		<th>Banka Swift Kodu: </th>
		<td>{{$swift_num}}</td>
	</tr>
	<tr>
		<th>Banka adresi: </th>
		<td>{{$bank_address}}</td>
	</tr>
	
	@endif

</table>



