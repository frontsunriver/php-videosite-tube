<?php 
if (IS_LOGGED == false) {
	$data = array('status' => 400, 'error' => 'Not logged in');
    echo json_encode($data);
    exit();
}
else{

	$user_id   = $pt->user->id;
	$type      = (!empty($_GET['t'])) ? PT_Secure($_GET['t']) : 'all';
	$show_all  = (!empty($_GET['sa'])) ? PT_Secure($_GET['sa']) : false;
	$html      = "";
	$t_notif   = T_NOTIFICATIONS;

	$notif_set = pt_get_notification(array(
		'recipient_id' => $user_id,
		'type' => $type
	));

	if ($type == 'new' && !empty($notif_set) && is_numeric($notif_set)) {
		$data['status'] = 200;
		$data['new']    = intval($notif_set);

	}

	else if ($type == 'all' && count($notif_set) > 0) {
		$update = array();
		$new    = 0;

		foreach ($notif_set as $data_row) {
			$data_row['notifier'] = PT_UserData($data_row['notifier_id']);
			$icon  = $pt->notif_data[$data_row['type']]['icon'];
			$title  = $pt->notif_data[$data_row['type']]['text'];
			$pt->notify = $data_row;
			$url = PT_Link($data_row['url']);
			if (!empty($data_row['full_link'])) {
				$url = $data_row['full_link'];
			}

			$html .= PT_LoadPage('header/notifications',array(
				'ID' => $data_row['id'],
				'USER_DATA' => $data_row['notifier'],
				'TITLE' => $title,
				'TEXT' => $data_row['text'],
				'URL' => $url,
				'TIME' => PT_Time_Elapsed_String($data_row['time']),
				'ICON' => $icon
			));

			$update[] = $data_row['id'];

			if (empty($data_row['seen'])) {
				$new++;
			}
		}

		if (!empty($show_all)) {
			$db->where('recipient_id', $pt->user->id)->update($t_notif,array('seen' => time()));
		}
		
		
		$data['status'] = 200;
		$data['html']   = $html;
		$data['len']    = count($notif_set);

	}
	else{
		$data['status'] = 304;
	}
}
$data['count_messages'] = $db->where('to_id', $user->id)->where('seen', 0)->getValue(T_MESSAGES, "COUNT(*)");
// user active
$time = strtotime(date('l').", ".date('M')." ".date('d').", ".date('Y'));

if (date('l') == 'Friday') {
	$week_end = strtotime(date('M')." ".date('d').", ".date('Y')." 11:59pm");
}
else{
	$week_end = strtotime('next Friday, 11:59pm', $time);
}

if (empty($pt->user->active_expire) || $pt->user->active_expire <= time()) {
	$db->where('id', $pt->user->id)->update(T_USERS,array('active_expire' => $week_end,
														  'active_time' => 6));
	$_SESSION['active_time'] = time()+6;
}
else{
	if (empty($_SESSION['active_time']) || (!empty($_SESSION['active_time']) && $_SESSION['active_time'] <= time())) {
		$db->where('id', $pt->user->id)->update(T_USERS,array('active_time' => $db->inc(6)));
		$_SESSION['active_time'] = time()+6;
	}
}
// user active