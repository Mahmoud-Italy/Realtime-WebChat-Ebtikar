<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p>Dear <b>{{$user->name}}</b>,<br/><br/></p>
<p>Your Verify key : <b>{{$user->activation_key}}</b></p>
<p><br/>Best regards,</p>
<p>Copyright {{date('Y')}} domainName.com Incorporated. All rights reserved.</p>
</body>
</html>