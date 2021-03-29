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

		$html = PT_LoadPage('modals/payment_modal',array('TYPE' => PT_Secure($_POST['type']),'PRICE' => $price,'VIDEO_ID' => $video_id,'USER_ID' => $user_id));
		if (!empty($html)) {
			$data['status'] = 200;
			$data['html'] = $html;
		}
	}
}