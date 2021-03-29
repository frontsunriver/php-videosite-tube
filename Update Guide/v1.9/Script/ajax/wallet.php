<?php

if (IS_LOGGED == false) {
    $data = array(
        'status' => 400,
        'error' => 'Not logged in'
    );
    echo json_encode($data);
    exit();
}


use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;


$payment_currency = $pt->config->payment_currency;
$paypal_currency = $pt->config->paypal_currency;
$payer        = new Payer();
$item         = new Item();
$itemList     = new ItemList();
$details      = new Details();
$amount       = new Amount();
$transaction  = new Transaction();
$redirectUrls = new RedirectUrls();
$payment      = new Payment();
$payer->setPaymentMethod('paypal');

if ($first == 'replenish') {
	$data    = array('status' => 400);
	$request = (!empty($_POST['amount']) && is_numeric($_POST['amount']));
	if ($request === true) {
		$rep_amount  = $_POST['amount'];
		$redirectUrl = PT_Link("aj/wallet/get_paid?status=success&amount=$rep_amount");
		$redirectUrls->setReturnUrl($redirectUrl)->setCancelUrl(PT_Link(''));    
	    $item->setName('Replenish your balance')->setQuantity(1)->setPrice($rep_amount)->setCurrency($paypal_currency);  
	    $itemList->setItems(array($item));    
	    $details->setSubtotal($rep_amount);
	    $amount->setCurrency($paypal_currency)->setTotal($rep_amount)->setDetails($details);
	    $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Replenish your balance')->setInvoiceNumber(time());
	    $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array(
	        $transaction
	    ));

	    try {
	        $payment->create($paypal);
	    }

	    catch (Exception $e) {
	        $data = array(
	            'type' => 'ERROR',
	            'details' => json_decode($e->getData())
	        );

	        if (empty($data['details'])) {
	            $data['details'] = json_decode($e->getCode());
	        }
	        echo json_encode($data);
	    	exit();
	    }

	    $data = array(
	        'status' => 200,
	        'type' => 'SUCCESS',
	        'url' => $payment->getApprovalLink()
	    );

	}
}

if ($first == 'get_paid') {
	$data['status'] = 500;
	$request        = (
		!empty($_GET['paymentId']) && 
		!empty($_GET['PayerID']) && 
		!empty($_GET['status']) && 
		!empty($_GET['amount']) && 
		is_numeric($_GET['amount']) && 
		$_GET['status'] == 'success'
	);

	if ($request === true) {

		$paymentId = PT_Secure($_GET['paymentId']);
		$PayerID   = PT_Secure($_GET['PayerID']);
		$payment   = Payment::get($paymentId, $paypal);
	    $execute   = new PaymentExecution();
	    $execute->setPayerId($PayerID);

	    try{
	        $result = $payment->execute($execute, $paypal);
	    }

	    catch (Exception $e) {
	        $data = array(
	            'type' => 'ERROR',
	            'details' => json_decode($e->getData())
	        );

	        if (empty($data['details'])) {
	            $data['details'] = json_decode($e->getCode());
	        }

	        echo json_encode($data);
	    	exit();
	    }

		$amount  = $_GET['amount'];
		$update  = array('wallet' => ($user->wallet += $amount));
		$db->where('id',$user->id)->update(T_USERS,$update);
		$payment_data         = array(
    		'user_id' => $user->id,
    		'paid_id'  => $user->id,
    		'admin_com'    => 0,
    		'currency'    => $pt->config->paypal_currency,
    		'time'  => time(),
    		'amount' => $amount,
    		'type' => 'ad'
    	);
		$db->insert(T_VIDEOS_TRSNS,$payment_data);


		$_SESSION['upgraded'] = true;
		$url     = PT_Link('ads');
    	header("Location: $url");
    	exit();

	}
}

