<?php 
if (IS_LOGGED == false || $pt->config->import_system != 'on') {
	header("Location: " . PT_Link('login'));
	exit();
}
if ($pt->user->suspend_import) {
	header("Location: " . PT_Link(''));
	exit();
}
$pt->sub_categories_array = array();
foreach ($pt->sub_categories as $cat_key => $subs) {
	$pt->sub_categories_array["'".$cat_key."'"] = '<option value="0">'.$lang->none.'</option>';
	foreach ($subs as $sub_key => $sub_value) {
		$pt->sub_categories_array["'".$cat_key."'"] .= '<option value="'.array_keys($sub_value)[0].'">'.$sub_value[array_keys($sub_value)[0]].'</option>';
	}
}

$content         = 'content';
$max_import      = $pt->config->user_max_import;

if ($pt->user->is_pro != 1) {
	if ($pt->user->imports >= $max_import) {
		$content = "buy_pro";
	}
}
$pt->page_url_ = $pt->config->site_url.'/import-video';
$pt->page = 'import-video';
$pt->title = $lang->import_new_video . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword = $pt->config->keyword;
$pt->content = PT_LoadPage("import-video/$content");