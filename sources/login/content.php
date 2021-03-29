<?php
if (IS_LOGGED == true) {
	header("Location: " . PT_Link(''));
	exit();
}

$color1 = '0095D8';
$color2 = '87ddff';

$errors   = '';
$username = '';
if (!empty($_POST)) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $errors = $error_icon . $lang->please_check_details;
    } 
    else {
        $username        = PT_Secure($_POST['username']);
        $password        = PT_Secure($_POST['password']);
        $password_hashed = sha1($password);
        $db->where("(username = ? or email = ?)", array(
            $username,
            $username
        ));

        $db->where("password", $password_hashed);
        $login = $db->getOne(T_USERS);
        
        if (!empty($login)) {
            if ($login->active == 0) {
                $errors = $error_icon . $lang->account_is_not_active . ' <a href="{{LINK resend/' . $login->email_code . '/' . $login->username . '}}">' . $lang->resend_email . '</a>';
            } 

            else {
                if ($pt->config->two_factor_setting == 'on' && $login->two_factor == 1) {
                    $email        = $login->email;
                    $db->where("email", $email);
                    $user_id = $db->getValue(T_USERS, "id");
                    if (!empty($user_id)) {
                           $rest_user = PT_UserData($user_id);
                           $email_code = rand(111111, 999999);
                           $hash_code = md5($email_code);
                           $update_data = array('email_code' => $hash_code);
                           $db->where('id', $rest_user->id);
                           $update = $db->update(T_USERS, $update_data);
                           $update_data['USER_DATA'] = $rest_user;
                           $message = "Your confirmation code is: $email_code";
                           $send_email_data = array(
                                'from_email' => $pt->config->email,
                                'from_name' => $pt->config->name,
                                'to_email' => $email,
                                'to_name' => $rest_user->name,
                                'subject' => 'Confirmation code',
                                'charSet' => 'UTF-8',
                                'message_body' => $message,
                                'is_html' => true
                            );
                            $send_message = PT_SendMessage($send_email_data);
                            if ($send_message) {
                                $success = $success_icon . $lang->email_sent;
                            }
                    }
                    header("Location: $site_url/two_factor_login");
                    exit();
                }
                $session_id          = sha1(rand(11111, 99999)) . time() . md5(microtime());
                $platform_details = serialize(getBrowser());
                $insert_data         = array(
                    'user_id' => $login->id,
                    'session_id' => $session_id,
                    'platform_details' => $platform_details,
                    'time' => time()
                );
                $insert              = $db->insert(T_SESSIONS, $insert_data);
                $_SESSION['user_id'] = $session_id;
                setcookie("user_id", $session_id, time() + (10 * 365 * 24 * 60 * 60), "/");
                $pt->loggedin = true;

                if (!empty($_GET['to']) && strpos($_GET['to'], $pt->config->site_url) !== false) {
                    $_GET['to'] = strip_tags($_GET['to']);
                    $site_url = $_GET['to'];
                }
                

                $db->where('id',$login->id)->update(T_USERS,array(
                    'ip_address' => get_ip_address()
                ));
                
                header("Location: $site_url");
                exit();
            }
        } else {
            $errors = $error_icon . $lang->invalid_username_or_password;
        }
    }
}
if (empty($_POST) && !empty($_GET['resend'])) {
    $_GET['resend'] = strip_tags($_GET['resend']);
    $errors = $success_icon . $lang->email_sent;
}
$pt->page        = 'login';
$pt->title       = $lang->login . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword     = $pt->config->keyword;
$pt->content     = PT_LoadPage('auth/login/content', array(
    'COLOR1' => $color1,
    'COLOR2' => $color2,
    'ERRORS' => $errors,
    'USERNAME' => $username
));