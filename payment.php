<?php
	error_reporting(1);
	header('Content-type: text/html; charset=UTF-8');

	## Sample codes for STEP 1 ##
	####################### COMPULSORY AREAS #######################
	## API Integration Information - You can get from the ENTEGRATION -> API ACCESS page by logging into the store panel.
	$merchant_id 			= 'xxxxx';				//Customer Store Code			
	$merchant_key 			= 'xxxxxxxxxxxx';		//Customer Store Key
	$merchant_salt			= 'xxxxxxxxxxxx';		//Customer Store Secret Key

	## Name and surname information that you have received on your site,
	$customer_namesurname 	= "Name And Surname?";

	## Your e-mail address that your customer has registered on your site or via the form
	$customer_email 		= "email@mail.com";

	## Telephone information you receive via your form registered or on your website
	$customer_number 		= "Customer GSM Number";

	## Address information that your customer has registered on your site or received via the form
	$customer_address 		= "No Address Information";
	
	## The amount to be collected.
	$payment_amount			= intval(50*100);	// Ondalık para birimi için lütfen : 150.50 Yapınız

	## Order number: Every one is unique !! This information is sent back to the building according to the notification page.
	$merchant_oid 			= rand(111111,9999); // Your system has created your order number

	## Customer's basket / order contents (Received Service Information PR: Premium Account)
	$user_basket 			= "Bakiye Yükleme (".$payment_amount.") TL";

	##Payment is the currency you want to send .. EXAMPLE: TL - USD - EUR
	$payment_currency 		= 'TL';

	############################################################################################
	## User IP 
	if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	} elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	$customer_ip=$ip;

	####### You do not need to make any changes in this section. #######
 	$secure_lane  = base64_encode(hash_hmac('sha256','PYMR'.$merchant_id.'KY'.$merchant_key.'SLT'.$merchant_salt.'C:'.date('dmydmy'),true));

	$post_vals=array(
		'api_merchant_id'		=>$merchant_id, 			// STORE CODE
		'api_key'				=>$merchant_key,			// STORE KEY
		'api_secret'			=>$merchant_salt,			// STORE SECRET KEY
		'customer_namesurname'	=>$customer_namesurname,	// CUSTOMER NAME AND SURNAME
		'customer_email'		=>$customer_email,			// CUSTOMER EMAİL ADDRESS
		'customer_number'		=>$customer_number,			// CUSTOMER GSM NUMBER
		'customer_address'		=>$customer_address,		// CUSTOMER ADDRESS
		'payment_amount'		=>$payment_amount,			// CUSTOMER PAYMENT AMOUNT
		'merchant_oid'			=>$merchant_oid,			// CUSTOMER ORDER NUMBER
		'user_basket'			=>$user_basket,				// CUSTOMER BASKET
		'payment_currency'		=>$payment_currency,		// CURRENCY
		'customer_ip'			=>$customer_ip,				// CUSTOMER USER IP ADDRESS
		'secure_lane'			=>$secure_lane				// PAYAMAR SAFETY UNIT STEP
		);
 
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.payamar.com.tr/get-token");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1) ;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$result = @curl_exec($ch);

	if(curl_errno($ch))
		die("PAYAMAR IFRAME CONNECTION ERROR: ".curl_error($ch));

	curl_close($ch);

	$result=json_decode($result,1);

	if($result['iframe_status']=='success'){
		$token 	=$result['payamar_vpos_token'];
		header("Location:https://payment.payamar.com.tr/".$token.'/');
		// https://payment.payamar.com/TOKEN/
	}else{
		die("PAYAMAR IFRAME failed. reason: ".$result['error']);
	}
	?>  
