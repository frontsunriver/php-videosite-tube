<?php
if (!IS_LOGGED) {
	exit;
}

$pt->page        = 'import-video-api';
$pt->title       = $lang->home . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword     = $pt->config->keyword;

echo PT_LoadPage("hybird_view/content",array(
	'CONTENT' => PT_LoadPage("import-video/content"),
	'EXTRA_JS' => PT_LoadPage("extra-js/content"),
	'IS_LOGGED' => (IS_LOGGED == true) ? 'data-logged="true"' : '',
));
exit();