if ($first == 'checkout_replenish' && $pt->config->checkout_payment == 'yes') {
	if (empty($_POST['card_number']) || empty($_POST['card_cvc']) || empty($_POST['card_month']) || empty($_POST['card_year']) || empty($_POST['token']) || empty($_POST['card_name']) || empty($_POST['card_address']) || empty($_POST['card_city']) || empty($_POST['card_state']) || empty($_POST['card_zip']) || empty($_POST['card_country']) || empty($_POST['card_email']) || empty($_POST['card_phone'])) {
        $data = array(
            'status' => 400,
            'error' => $lang->please_check_details
        );
    }
    else {
		if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
			require_once 'assets/import/2checkout/Twocheckout.php';
		    Twocheckout::privateKey($pt->config->checkout_private_key);
		    Twocheckout::sellerId($pt->config->checkout_seller_id);
		    if ($pt->config->checkout_mode == 'sandbox') {
		        Twocheckout::sandbox(true);
		    } else {
		        Twocheckout::sandbox(false);
		    }
		    try {
		    	$amount = PT_Secure($_POST['amount']);


		    	$charge  = Twocheckout_Charge::auth(array(
		            "merchantOrderId" => "123",
		            "token" => $_POST['token'],
		            "currency" => $pt->config->checkout_currency,
		            "total" => $amount,
		            "billingAddr" => array(
		                "name" => $_POST['card_name'],
		                "addrLine1" => $_POST['card_address'],
		                "city" => $_POST['card_city'],
		                "state" => $_POST['card_state'],
		                "zipCode" => $_POST['card_zip'],
		                "country" => $countries_name[$_POST['card_country']],
		                "email" => $_POST['card_email'],
		                "phoneNumber" => $_POST['card_phone']
		            )
		        ));
		        if ($charge['response']['responseCode'] == 'APPROVED') {

					$update  = array('wallet' => ($user->wallet += $amount));
					$db->where('id',$user->id)->update(T_USERS,$update);
					$payment_data         = array(
			    		'user_id' => $user->id,
			    		'paid_id'  => $user->id,
			    		'admin_com'    => 0,
			    		'currency'    => $pt->config->checkout_currency,
			    		'time'  => time(),
			    		'amount' => $amount,
			    		'type' => 'ad'
			    	);
					$db->insert(T_VIDEOS_TRSNS,$payment_data);
					$_SESSION['upgraded'] = true;
					$data['status'] = 200;
					$data['url'] = PT_Link('ads');
		        }
		        else{
		        	$data = array(
		                'status' => 400,
		                'error' => $lang->checkout_declined
		            );
		        }
		        if ($pt->user->address != $_POST['card_address'] || $pt->user->city != $_POST['card_city'] || $pt->user->state != $_POST['card_state'] || $pt->user->zip != $_POST['card_zip'] || $pt->user->country_id != $_POST['card_country'] || $pt->user->phone_number != $_POST['card_phone']) {
			    	$update_data = array('address' => PT_Secure($_POST['card_address']),'city' => PT_Secure($_POST['card_city']),'state' => PT_Secure($_POST['card_state']),'zip' => PT_Secure($_POST['card_zip']),'country_id' => PT_Secure($_POST['card_country']),'phone_number' => PT_Secure($_POST['card_phone']));
			    	$db->where('id', $pt->user->id)->update(T_USERS, $update_data);
			    }
			}
			catch (Twocheckout_Error $e) {
		        $data = array(
		            'status' => 400,
		            'error' => $e->getMessage()
		        );
		    }
		}
		else{
			$data = array(
	            'status' => 400,
	            'error' => $lang->please_check_details
	        );
		}
	}
}


