<?php
	//ini_set("display_errors", "1");
	//error_reporting(E_ALL);
	
	$mnumber = $_GET['mnumber'];
	if(!$mnumber) $mnumber = '9953023991';
	
	$uname = 'yogalo.otp';
	$password = "Yog@#$845alo";
	
	$smsGatewayUrl ="https://smsgw.sms.gov.in";
	
	$api_element = '/failsafe/HttpLink';
	
	$message = "This-is-test-sms-message-from-NIC-server.";
    
	$from = 'Namaste-Yoga';

    $smsData = $smsGatewayUrl . $api_element . "?username=" . $uname . '&pin=' . $password . '&message=' . $message. '&mnumber=+91' . $mnumber . '&signature=' . $from ;

	
    //$smsData = urlencode($smsData);
	
    $url = $smsData;
	
	echo 'Requested URL: '.$url.'<br><br>';//die;
    

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
	
	//Send the request
	$response = curl_exec($ch);
	
	//$output = file_get_contents($url);
	//echo $output.'<br>';//die;

	//Close request
	if ($response === FALSE) {
		die('Curl Error: ' . curl_error($ch));
	} else {
		echo 'No error.';
	}
	curl_close($ch);

