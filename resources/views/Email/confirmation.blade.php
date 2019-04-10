<!DOCTYPE html>
<html>
<head>
	<title>Confirmation Email</title>
</head>
<body>
	<table>
		<thead>
			<tr><td>Dear {{$name}}!</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>Please click on below link to confirm your account.</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td><a href="{{url('confirm/'.$code)}}">Confirm Your Account</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>Thanks & Regards,</td></tr>
			<tr><td>E-Shoppe</td></tr>
		</thead>
	</table>
</body>
</html>