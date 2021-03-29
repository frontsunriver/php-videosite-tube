<?php 
require_once('./assets/init.php');
if ($_GET['first'] == 'notify' && $_GET['action'] == 'notify') {

	if (($_POST['payment_status'] == 'Completed' || $_POST['payment_status'] == 'Processed' || $_POST['payment_status'] == 'In-Progress' || $_POST['payment_status'] == 'Pending') &&  strpos($_POST['item_name'] , 'user')) {
		
		$user_id = substr($_POST['item_name'], strpos($_POST['item_name'], 'user')+4);
		$user = PT_UserData($user_id);
		if (!empty($user)) {
			$amount  = PT_Secure($_POST['mc_gross']);
			$is_paid  = $db->where('user_id',$user_id)->getOne(T_PAYMENTS);
			if ($is_paid) {
			    if (($is_paid->expire - (60*60*24*30)) +(60*60*24*25) < time()) {
				    $db->where('user_id',$user_id)->update(T_PAYMENTS,array('expire' => strtotime("+30 days")));
			    }
			}
			else{
				$payment_data = array(
			        'user_id' => $user_id,
			        'type'  => 'pro',
			        'amount'  => $amount,
			        'date'    => date('n') . '/' . date('Y'),
			        'expire'  => strtotime("+30 days")
			    );

			    if ($db->insert(T_PAYMENTS,$payment_data)) {
			    	$update = array('is_pro' => 1,'verified' => 1);
				    $go_pro = $db->where('id',$user_id)->update(T_USERS,$update);
				    $db->where('user_id',$user_id)->update(T_VIDEOS,array('featured' => 1));
			    }
			}
		}
	}
	elseif(($_POST['payment_status'] == 'Declined' || $_POST['payment_status'] == 'Expired' || $_POST['payment_status'] == 'Failed' || $_POST['payment_status'] == 'Refunded' || $_POST['payment_status'] == 'Reversed') &&  strpos($_POST['item_name'] , 'user')){
		$user_id = substr($_POST['item_name'], strpos($_POST['item_name'], 'user')+4);
		$user = PT_UserData($user_id);
		if (!empty($user)) {
			$db->where('user_id',$user_id)->delete(T_PAYMENTS);
			$update = array('is_pro' => 0,'verified' => 0);
			$go_pro = $db->where('id',$user_id)->update(T_USERS,$update);
			$db->where('user_id',$user_id)->update(T_VIDEOS,array('featured' => 0));
		}
	}
}


?>

