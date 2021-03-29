<?php 
if (IS_LOGGED == false) {
    $data = array(
        'status' => 400,
        'error' => 'Not logged in'
    );
    echo json_encode($data);
    exit();
}

elseif((!PT_IsAdmin() && ($pt->config->go_pro != 'on' || PT_IsUpgraded())) && $pt->config->sell_videos_system != 'on'){
	$data = array(
        'status' => 400,
        'error' => 'Bad request'
    );
    echo json_encode($data);
    exit();
}
require './assets/import/PayPal/vendor/paypal/rest-api-sdk-php/sample/common.php';
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Agreement;
use PayPal\Api\ShippingAddress;
use PayPal\Api\AgreementDetails;


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
$payer        = new Payer();
$item         = new Item();
$itemList     = new ItemList();
$details      = new Details();
$amount       = new Amount();
$transaction  = new Transaction();
$redirectUrls = new RedirectUrls();
$payment      = new Payment();
$pkgs         = array('pro');
$payer->setPaymentMethod('paypal');
$sum          = intval($pt->config->pro_pkg_price);


if (!empty($_GET['first']) && $_GET['first'] == 'purchase') {

	if (!empty($_POST['type']) && $_POST['type'] == 'pro') {
		if ($pt->config->recurring_payment == 'off') {
			$redirectUrls->setReturnUrl(PT_Link('aj/go_pro/get_paid?status=success&pkg=pro'))->setCancelUrl(PT_Link(''));    
		    $item->setName('Purchase pro package')->setQuantity(1)->setPrice($sum)->setCurrency($payment_currency);  
		    $itemList->setItems(array($item));    
		    $details->setSubtotal($sum);
		    $amount->setCurrency($payment_currency)->setTotal($sum)->setDetails($details);
		    $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Purchase pro package')->setInvoiceNumber(time());
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
		else{
			$plan = new \PayPal\Api\Plan();
            $plan->setName('Purchase pro package user'.$pt->user->id)
              ->setDescription('Purchase pro package user'.$pt->user->id)
              ->setType('fixed');

                        // Set billing plan definitions
            $paymentDefinition = new \PayPal\Api\PaymentDefinition();
            $paymentDefinition->setName('Regular Payments user'.$pt->user->id)
              ->setType('REGULAR')
              ->setFrequency('Month')
              ->setFrequencyInterval('1')
              ->setCycles('48')
              ->setAmount(new \PayPal\Api\Currency(array('value' => $sum, 'currency' => $payment_currency)));

            $merchantPreferences = new \PayPal\Api\MerchantPreferences();
            $merchantPreferences->setReturnUrl(PT_Link('aj/go_pro/get_paid?status=success&pkg=pro'))
                ->setCancelUrl(PT_Link(''))
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0')
                ->setSetupFee(
                    new PayPal\Api\Currency(
                        array(
                            'currency' => $payment_currency,
                            'value' => $sum,
                        )
                    )
                );

            $plan->setPaymentDefinitions(array($paymentDefinition));
            $plan->setMerchantPreferences($merchantPreferences);

            try {
                $output = $plan->create($paypal);
                
            } catch (Exception $ex) {
                //ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
                
            }
            // ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);
            // exit();	
            $p_currency        = '$';

			if ($pt->config->payment_currency == 'EUR') {
				$p_currency    = '€';
			}

            $patch = new \PayPal\Api\Patch();
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue(new \PayPal\Common\PayPalModel('{
                    "state": "ACTIVE"
                }'));

            $patchRequest = new \PayPal\Api\PatchRequest();
            $patchRequest->addPatch($patch);

            $resActivate = $plan->update($patchRequest, $paypal);


            // Create new agreement

            // Create new agreement
            $plan->setState('ACTIVE');
            $agreement = new Agreement();
            $agreement->setName('Purchase Pro package user'.$pt->user->id)
              ->setDescription('Upgrade to Pro Member - '.$p_currency.''.$sum.'/mo user'.$pt->user->id)
              ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", time()+2629743));


            // Set plan id
            $cplan = new Plan();
            $cplan->setId($plan->getId());
            $agreement->setPlan($cplan);

            // Add payer type
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);

            // Adding shipping details
            // $shippingAddress = new ShippingAddress();
            // $shippingAddress->setLine1('111 First Street')
            //   ->setCity('Saratoga')
            //   ->setState('CA')
            //   ->setPostalCode('95070')
            //   ->setCountryCode('US');
            // $agreement->setShippingAddress($shippingAddress);

            //$request = clone $agreement;
            //*********************

            try {
              // Create agreement
              $agreement = $agreement->create($paypal);
              // Extract approval URL to redirect user
              $approvalUrl = $agreement->getApprovalLink();
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                // ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
                // exit(1);
            } catch (Exception $ex) {
              die($ex);
            }

            $data['status'] = 200;
            $data['url'] = $agreement->getApprovalLink();
		}
	}

	//Other packages
}

if (!empty($_GET['first']) && $_GET['first'] == 'get_paid') {
	$data['status'] = 500;
	$token = !empty($_GET['token']) && isset($_GET['token']) ? $_GET['token'] : '';
	$pkg            = (!empty($_GET['pkg']) && in_array($_GET['pkg'], $pkgs));
	if ($pt->config->recurring_payment == 'off') {
		$request        = (!empty($_GET['paymentId']) && !empty($_GET['PayerID']) && !empty($_GET['status']) && $_GET['status'] == 'success');
		if ($request && $pkg) {
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
		}
	}
	else{
		$agreement = new \PayPal\Api\Agreement();
        try {
            // Execute agreement
            $agreement->execute($token, $paypal);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
	}
		
	    
    $update = array('is_pro' => 1,'verified' => 1);
    $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);
    if ($go_pro === true) {
    	$pkg_type             = PT_Secure($_GET['pkg']);
    	$payment_data         = array(
    		'user_id' => $pt->user->id,
    		'type'    => $pkg_type,
    		'amount'  => $sum,
    		'date'    => date('n') . '/' . date('Y'),
    		'expire'  => strtotime("+30 days")
    	);

    	$db->insert(T_PAYMENTS,$payment_data);
    	$db->where('user_id',$pt->user->id)->update(T_VIDEOS,array('featured' => 1));
    	$_SESSION['upgraded'] = true;
    	header('Location: ' . PT_Link('go_pro'));
    	exit();
    }
}


//Manage pro system from admin side

if (PT_IsAdmin() && !empty($_GET['first'])) {
	
	
	if ($_GET['first'] == 'remove_expired') {
		$data['status'] = 400;
		$expired_subs   = $db->where('expire',time(),'<')->get(T_PAYMENTS);
		$update         = array('is_pro' => 0,'verified' => 0);
		foreach ($expired_subs as $subscriber){
			$db->where('id',$subscriber->user_id)->update(T_USERS,$update);
			$db->where('user_id',$subscriber->user_id)->update(T_VIDEOS,array('featured' => 0));
		}

		$data['status'] = 200;

	}

}





if (!empty($_GET['first']) && $_GET['first'] == 'pay_to_see') {

	if (!empty($_POST['video_id']) && is_numeric($_POST['video_id'])) {
		$video = PT_GetVideoByID($_POST['video_id'], 0,0,2);
		if (!empty($video)) {
			$redirectUrls->setReturnUrl(PT_Link('aj/go_pro/paid_to_see?status=success&video_id='.$video->id))->setCancelUrl(PT_Link(''));    
		    $item->setName('Pay to view video')->setQuantity(1)->setPrice($video->sell_video)->setCurrency($payment_currency);  
		    $itemList->setItems(array($item));    
		    $details->setSubtotal($video->sell_video);
		    $amount->setCurrency($payment_currency)->setTotal($video->sell_video)->setDetails($details);
		    $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Pay to view video')->setInvoiceNumber(time());
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
}


if (!empty($_GET['first']) && $_GET['first'] == 'paid_to_see') {
	$data['status'] = 500;
	$request        = (!empty($_GET['paymentId']) && !empty($_GET['PayerID']) && !empty($_GET['status']) && $_GET['status'] == 'success');
	$video_id       = (!empty($_GET['video_id']) && is_numeric($_GET['video_id'])) ? PT_Secure($_GET['video_id']) : 0;

	if ($request && $video_id) {
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
            header('Location: ' . PT_Link(''));
	        echo json_encode($data);
	    	exit();
	    }
	    
	    if (!empty($video_id)) {
	    	$video = PT_GetVideoByID($video_id, 0,0,2);
	    	if (!empty($video)) {
	    		$admin__com = $pt->config->admin_com_sell_videos;
	    		if ($pt->config->com_type == 1) {
	    			$admin__com = ($pt->config->admin_com_sell_videos * $video->sell_video)/100;
	    			$payment_currency = $payment_currency.'_PERCENT';
	    		}
	    		$payment_data         = array(
		    		'user_id' => $video->user_id,
		    		'video_id'    => $video->id,
		    		'paid_id'  => $pt->user->id,
		    		'amount'    => $video->sell_video,
		    		'admin_com'    => $pt->config->admin_com_sell_videos,
		    		'currency'    => $payment_currency,
		    		'time'  => time()
		    	);
		    	$db->insert(T_VIDEOS_TRSNS,$payment_data);
		    	$balance = $video->sell_video - $admin__com;
		    	$db->rawQuery("UPDATE ".T_USERS." SET `balance` = `balance`+ '".$balance."' , `verified` = 1 WHERE `id` = '".$video->user_id."'");

                $uniq_id = $video->video_id;
                $notif_data = array(
                    'notifier_id' => $pt->user->id,
                    'recipient_id' => $video->user_id,
                    'type' => 'paid_to_see',
                    'url' => "watch/$uniq_id",
                    'video_id' => $video->id,
                    'time' => time()
                );
                
                pt_notify($notif_data);

		    	header('Location: ' . $video->url);
		    	exit();
	    	}
	    	
	    }
	}
	header('Location: ' . PT_Link(''));
	exit();
}

