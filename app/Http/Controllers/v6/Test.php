<?php

namespace App\Http\Controllers\v6;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Test extends Controller
{
    public function testIndex()
    {
        $response = [
            'success' => true,
            'message' => "Welcome to test API in version 6",
        ];

        return response()->json($response, 200);
    }
	
    public function testMethodAfterLogin()
    {
        $response = [
            'success' => true,
            'message' => "Welcome to test API method after login",
        ];

        return response()->json($response, 200);
    }
	
	/**
	* This method is use for encrypt-decrypt a string.
	*/
	public function dataEncryptDecrypt(Request $request) {

		//echo'testMethodtestMethodtestMethod'; exit;
		
		$type = $request->type; //'encrypt';
		$stringVal = $request->stringVal;
		
		$stringVal = str_replace("__","/", $stringVal);
		
		if($type == 'encrypt') {
			return openssl_encrypt($stringVal,"AES-128-ECB",config('app.SECRET_SALT'));
		} else if($type == 'decrypt') {
			return 'Decryption method is not working.';
			return openssl_decrypt($stringVal,"AES-128-ECB",config('app.SECRET_SALT'));
		} else {
			return 'Type missing...';
		}
	}
}