if ($first == 'stripe_replenish' && $pt->config->credit_card == 'yes') {
	if (!empty($_POST['stripeToken']) && !empty($_POST['amount'])) {

		require_once('assets/import/stripe-php-3.20.0/vendor/autoload.php');
		$stripe = array(
		  "secret_key"      =>  $pt->config->stripe_secret,
		  "publishable_key" =>  $pt->config->stripe_id
		);

		\Stripe\Stripe::setApiKey($stripe['secret_key']);


	    $token = $_POST['stripeToken'];
	    try {
	        $customer = \Stripe\Customer::create(array(
	            'source' => $token
	        ));

	        $final_amount = PT_Secure($_POST['amount']);
	        $charge   = \Stripe\Charge::create(array(
	            'customer' => $customer->id,
	            'amount' => $final_amount,
	            'currency' => $pt->config->stripe_currency
	        ));
	        $amount = $final_amount / 100;
	        if ($charge) {
	        	$update  = array('wallet' => ($user->wallet += $amount));
				$db->where('id',$user->id)->update(T_USERS,$update);
				$payment_data         = array(
		    		'user_id' => $user->id,
		    		'paid_id'  => $user->id,
		    		'admin_com'    => 0,
		    		'currency'    => $pt->config->stripe_currency,
		    		'time'  => time(),
		    		'amount' => $amount,
		    		'type' => 'ad'
		    	);
				$db->insert(T_VIDEOS_TRSNS,$payment_data);
				$_SESSION['upgraded'] = true;
				$data['status'] = 200;
				$data['url'] = PT_Link('ads');
	        }
	    }
	    catch (Exception $e) {
	        $data = array(
	            'status' => 400,
	            'error' => $e->getMessage()
	        );
	        header("Content-type: application/json");
	        echo json_encode($data);
	        exit();
	    }
	}
	else{
		$data = array(
            'status' => 400,
            'error' => $lang->please_check_details
        );
	}
}


if ($first == 'bank_replenish' && $pt->config->bank_payment == 'yes') {
	if (empty($_FILES["thumbnail"]) || empty($_POST['amount'])) {
        $error = $lang->please_check_details;
    }
    if (empty($error)) {
    	$amount = PT_Secure($_POST['amount']);
    	$amount = $amount/100;
        $description = 'Wallet';
        $fileInfo      = array(
            'file' => $_FILES["thumbnail"]["tmp_name"],
            'name' => $_FILES['thumbnail']['name'],
            'size' => $_FILES["thumbnail"]["size"],
            'type' => $_FILES["thumbnail"]["type"],
            'types' => 'jpeg,jpg,png,bmp,gif'
        );
        $media         = PT_ShareFile($fileInfo);

        $mediaFilename = $media['filename'];
        if (!empty($mediaFilename)) {

        	$insert_id = $db->insert(T_BANK_TRANSFER,array('user_id' => $pt->user->id,
                                                   'description' => $description,
                                                   'price'       => $amount,
                                                   'receipt_file' => $mediaFilename,
                                                   'mode'         => 'wallet'));
            if (!empty($insert_id)) {
                $data = array(
                    'message' => $lang->bank_transfer_request,
                    'status' => 200
                );
            }
        }
        else{
            $error = $lang->please_check_details;
            $data = array(
                'status' => 500,
                'message' => $error
            );
        }
    } else {
        $data = array(
            'status' => 500,
            'message' => $error
        );
    }
}



