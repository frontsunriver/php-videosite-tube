<?php 

if (!IS_LOGGED || $pt->config->user_ads != 'on') {
	header('Location: ' . PT_Link('404'));
	exit;
}

// Get user ads related data ..
$payment_currency = $pt->config->payment_currency;
$currency         = "";
if ($payment_currency == "USD") {
	$currency     = "$";
}
else if($payment_currency == "EUR"){
	$currency     = "€";
}

$user_ads        = $db->where('user_id',$user->id)->orderBy('id','DESC')->get(T_USR_ADS);
$ads_list        = "";

foreach ($user_ads as $ad) {
	$ads_list   .= PT_LoadPage('ads/list',array(
		'ID' => $ad->id,
		'TYPE' => ($ad->category == 'image') ? 'image' : 'video_library',
		'NAME' => $ad->name,
		'PR_METHOD' => ($ad->type == 1) ? 'Clicks' : 'Views',
		'RESULTS' => $ad->results,
		'SPENT' => number_format($ad->spent,2),
		'ACTIVE' => (($ad->status == 1) ? 'checked' : ''),
		'CURRENCY'   => $currency,
	));
}
$pt->page_url_ = $pt->config->site_url.'/ads';
$pt->title       = $lang->ads . ' | ' . $pt->config->title;
$pt->page        = "user_ads";
$pt->description = $pt->config->description;
$pt->keyword     = @$pt->config->keyword;
$pt->content     = PT_LoadPage('ads/content',array(
	'CURRENCY'   => $currency,
	'ADS_LIST'   => $ads_list
));