<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>

<body style="margin:0px; padding:0px; font-family: Lato, sans-serif;">
	<table width="75%" cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;">
		<tr style="border-bottom: 5px solid #4E9533;">
			<td width="312" height="90" colspan="2" style="padding-left:20px;padding-right:0px;padding-top:0px; padding-bottom:0px;background:#D8E465; -moz-border-top-left-radius: 10px; -webkit-border-top-left-radius:10px; border-top-left-radius:10px;-moz-border-top-right-radius: 10px; -webkit-border-top-right-radius:10px; border-top-right-radius:10px;">
				<img src="{{ url('/') }}/images/emails/yoga-locator.png" width="80" height="70" alt="yoga-locator" style="float:left;">

				<img src="{{ url('/') }}/images/emails/ayush-logo.png" width="60" height="70" alt="ayush-logo-logo" style="float:right; margin-right:20px;">

				<img src="{{ url('/') }}/images/emails/yoga-logo.png" width="60" height="70" alt="yoga-logo" style="float:right; margin-right:20px;">
			</td>
		</tr>
		<tr style="background:#f7f7f7;">
			<td colspan="2" style="padding-left:15px;padding-right:15px;padding-top:25px; padding-bottom:25px; height:400px; font-size:14px; line-height:24px; color:#242424;" align="center" valign="middle">
                <span style="font-weight:bold; color:{{$msgTypeColor}};">{{$msg}}</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="padding-left:0px;font-size:14px; padding-top:10px; padding-bottom:10px; line-height:22px;color:#ffffff; background:#4E9533; padding-left:15px;-moz-border-bottom-left-radius: 10px; -webkit-border-bottom-left-radius:10px; border-bottom-left-radius:10px;-moz-border-bottom-right-radius: 10px; -webkit-border-bottom-right-radius:10px; border-bottom-right-radius:10px;">
			<br/><br/> </td>
		</tr>
	</table>
</body>

</html>
