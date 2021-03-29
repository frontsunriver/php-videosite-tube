<?php 

if (!empty($first)) {
	
	if ($first == 'share' && !empty($_POST['post_id']) && is_numeric($_POST['post_id'])) {
		$post_id     = $_POST['post_id'];
		$get_post    = $db->where('id', $post_id)->getOne(T_POSTS);
		$data        = array('status' => 400);
		if (!empty($get_post)) {
			$shared  = ($get_post->shared += 1);
			$up_data = array('shared' => $shared);
			$db->where('id', $post_id)->update(T_POSTS,$up_data);
			$data['status'] = 200;
			$data['shared'] = $shared;
		}
	}
}

if ($first == 'hide-announcement' && IS_LOGGED === true) {
    $request        = (!empty($_POST['id']) && is_numeric($_POST['id']));
    $data['status'] = 400;
    if ($request === true) {
        $announcement_id = PT_Secure($_POST['id']);
        $user_id         = $pt->user->id;
        $insert_data     = array(
        	'announcement_id' => $announcement_id,
        	'user_id'         => $user_id
        );

        $db->insert(T_ANNOUNCEMENT_VIEWS,$insert_data);
        $data['status'] = 200;
    }
}

if ($first == 'yes_18') {
	setcookie("pop_up_18", 'yes', time() + (10 * 365 * 24 * 60 * 60), "/");
	$data['status'] = 200;
}
if ($first == 'no_18') {
	setcookie("pop_up_18", 'no', time() + ($pt->config->time_18 * 60), "/");
	$data['url']    = $pt->config->site_url.'/age_block';
	$data['status'] = 200;
}