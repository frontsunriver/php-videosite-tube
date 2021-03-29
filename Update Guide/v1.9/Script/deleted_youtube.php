<?php
require_once('./assets/init.php');
$videos = $db->where('youtube','','<>')->get(T_VIDEOS,null,array('youtube','id'));
if (!empty($videos)) {
	foreach ($videos as $key => $video) {
		$url = 'http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v='.$video->youtube.'&format=json';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
		curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,10);
		$output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($httpcode == '404') {
			PT_DeleteVideo($video->id);
		}
	}
}