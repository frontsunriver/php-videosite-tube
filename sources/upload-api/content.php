<?php 
if (IS_LOGGED == false || $pt->config->upload_system != 'on') {
	exit('Not logged in');
}
$content         = 'content';

if($pt->config->ffmpeg_system == 'on'){
	$content     = 'ffmpeg';
}

$max_user_upload = $pt->config->user_max_upload;
if ($pt->user->is_pro != 1 && $pt->config->go_pro == "on") {
	if ($pt->user->uploads >= $max_user_upload) {
		$content = "buy_pro";
	}
}

$pt->page        = 'upload-video-api';
$pt->title       = $lang->home . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword     = $pt->config->keyword;
$pt->content     = PT_LoadPage("upload-video/$content");