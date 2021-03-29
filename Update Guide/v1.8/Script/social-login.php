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
$provider = "";
$types = array(
    'Google',
    'Facebook',
    'Twitter',
    'LinkedIn',
    'Vkontakte',
    'Instagram'
);

if (isset($_GET['provider']) && in_array($_GET['provider'], $types)) {
    $provider = PT_Secure($_GET['provider']);
}

require_once('./assets/import/social-login/config.php');
require_once('./assets/import/social-login/autoload.php');

use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

if (isset($_GET['provider']) && in_array($_GET['provider'], $types)) {
    try {
        $hybridauth   = new Hybridauth($LoginWithConfig);
        $authProvider = $hybridauth->authenticate($provider);
        $tokens = $authProvider->getAccessToken();
        $user_profile = $authProvider->getUserProfile();
        if ($user_profile && isset($user_profile->identifier)) {
            $name = $user_profile->firstName;
            if ($provider == 'Google') {
                $notfound_email     = 'go_';
                $notfound_email_com = '@google.com';
            } else if ($provider == 'Facebook') {
                $notfound_email     = 'fa_';
                $notfound_email_com = '@facebook.com';
            } else if ($provider == 'Twitter') {
                $notfound_email     = 'tw_';
                $notfound_email_com = '@twitter.com';
            }
            $user_name  = $notfound_email . $user_profile->identifier;
            $user_email = $user_name . $notfound_email_com;
            if (!empty($user_profile->email)) {
                $user_email = $user_profile->email;
            }
            if (PT_UserEmailExists($user_email) === true) {
            	$db->where('email', $user_email);
            	$login = $db->getOne(T_USERS);
                $session_id          = sha1(rand(11111, 99999)) . time() . md5(microtime());
                $insert_data         = array(
                    'user_id' => $login->id,
                    'session_id' => $session_id,
                    'time' => time()
                );
                $insert              = $db->insert(T_SESSIONS, $insert_data);
                $_SESSION['user_id'] = $session_id;
                setcookie("user_id", $session_id, time() + (10 * 365 * 24 * 60 * 60), "/");
                header("Location: $site_url");
                exit();
            } else {
                $str          = md5(microtime());
                $id           = substr($str, 0, 9);
                $password     = substr(md5(time()), 0, 9);
                $user_uniq_id = (empty($db->where('username', $id)->getValue(T_USERS, 'id'))) ? $id : 'u_' . $id;
                $social_url   = substr($user_profile->profileURL, strrpos($user_profile->profileURL, '/') + 1);
                $re_data      = array(
                    'username' => PT_Secure($user_uniq_id, 0),
                    'email' => PT_Secure($user_email, 0),
                    'password' => PT_Secure(sha1($password), 0),
                    'email_code' => PT_Secure(sha1($user_uniq_id), 0),
                    'first_name' => PT_Secure($name),
                    'last_name' => PT_Secure($user_profile->lastName),
                    'avatar' => PT_Secure(PT_ImportImageFromLogin($user_profile->photoURL)),
                    'src' => PT_Secure($provider),
                    'active' => '1'
                );
                $re_data['language'] = $pt->config->language;
                if (!empty($_SESSION['lang'])) {
                    if (in_array($_SESSION['lang'], $langs)) {
                        $re_data['language'] = $_SESSION['lang'];
                    }
                }
                if ($provider == 'Google') {
                    $re_data['about']  = PT_Secure($user_profile->description);
                    $re_data['google'] = PT_Secure($social_url);
                }
                if ($provider == 'Facebook') {
                    $fa_social_url       = @explode('/', $user_profile->profileURL);
                    $re_data['facebook'] = PT_Secure($fa_social_url[4]);
                    $re_data['gender'] = 'male';
                    if (!empty($user_profile->gender)) {
                        if ($user_profile->gender == 'male') {
                            $re_data['gender'] = 'male';
                        } else if ($user_profile->gender == 'female') {
                            $re_data['gender'] = 'female';
                        }
                    }
                }
                if ($provider == 'Twitter') {
                    $re_data['twitter'] = PT_Secure($social_url);
                }
                $insert_id = $db->insert(T_USERS, $re_data);
                if ($insert_id) {

                    if (!empty($pt->config->auto_subscribe)) {
                        $get_users = explode(',', $pt->config->auto_subscribe);
                        foreach ($get_users as $key => $username) {
                            $user  = $db->where('username', $username)->getOne(T_USERS);
                            if (!empty($user)) {
                                $insert_data         = array(
                                    'user_id' => $user->id,
                                    'subscriber_id' => $insert_id,
                                    'time' => time(),
                                    'active' => 1
                                );
                                $create_subscription = $db->insert(T_SUBSCRIPTIONS, $insert_data);
                                if ($create_subscription) {
                                    $current_user = $db->where('id', $insert_id)->getOne(T_USERS);
                                    $data = array(
                                        'status' => 200
                                    );

                                    $notif_data = array(
                                        'notifier_id' => $insert_id,
                                        'recipient_id' => $user->id,
                                        'type' => 'subscribed_u',
                                        'url' => ('@' . $current_user->username),
                                        'time' => time()
                                    );

                                    pt_notify($notif_data);
                                }
                            } 
                        }
                    }

                    $session_id          = sha1(rand(11111, 99999)) . time() . md5(microtime());
	                $insert_data         = array(
	                    'user_id' => $insert_id,
	                    'session_id' => $session_id,
	                    'time' => time()
	                );
	                $insert              = $db->insert(T_SESSIONS, $insert_data);
	                $_SESSION['user_id'] = $session_id;
	                setcookie("user_id", $session_id, time() + (10 * 365 * 24 * 60 * 60), "/");
	                header("Location: $site_url");
	                exit();
                } 
            }
        }
    }
    catch (Exception $e) {
        exit($e->getMessage());
        switch ($e->getCode()) {
            case 0:
                echo "Unspecified error.";
                break;
            case 1:
                echo "Hybridauth configuration error.";
                break;
            case 2:
                echo "Provider not properly configured.";
                break;
            case 3:
                echo "Unknown or disabled provider.";
                break;
            case 4:
                echo "Missing provider application credentials.";
                break;
            case 5:
                echo "Authentication failed The user has canceled the authentication or the provider refused the connection.";
                break;
            case 6:
                echo "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                break;
            case 7:
                echo "User not connected to the provider.";
                break;
            case 8:
                echo "Provider does not support this feature.";
                break;
        }
        echo " an error found while processing your request!";
        echo " <b><a href='" . PT_Link('') . "'>Try again<a></b>";
    }
} else {
    header("Location: " . PT_Link(''));
    exit();
}