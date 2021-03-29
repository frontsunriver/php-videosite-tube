<?php
// +------------------------------------------------------------------------+
// | @author Deen Doughouz (DoughouzForest)
// | @author_url 1: http://www.playtubescript.com
// | @author_url 2: http://codecanyon.net/user/doughouzforest
// | @author_email: wowondersocial@gmail.com   
// +------------------------------------------------------------------------+
// | PlayTube - The Ultimate Video Sharing Platform
// | Copyright (c) 2017 PlayTube. All rights reserved.
// +------------------------------------------------------------------------+


require_once('./assets/init.php');
$users_id = $db->where('subscriber_price',0,'>')->get(T_USERS,null,array('id'));
$ids = array();
foreach ($users_id as $key => $value) {
	$ids[] = $value->id;
}
$db->where('user_id',$ids,"IN")->where('time',strtotime("-30 days"),'<')->delete(T_SUBSCRIPTIONS);