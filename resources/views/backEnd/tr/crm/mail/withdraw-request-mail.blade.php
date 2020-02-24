

@if($payment_type=='Transfer to Trading Account')
<h3>İstemciden Yeni İç Transferi</h3>
@else
<h3>Yeni para çekme isteği geldi</h3>
@endif
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
		<th>Doğrulama kodu: </th>
		<td>{{$verification_code}}</td>
	</tr>
	
	<tr>
		<th>Gönderen: </th>
		<td>{{$transfer_from}}</td>
	</tr>

	<tr>
		<th>Miktar: </th>
		<td>$ {{$amount}}</td>
	</tr>
	<tr>
		<th>Net tutar: </th>
		<td>$ {{$net_amount}}</td>
	</tr>
	<tr>
		<th>İşlem ücreti: </th>
		<td>$ {{$proccessing_fee}}</td>
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
	@if($payment_type=='Neteller' || $payment_type=='Skrill' || $payment_type=='Okpay')
	<tr>
		<th>İşlem E-postası: </th>
		<td>{{$payment_email}}</td>
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



