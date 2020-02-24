


<h3>New Deposit From Client</h3>


<table>
	<tr>
		<th>Name: </th>
		<td>{{$name}}</td>
	</tr>
	<tr>
		<th>Refernce no: </th>
		<td>{{$reference}}</td>
	</tr>
	
	<tr>
		<th>Email: </th>
		<td>{{$email}}</td>
	</tr>
	
	
	<tr>
		<th>Deposit To: </th>
		<td>{{$deposit_to}}</td>
	</tr>

	<tr>
		<th>Amount: </th>
		<td>$ {{$amount}}</td>
	</tr>
	
	
	<tr>
		<th>Transaction method: </th>
		<td>{{$payment_type}}</td>
	</tr>
	@if($payment_type=='Neteller' )
	<tr>
		<th>Account no: </th>
		<td>{{$account}}</td>
	</tr>
	@endif
	
	{{-- <tr>
		<th>Transaction Email: </th>
		<td>{{$payment_email}}</td>
	</tr> --}}

	@if($transaction_id)
	<tr>
		<th>Transaction ID: </th>
		<td>{{$transaction_id}}</td>
	</tr>
	@endif

	@if($payment_type=='Bank Wire Transfer')
	<tr>
		<th>Bank Name: </th>
		<td>{{$bank_name}}</td>
	</tr>
	<tr>
		<th>Bank Country Name: </th>
		<td>{{$bank_country}}</td>
	</tr>
	<tr>
		<th>Bank Account Name: </th>
		<td>{{$bank_acc_name}}</td>
	</tr>
	<tr>
		<th>IBAN Number: </th>
		<td>{{$iban_num}}</td>
	</tr>
	<tr>
		<th>Bank Swift Code: </th>
		<td>{{$swift_num}}</td>
	</tr>
	<tr>
		<th>Bank Address: </th>
		<td>{{$bank_address}}</td>
	</tr>
	
	@endif

</table>



