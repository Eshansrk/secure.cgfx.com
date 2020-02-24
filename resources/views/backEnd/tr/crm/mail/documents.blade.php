


<h3>Yeni profil doğrulama isteği geldi</h3>

<table>
	<tr>
		<th>Adı: </th>
		<td>{{$name}}</td>
	</tr>
	
	
	<tr>
		<th>E-posta: </th>
		<td>{{$email}}</td>
	</tr>
	<tr>
		<th>Kimlik kanıtı: </th>
		<td>
		@if($idImage)
		<a href="{{$idImage}}">Belge Bağlantısı</a>

		@endif
		</td>
	</tr>
	
	<tr>
		<th>Adres Kanıtı: </th>
		<td>@if($addressImage)
		<a href="{{$addressImage}}">Belge Bağlantısı</a>

		@endif</td>
	</tr>

	

</table>



