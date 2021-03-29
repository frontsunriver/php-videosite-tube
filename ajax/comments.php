<?php
if (IS_LOGGED == false) {
    $data = array('status' => 400, 'error' => 'Not logged in');
    echo json_encode($data);
    exit();
}

if ($_GET['first'] == 'get_comment' && !empty($_POST['id'])) {
	$data['status'] = 400;
	$id = PT_Secure($_POST['id']);
	$comment = $db->where('id',$id)->getOne(T_COMMENTS);
	if (!empty($comment)) {
		$duration_search = '/\[d\](.*?)\[\/d\]/i';

	    if (preg_match_all($duration_search, $comment->text, $matches)) {
	        foreach ($matches[1] as $match) {
	            $comment->text = str_replace('[d]' . $match . '[/d]', $match, $comment->text);
	        }
	    }

	    $link_search = '/\[a\](.*?)\[\/a\]/i';
        if (preg_match_all($link_search, $comment->text, $matches)) {
            foreach ($matches[1] as $match) {
                $match_decode     = urldecode($match);
                $match_decode_url = $match_decode;
                $count_url        = mb_strlen($match_decode);
                if ($count_url > 50) {
                    $match_decode_url = mb_substr($match_decode_url, 0, 30) . '....' . mb_substr($match_decode_url, 30, 20);
                }
                $match_url = $match_decode;
                if (!preg_match("/http(|s)\:\/\//", $match_decode)) {
                    $match_url = 'http://' . $match_url;
                }
                $comment->text = str_replace('[a]' . $match . '[/a]', strip_tags($match_url), $comment->text);
            }
        }
        $data['status'] = 200;
        $data['text'] = $comment->text;
	}
}

if ($_GET['first'] == 'update_comment' && !empty($_POST['id']) && !empty($_POST['text'])) {
	$data['status'] = 400;
	$id = PT_Secure($_POST['id']);
	$comment = $db->where('id',$id)->getOne(T_COMMENTS);
	$video = $db->where('id',$comment->video_id)->getOne(T_VIDEOS);
	if ($comment->user_id == $pt->user->id || $video->user_id == $pt->user->id) {
		$text = PT_Secure($_POST['text']);
		$link_regex = '/(http\:\/\/|https\:\/\/|www\.)([^\ ]+)/i';
	    $i          = 0;
	    preg_match_all($link_regex, $text, $matches);
	    foreach ($matches[0] as $match) {
	        $match_url = strip_tags($match);
	        $syntax    = '[a]' . urlencode($match_url) . '[/a]';
	        $text      = str_replace($match, $syntax, $text);
	    }
	    $link_regex = '/[0-9]*:[0-9]{2}/i';
	    $i          = 0;
	    preg_match_all($link_regex, $text, $matches);
	    
	    foreach ($matches[0] as $match) {
	        $syntax    = '[d]' . $match . '[/d]';
	        $text      = str_replace($match, $syntax, $text);
	    }
	    $db->where('id',$id)->update(T_COMMENTS,array('text' => $text));
	    $new_text = PT_Duration($text);
	    $new_text = PT_Markup($new_text);
	    $data['status'] = 200;
	    $data['text'] = $new_text;
	}
}