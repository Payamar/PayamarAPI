<?php

	## 2. step
	$post = $_POST;

	/*

	  payment_status 			      => success
	  payment_type 				      => 2
	  payment_merchant_oid 		  => 75126 
	  payment_total_amount 		  => 5000
	  payment_amount 			      => 5000 
	  payment_installment_count => 1
	  payment_gain 				      => 50  (Kazançınız)
	  currency 					        => TL 
	*/
  
	$merchant_id 			  = 'xxxxx';				// Customer Store Code	
	$merchant_key 			= 'xxxxxxxxxxxx';		// Customer Store Key 
	$merchant_salt			= 'xxxxxxxxxxxx';		// Customer Store Secret Key

	## 1) Query your database using the order status $ post ['merchant_oid'].
	## 2) If the order has already been confirmed or canceled, echo "OK"; exit; terminate it.

	/* 
 	   $status = SQL
	   if($status == "success" || $status == "cancel"){
			echo "OK";
			exit;
		}
	 */

	if( $post['payment_status'] == 'success' ) { 
		## Payment Approved

		## WHAT TO DO HERE
		## 1) Confirm the order.
		## 2) If you are going to inform your customer like message / SMS / e-mail, you should do this at this stage.
		## 3) If the payment_amount order amount sent in STEP 1 is paid by installment
		## may vary. You can use it in your accounting operations by taking the current amount from $ post ['payment_total_amount'].
	
	} else { 
		## Disapproved Payment

		## WHAT TO DO HERE
		## 1) Cancel the order.
	}

	## Notify the PAYAMAR system that the notification has been received.
	echo "OK";
	exit;
?>