if ($first == 'get_modal') {
	$types = array('pro','wallet','pay','subscribe','rent');
	$data['status'] = 400;
	if (!empty($_POST['type']) && in_array($_POST['type'], $types)) {
		$user = $db->where('id',$pt->user->id)->getOne(T_USERS);
		
		$price = 0;
		$video_id = 0;
		$user_id = 0;
		if (!empty($_POST['price'])) {
			$price = PT_Secure($_POST['price']);
		}
		if (!empty($_POST['video_id'])) {
			$video_id = PT_Secure($_POST['video_id']);
		}
		if (!empty($_POST['user_id'])) {
			$user_id = PT_Secure($_POST['user_id']);
		}

		$pt->show_wallet = 0;
		if (!empty($user) && $_POST['type'] == 'pro' && $user->wallet >= intval($pt->config->pro_pkg_price)) {
			$pt->show_wallet = 1;
		}
		elseif (!empty($user) && $_POST['type'] == 'pay' && !empty($video_id)) {
			$video = $db->where('id',$video_id)->getOne(T_VIDEOS);
			if ($user->wallet >= $video->sell_video) {
				$pt->show_wallet = 1;
			}
		}
		elseif (!empty($user) && $_POST['type'] == 'rent' && !empty($video_id)) {
			$video = $db->where('id',$video_id)->getOne(T_VIDEOS);
			if ($user->wallet >= $video->rent_price) {
				$pt->show_wallet = 1;
			}
		}
		
		if ($_POST['type'] == 'subscribe' && !empty($user_id)) {
			$new_user = $db->where('id',$user_id)->getOne(T_USERS);
			if (!empty($new_user) && $new_user->subscriber_price > 0 && $user->wallet >= $new_user->subscriber_price) {
				$pt->show_wallet = 1;
			}
		}
		if ($_POST['type'] == 'subscribe') {
			$price = $new_user->subscriber_price;
		}
		elseif ($_POST['type'] == 'pro') {
			$price = intval($pt->config->pro_pkg_price);
		}
		elseif ($_POST['type'] == 'rent') {
			$price = $video->rent_price;
		}
		elseif ($_POST['type'] == 'pay') {
			$price = $video->sell_video;
		}

		$html = PT_LoadPage('modals/payment_modal',array('TYPE' => PT_Secure($_POST['type']),'PRICE' => $price,'VIDEO_ID' => $video_id,'USER_ID' => $user_id));
		if (!empty($html)) {
			$data['status'] = 200;
			$data['html'] = $html;
		}
	}
}
if ($first == 'paystack') {

	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0 && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$price = $_POST['amount'] * 100;

		$callback_url = PT_Link("aj/wallet/paystack_paid?type=wallet&amount=".$price);
		$result = array();
	    $reference = uniqid();

		//Set other parameters as keys in the $postdata array
		$postdata =  array('email' => $_POST['email'], 'amount' => $price,"reference" => $reference,'callback_url' => $callback_url);
		$url = "https://api.paystack.co/transaction/initialize";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
		  'Authorization: Bearer '.$pt->config->paystack_secret_key,
		  'Content-Type: application/json',

		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$request = curl_exec ($ch);

		curl_close ($ch);

		if ($request) {
		    $result = json_decode($request, true);
		    if (!empty($result)) {
				 if (!empty($result['status']) && $result['status'] == 1 && !empty($result['data']) && !empty($result['data']['authorization_url']) && !empty($result['data']['access_code'])) {
				 	$db->where('id',$pt->user->id)->update(T_USERS,array('paystack_ref' => $reference));
				  	$data['status'] = 200;
				  	$data['url'] = $result['data']['authorization_url'];
				}
				else{
			        $data['message'] = $result['message'];
				}
			}
			else{
				$data['message'] = $lang->error_msg;
			}
		}
		else{
			$data['message'] = $lang->error_msg;
		}
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'paystack_paid') {
	$payment  = CheckPaystackPayment($_GET['reference']);
	if ($payment) {
		$amount = PT_Secure($_GET['amount'] / 100);
		$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
		$payment_data         = array(
            'user_id' => $pt->user->id,
            'paid_id'  => $pt->user->id,
            'admin_com'    => 0,
            'currency'    => $pt->config->payment_currency,
            'time'  => time(),
            'amount' => $amount,
            'type' => 'ad'
        );
        $db->insert(T_VIDEOS_TRSNS,$payment_data);
        header('Location: ' . PT_Link('ads'));
        exit();
    } else {
        header('Location: ' . PT_Link('ads'));
        exit();
    }
}
if ($first == 'cashfree' && $pt->config->cashfree_payment == 'yes') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0 && !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		
		$result = array();
	    $order_id = uniqid();
	    $name = PT_Secure($_POST['name']);
	    $email = PT_Secure($_POST['email']);
	    $phone = PT_Secure($_POST['phone']);
	    $price = PT_Secure($_POST['amount']);

	    $callback_url = PT_Link("aj/wallet/cashfree_paid?amount=".$price);


	    $secretKey = $pt->config->cashfree_secret_key;
		$postData = array( 
		  "appId" => $pt->config->cashfree_client_key, 
		  "orderId" => "order".$order_id, 
		  "orderAmount" => $price, 
		  "orderCurrency" => "INR", 
		  "orderNote" => "", 
		  "customerName" => $name, 
		  "customerPhone" => $phone, 
		  "customerEmail" => $email,
		  "returnUrl" => $callback_url, 
		  "notifyUrl" => $callback_url,
		);
		 // get secret key from your config
		 ksort($postData);
		 $signatureData = "";
		 foreach ($postData as $key => $value){
		      $signatureData .= $key.$value;
		 }
		 $signature = hash_hmac('sha256', $signatureData, $secretKey,true);
		 $signature = base64_encode($signature);
		 $cashfree_link = 'https://test.cashfree.com/billpay/checkout/post/submit';
		 if ($pt->config->cashfree_mode == 'live') {
		 	$cashfree_link = 'https://www.cashfree.com/checkout/post/submit';
		 }

		$form = '<form id="redirectForm" method="post" action="'.$cashfree_link.'"><input type="hidden" name="appId" value="'.$pt->config->cashfree_client_key.'"/><input type="hidden" name="orderId" value="order'.$order_id.'"/><input type="hidden" name="orderAmount" value="'.$price.'"/><input type="hidden" name="orderCurrency" value="INR"/><input type="hidden" name="orderNote" value=""/><input type="hidden" name="customerName" value="'.$name.'"/><input type="hidden" name="customerEmail" value="'.$email.'"/><input type="hidden" name="customerPhone" value="'.$phone.'"/><input type="hidden" name="returnUrl" value="'.$callback_url.'"/><input type="hidden" name="notifyUrl" value="'.$callback_url.'"/><input type="hidden" name="signature" value="'.$signature.'"/></form>';
		$data['status'] = 200;
		$data['html'] = $form;
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'cashfree_paid' && $pt->config->cashfree_payment == 'yes') {
	if (empty($_POST['txStatus']) || $_POST['txStatus'] != 'SUCCESS') {
		header('Location: ' . PT_Link('ads'));
        exit();
	}
	$orderId = $_POST["orderId"];
	$orderAmount = $_POST["orderAmount"];
	$referenceId = $_POST["referenceId"];
	$txStatus = $_POST["txStatus"];
	$paymentMode = $_POST["paymentMode"];
	$txMsg = $_POST["txMsg"];
	$txTime = $_POST["txTime"];
	$signature = $_POST["signature"];
	$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
	$hash_hmac = hash_hmac('sha256', $data, $pt->config->cashfree_secret_key, true) ;
	$computedSignature = base64_encode($hash_hmac);
	if ($signature == $computedSignature) {
		$amount = PT_Secure($_GET['amount']);
		$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
		$payment_data         = array(
            'user_id' => $pt->user->id,
            'paid_id'  => $pt->user->id,
            'admin_com'    => 0,
            'currency'    => $pt->config->payment_currency,
            'time'  => time(),
            'amount' => $amount,
            'type' => 'ad'
        );
        $db->insert(T_VIDEOS_TRSNS,$payment_data);
        header('Location: ' . PT_Link('ads'));
        exit();
    } else {
        header('Location: ' . PT_Link('ads'));
        exit();
    }
}
if ($first == 'razorpay' && $pt->config->razorpay_payment == 'yes') {
	if (!empty($_POST['payment_id']) && !empty($_POST['order_id']) && !empty($_POST['merchant_amount']) && !empty($_POST['currency'])) {

		$payment_id = PT_Secure($_POST['payment_id']);
		$price    = PT_Secure($_POST['merchant_amount']);
		$currency_code = "INR";
	    $check = array(
		    'amount' => $price,
		    'currency' => $currency_code,
		);
		$json = CheckRazorpayPayment($payment_id,$check);
		if (!empty($json) && empty($json->error_code)) {
			$price = $price / 100;

			$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($price)));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $price,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
	        $data['status'] = 200;
		    $data['url'] = PT_Link('ads');
		}
		else{
	    	$data['message'] = $json->error_description;
	    }
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'paysera' && $pt->config->razorpay_payment == 'yes') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$price = PT_Secure($_POST['amount']);
		$callback_url = PT_Link("aj/wallet/paysera_paid?amount=".$price);
		require_once 'assets/import/Paysera.php';

	    $request = WebToPay::redirectToPayment(array(
		    'projectid'     => $pt->config->paysera_project_id,
		    'sign_password' => $pt->config->paysera_sign_password,
		    'orderid'       => rand(111111,999999),
		    'amount'        => $price,
		    'currency'      => $pt->config->payment_currency,
		    'country'       => 'LT',
		    'accepturl'     => $callback_url,
		    'cancelurl'     => $callback_url,
		    'callbackurl'   => $callback_url,
		    'test'          => $pt->config->paysera_mode,
		));
		$data = array('status' => 200,
	                  'url' => $request);
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'paysera_paid' && $pt->config->paysera_payment == 'yes') {
	require_once 'assets/import/Paysera.php';
	try {
        $response = WebToPay::checkResponse($_GET, array(
            'projectid'     => $pt->config->paysera_project_id,
            'sign_password' => $pt->config->paysera_sign_password,
        ));
 
        // if ($response['test'] !== '0') {
        //     throw new Exception('Testing, real payment was not made');
        // }
        if ($response['type'] !== 'macro') {
        	header('Location: ' . PT_Link('ads'));
	        exit();
            //throw new Exception('Only macro payment callbacks are accepted');
        }
        $amount = $response['amount'];
        $currency = $response['currency'];

        if ($currency != $pt->config->payment_currency) {
        	header('Location: ' . PT_Link('ads'));
	        exit();
        }
        else{
        	$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $amount,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
		    header('Location: ' . PT_Link('ads'));
		    exit();
        }
	} catch (Exception $e) {
	    header('Location: ' . PT_Link('ads'));
        exit();
	}
}
if ($first == 'iyzipay') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		require_once 'assets/import/iyzipay/samples/config.php';
		$amount = PT_Secure($_POST['amount']);
		$callback_url = PT_Link("aj/wallet/iyzipay_paid?amount=".$amount);

		
		$request->setPrice($amount);
		$request->setPaidPrice($amount);
		$request->setCallbackUrl($callback_url);
		

		$basketItems = array();
		$firstBasketItem = new \Iyzipay\Model\BasketItem();
		$firstBasketItem->setId("BI".rand(11111111,99999999));
		$firstBasketItem->setName("wallet");
		$firstBasketItem->setCategory1("wallet");
		$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
		$firstBasketItem->setPrice($amount);
		$basketItems[0] = $firstBasketItem;
		$request->setBasketItems($basketItems);
		$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());
		$content = $checkoutFormInitialize->getCheckoutFormContent();
		if (!empty($content)) {
			$db->where('id',$pt->user->id)->update(T_USERS,array('ConversationId' => $ConversationId));
			$data['html'] = $content;
			$data['status'] = 200;
		}
		else{
			$data['message'] = $lang->please_check_details;
		}
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'iyzipay_paid') {
	if (!empty($_POST['token']) && !empty($pt->user->ConversationId) && !empty($_GET['amount']) && is_numeric($_GET['amount']) && $_GET['amount'] > 0) {
		require_once('assets/import/iyzipay/samples/config.php');

		# create request class
		$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
		$request->setLocale(\Iyzipay\Model\Locale::TR);
		$request->setConversationId($pt->user->ConversationId);
		$request->setToken($_POST['token']);

		# make request
		$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

		# print result
		if ($checkoutForm->getPaymentStatus() == 'SUCCESS') {
			$amount = PT_Secure($_GET['amount']);
			$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $amount,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
		    header('Location: ' . PT_Link('ads'));
		    exit();
		}
		else{
			header('Location: ' . PT_Link('ads'));
	        exit();
		}
	}
	else{
		header('Location: ' . PT_Link('ads'));
	    exit();
	}
}
if ($first == 'move_to_wallet') {
	if ($pt->user->balance < 1) {
		$data['message'] = $lang->no_balance_to_move;
	}
	elseif (empty($_POST['amount']) || !is_numeric($_POST['amount']) || $_POST['amount'] < 1) {
		$data['message'] = $lang->please_check_details;
	}
	elseif ($_POST['amount'] > $pt->user->balance) {
		$data['message'] = $lang->more_than_balance;
	}
	else{
		$amount = PT_Secure($_POST['amount']);
		$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
		$db->where('id',$pt->user->id)->update(T_USERS,array('balance' => $db->dec($amount)));
		$data['status'] = 200;
	}
}