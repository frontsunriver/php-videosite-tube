<?php 
if (IS_LOGGED == true || $pt->config->two_factor_setting != 'on') {
	header("Location: " . PT_Link(''));
	exit();
}
// if ($pt->config->two_factor_type == 'email') {
// 	$message = $lang->sent_two_factor_email;
// }
// elseif ($pt->config->two_factor_type == 'phone') {
// 	$message = $lang->sent_two_factor_phone;
// }
// else{
// 	$message = $lang->sent_two_factor_both;
// }
$message = $lang->sent_two_factor_email;
$pt->page        = 'login';
$pt->title       = $lang->two_factor . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword     = $pt->config->keyword;
$pt->content     = PT_LoadPage('auth/two_factor_login/content',array('MESSAGE' => $message,
                                                                     'ERROR' => ''));