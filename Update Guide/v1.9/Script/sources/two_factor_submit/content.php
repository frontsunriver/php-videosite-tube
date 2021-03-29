<?php 
if (IS_LOGGED == true || $pt->config->two_factor_setting != 'on' || empty($_POST['code'])) {
	header("Location: " . PT_Link(''));
	exit();
}

$code = md5($_POST['code']);
$db->where("email_code", $code);
$login = $db->getOne(T_USERS);
if (!empty($login)) {
	$session_id          = sha1(rand(11111, 99999)) . time() . md5(microtime());
    $insert_data         = array(
        'user_id' => $login->id,
        'session_id' => $session_id,
        'time' => time()
    );
    $insert              = $db->insert(T_SESSIONS, $insert_data);
    $_SESSION['user_id'] = $session_id;
    setcookie("user_id", $session_id, time() + (10 * 365 * 24 * 60 * 60), "/");
    $pt->loggedin = true;
    if (!empty($_GET['to'])) {
        $_GET['to'] = strip_tags($_GET['to']);
        $site_url = $_GET['to'];
    }

    $db->where('id',$login->id)->update(T_USERS,array(
        'ip_address' => get_ip_address()
    ));
    
    header("Location: $site_url");
    exit();
}
else{
	$error = $lang->wrong_confirm_code;
	$pt->page        = 'login';
	$pt->title       = $lang->two_factor . ' | ' . $pt->config->title;
	$pt->description = $pt->config->description;
	$pt->keyword     = $pt->config->keyword;
	$pt->content     = PT_LoadPage('auth/two_factor_login/content',array('MESSAGE' => '',
                                                                         'ERROR' => $error));
}

