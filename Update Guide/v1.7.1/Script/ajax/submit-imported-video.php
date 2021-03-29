<?php
if (IS_LOGGED == false || $pt->config->import_system != 'on') {
    $data = array('status' => 400, 'error' => 'Not logged in');
    echo json_encode($data);
    exit();
}

$getID3 = new getID3;

if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['tags']) || empty($_POST['thumbnail-image'])) {
    $error = $lang->please_check_details;
}

else if (empty($_POST['video-id']) || empty($_POST['video-type'])) {
    $error = $lang->video_not_found_please_try_again;
}

else if (!empty($_FILES['thumbnail'])) {
    $media_file = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    $img_types  = array(IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG,IMAGETYPE_BMP);

    if (!in_array($media_file[2],$img_types)) {
        $error  = $lang->ivalid_thumb_file;
    }
}
elseif (!empty($_POST['duration']) && $_POST['video-type'] == 'mp4' && !preg_match('/[0-9]*:[0-9]{2}/i', $_POST['duration'])) {
   $error = $lang->duration_fromat;
}
if (empty($error)) {

	$duration        = '00:00';
    $video_id        = PT_GenerateKey(15, 15);
    $check_for_video = $db->where('video_id', $video_id)->getValue(T_VIDEOS, 'count(*)');
    $thumbnail       = PT_Secure($_POST['thumbnail-image'], 0);
    $category_id     = 0;
    $type            = "";
    $link_regex      = '/(http\:\/\/|https\:\/\/|www\.)([^\ ]+)/i';
    $i               = 0;
    $video_ok        = false;

    if (!empty($_POST['duration'])) {
        $duration = PT_Secure($_POST['duration']);
    }
    
    if ($check_for_video > 0) {
        $video_id = PT_GenerateKey(15, 15);
    }
    
    if (!empty($_FILES['thumbnail']['tmp_name'])) {
        $file_info = array(
            'file' => $_FILES['thumbnail']['tmp_name'],
            'size' => $_FILES['thumbnail']['size'],
            'name' => $_FILES['thumbnail']['name'],
            'type' => $_FILES['thumbnail']['type'],
            'allowed'    => 'jpg,png,jpeg,gif',
            'crop'       => array(
                'width'  => 538,
                'height' => 302
            )
        );

        $file_upload   = PT_ShareFile($file_info);
        if (!empty($file_upload['filename'])) {
            $thumbnail = PT_Secure($file_upload['filename'], 0);
        }
    }

    if (!empty($_POST['category_id'])) {
        if (in_array($_POST['category_id'], array_keys(get_object_vars($pt->categories)))) {
            $category_id = PT_Secure($_POST['category_id']);
        }
    }

    
    preg_match_all($link_regex, PT_Secure($_POST['description']), $matches);
    foreach ($matches[0] as $match) {
        $match_url            = strip_tags($match);
        $syntax               = '[a]' . urlencode($match_url) . '[/a]';
        $_POST['description'] = str_replace($match, $syntax, $_POST['description']);
    }
    $video_privacy = 0;
    if (!empty($_POST['privacy'])) {
        if (in_array($_POST['privacy'], array(0, 1, 2))) {
            $video_privacy = PT_Secure($_POST['privacy']);
        }
    }
    $age_restriction = 1;
    if (!empty($_POST['age_restriction'])) {
        if (in_array($_POST['age_restriction'], array(1, 2))) {
            $age_restriction = PT_Secure($_POST['age_restriction']);
        }
    }
    $sub_category = 0;

    if (!empty($_POST['sub_category_id'])) {
        $is_found = $db->where('type',PT_Secure($_POST['category_id']))->where('lang_key',PT_Secure($_POST['sub_category_id']))->getValue(T_LANGS,'COUNT(*)');
        if ($is_found > 0) {
            $sub_category = PT_Secure($_POST['sub_category_id']);
        }
    }
    $continents_list = array();
    if (!empty($_POST['continents-list'])) {
        foreach ($_POST['continents-list'] as $key => $value) {
            if (in_array($value, $pt->continents)) {
                $continents_list[] = $value;
            }
        }
    }
    $data_insert      = array(
        'video_id'    => $video_id,
        'user_id'     => $user->id,
        'title'       => PT_Secure($_POST['title']),
        'description' => PT_Secure($_POST['description']),
        'tags'        => PT_Secure($_POST['tags']),
        'duration'    => $duration,
        'category_id' => $category_id,
        'thumbnail'   => $thumbnail,
        'time'        => time(),
        'registered'  => date('Y') . '/' . intval(date('m')),
        'type'        => $type,
        'privacy' => $video_privacy,
        'age_restriction' => $age_restriction,
        'sub_category' => $sub_category,
        'geo_blocking' => (!empty($continents_list) ? json_encode($continents_list) : '')
    );

    if ((($pt->config->usr_v_mon == 'on' && $pt->config->user_mon_approve == 'off') || ($pt->config->usr_v_mon == 'on' && $pt->config->user_mon_approve == 'on' && $pt->user->monetization == '1')) && $pt->user->video_mon == '1' && in_array($_POST['monetization'], array('0','1'))) {
        $data_insert['monetization'] = PT_Secure($_POST['monetization']);
    }

    if ($pt->config->approve_videos == 'on' && !PT_IsAdmin()) {
        $data_insert['approved'] = 0;
    }



    
    if ($_POST['video-type'] == 'youtube') {
    	$data_insert['youtube'] = PT_Secure($_POST['video-id']);
    	$video_ok = true;
    }

    if ($_POST['video-type'] == 'vimeo') {
    	$data_insert['vimeo'] = PT_Secure($_POST['video-id']);
    	$video_ok = true;
    }

    if ($_POST['video-type'] == 'daily') {
        $data_insert['daily'] = PT_Secure($_POST['video-id']);
        $video_ok = true;
    }

    if ($_POST['video-type'] == 'ok') {
        $data_insert['ok'] = PT_Secure($_POST['video-id']);
        $video_ok = true;
    }

    if ($_POST['video-type'] == 'facebook') {
        $data_insert['facebook'] = urlencode($_POST['video-id']);
        $video_ok            = true;
    }

    if ($_POST['video-type'] == 'mp4') {
        $data_insert['video_location'] = urlencode($_POST['video-id']);
    	$data_insert['type'] = 4;
    	$video_ok            = true;
    }
    if ($_POST['video-type'] == 'twitch') {
        $data_insert['twitch'] = PT_Secure($_POST['video-id']);
        $data_insert['twitch_type'] = PT_Secure($_POST['twitch_type']);
        $video_ok = true;
    }

    if ($video_ok == true) {
    	$insert   = $db->insert(T_VIDEOS, $data_insert);

	    if ($insert) {
	        $data          = array(
	            'status'   => 200,
	            'video_id' => $video_id,
	            'link'     => PT_Link("watch/$video_id")
	        );
	    }
    }
} 

else {
    $data = array(
        'status'  => 400,
        'message' => $error_icon . $error
    );
}
