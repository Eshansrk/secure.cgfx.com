


<h3>新設定檔案的驗證請求已送達</h3>

<table>
	<tr>
		<th>名稱: </th>
		<td>{{$name}}</td>
	</tr>
	
	
	<tr>
		<th>電子電子郵箱: </th>
		<td>{{$email}}</td>
	</tr>
	<tr>
		<th>身份證: </th>
		<td>
		@if($idImage)
		<a href="{{$idImage}}">檔案連結</a>

		@endif
		</td>
	</tr>
	
	<tr>
		<th>住址證明: </th>
		<td>@if($addressImage)
		<a href="{{$addressImage}}">檔案連結</a>

		@endif</td>
	</tr>

	

</table>



