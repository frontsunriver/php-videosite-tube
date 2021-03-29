<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(0);

@ini_set('max_execution_time', 0);
require 'config.php';
require 'phpMailer_config.php';
require 'assets/import/DB/vendor/autoload.php';
require 'assets/import/getID3-1.9.14/getid3/getid3.php';
require 'assets/import/youtube-sdk/vendor/autoload.php';
require 'assets/import/php-rss/vendor/autoload.php';
require 'assets/import/s3/aws-autoloader.php';

$pt     = ToObject(array());

// Connect to MySQL Server
$mysqli     = new mysqli($sql_db_host, $sql_db_user, $sql_db_pass, $sql_db_name);
$sqlConnect = $mysqli;




// Handling Server Errors
$ServerErrors = array();
if (mysqli_connect_errno()) {
    $ServerErrors[] = "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (!function_exists('curl_init')) {
    $ServerErrors[] = "PHP CURL is NOT installed on your web server !";
}
if (!extension_loaded('gd') && !function_exists('gd_info')) {
    $ServerErrors[] = "PHP GD library is NOT installed on your web server !";
}
if (!extension_loaded('zip')) {
    $ServerErrors[] = "ZipArchive extension is NOT installed on your web server !";
}

if (isset($ServerErrors) && !empty($ServerErrors)) {
    foreach ($ServerErrors as $Error) {
        echo "<h3>" . $Error . "</h3>";
    }
    die();
}
$query = $mysqli->query("SET NAMES utf8");
// Connecting to DB after verfication

$db = new MysqliDb($mysqli);


$http_header = 'http://';
if (!empty($_SERVER['HTTPS'])) {
    $http_header = 'https://';
}

$pt->site_pages           = array('home');
$pt->actual_link          = $http_header . $_SERVER['HTTP_HOST'] . urlencode($_SERVER['REQUEST_URI']);

$config                   = PT_GetConfig();
$pt->loggedin             = false;
$config['user_statics']   = stripslashes(htmlspecialchars_decode($config['user_statics']));
$config['videos_statics'] = stripslashes(htmlspecialchars_decode($config['videos_statics']));
$config['theme_url']      = $site_url . '/themes/' . $config['theme'];
$config['site_url']       = $site_url;
$pt->script_version = $config['version'];
$config['script_version'] = $pt->script_version;

$pt->extra_config = array();
$get_nodejs_config = file_get_contents('nodejs/config.json');
$config['hostname'] = '';
$config['server_port'] = '';
if (!empty($get_nodejs_config)) {
    $pt->extra_config = json_decode($get_nodejs_config);
    $config['hostname']  = $pt->extra_config->server_ip;
    $config['server_port']  = $pt->extra_config->server_port;
} else {
    exit('Please make sure the file: nodejs/config.json exists and readable.');
}

$site = parse_url($site_url);
if (empty($site['host'])) {
    $config['hostname'] = $site['scheme'] . '://' .  $site['host'];
}


$pt->config               = ToObject($config);
$langs                    = pt_db_langs();
$pt->langs                = $langs;

if (PT_IsLogged() == true) {
    $session_id        = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : $_COOKIE['user_id'];
    $pt->user_session  = PT_GetUserFromSessionID($session_id);
    $user = $pt->user  = PT_UserData($pt->user_session);
    $user->wallet      = number_format($user->wallet,2);
    
    if (!empty($user->language) && in_array($user->language, $langs)) {
        $_SESSION['lang'] = $user->language;
    }

    if ($user->id < 0 || empty($user->id) || !is_numeric($user->id) || PT_UserActive($user->id) === false) {
        header("Location: " . PT_Link('logout'));
    }
    $pt->loggedin   = true;
}

else if (!empty($_POST['user_id']) && !empty($_POST['s'])) {
    $platform       = ((!empty($_POST['platform'])) ? $_POST['platform'] : 'phone');
    $s              = PT_Secure($_POST['s']);
    $user_id        = PT_Secure($_POST['user_id']);
    $verify_session = verify_api_auth($user_id, $s, $platform);
    if ($verify_session === true) {
        $user = $pt->user  = PT_UserData($user_id);
        if (empty($user) || PT_UserActive($user->id) === false) {
            $json_error_data = array(
                'api_status' => '400',
                'api_text' => 'authentication_failed',
                'errors' => array(
                    'error_id' => '1',
                    'error_text' => 'Error 400 - The user does not exist'
                )
            );

            echo json_encode($json_error_data, JSON_PRETTY_PRINT);
            exit();
        }

        $pt->loggedin = true;
    } 
    else {
        $json_error_data = array(
            'api_status' => '400',
            'api_text' => 'authentication_failed',
            'errors' => array(
                'error_id' => '1',
                'error_text' => 'Error 400 - Session does not exist'
            )
        );
        echo json_encode($json_error_data, JSON_PRETTY_PRINT);
        exit();
    }  
} else if (!empty($_GET['user_id']) && !empty($_GET['s'])) {
    $platform       = ((!empty($_GET['platform'])) ? $_GET['platform'] : 'phone');
    $s              = PT_Secure($_GET['s']);
    $user_id        = PT_Secure($_GET['user_id']);
    $verify_session = verify_api_auth($user_id, $s, $platform);
    if ($verify_session === true) {
        $user = $pt->user  = PT_UserData($user_id);
        if (empty($user) || PT_UserActive($user->id) === false) {
            $json_error_data = array(
                'api_status' => '400',
                'api_text' => 'authentication_failed',
                'errors' => array(
                    'error_id' => '1',
                    'error_text' => 'Error 400 - The user does not exist'
                )
            );

            echo json_encode($json_error_data, JSON_PRETTY_PRINT);
            exit();
        }

        $pt->loggedin = true;
    } 
    else {
        $json_error_data = array(
            'api_status' => '400',
            'api_text' => 'authentication_failed',
            'errors' => array(
                'error_id' => '1',
                'error_text' => 'Error 400 - Session does not exist'
            )
        );
        echo json_encode($json_error_data, JSON_PRETTY_PRINT);
        exit();
    }  
}

elseif (!empty($_GET['cookie']) && $pt->loggedin != true) {
    $session_id            = $_GET['cookie'];
    $pt->user_session      = PT_GetUserFromSessionID($session_id);
    if (!empty($pt->user_session) && is_numeric($pt->user_session)) {
        $user = $pt->user  = PT_UserData($pt->user_session);
        $pt->loggedin      = true;

        if (!empty($user->language)) {
            if (file_exists(__DIR__ . '/../langs/' . $user->language . '.php')) {
                $_SESSION['lang'] = $user->language;
            }
        }
        setcookie("user_id", $session_id, time() + (10 * 365 * 24 * 60 * 60), "/");
    }
}


if (isset($_GET['lang']) AND !empty($_GET['lang'])) {
    $lang_name = PT_Secure(strtolower($_GET['lang']));

    if (in_array($lang_name, $langs)) {
        $_SESSION['lang'] = $lang_name;
        if ($pt->loggedin == true) {
            $db->where('id', $user->id)->update(T_USERS, array('language' => $lang_name));
        }
    }
}

if (empty($_SESSION['lang'])) {
    $_SESSION['lang'] = $pt->config->language;
}

if (isset($_SESSION['user_id'])) {
    if (empty($_COOKIE['user_id'])) {
        setcookie("user_id", $_SESSION['user_id'], time() + (10 * 365 * 24 * 60 * 60), "/");
    }
}

$pt->language      = $_SESSION['lang'];
$pt->language_type = 'ltr';

// Add rtl languages here.
$rtl_langs           = array(
    'arabic'
);

// checking if corrent language is rtl.
foreach ($rtl_langs as $lang) {
    if ($pt->language == strtolower($lang)) {
        $pt->language_type = 'rtl';
    }
}


// Include Language File
$lang_file = 'assets/langs/' . $pt->language . '.php';
if (file_exists($lang_file)) {
    require($lang_file);
}



$lang_array = pt_get_langs($pt->language);

if (empty($lang_array)) {
    $lang_array = pt_get_langs();
}

$lang       = ToObject($lang_array);
$pt->all_lang = $lang;

$pt->exp_feed    = false; 
$pt->userDefaultAvatar = 'upload/photos/d-avatar.jpg';
$pt->categories  = ToObject($categories);
$categories = array();
$sub_categories = array();

try {
    $all_categories = $db->where('type','category')->get(T_LANGS);
    $sub_categories = array();
    foreach ($all_categories as $key => $value) {
        $array_keys = array_keys($all_categories);
        if ($value->lang_key != 'other') {
            if (!empty($value->lang_key) && !empty($lang->{$value->lang_key})) {
                $categories[$value->lang_key] = $lang->{$value->lang_key};
            }
            $all_sub_categories = $db->where('type',$value->lang_key)->get(T_LANGS);

            if (!empty($all_sub_categories)) {
                foreach ($all_sub_categories as $key => $sub) {
                    $array = array();
                    if (!empty($sub->lang_key) && !empty($lang->{$sub->lang_key})) {
                        $array[$sub->lang_key] = $lang->{$sub->lang_key};
                        $sub_categories[$value->lang_key][] = $array;
                    }
                }
            }
        }
        if (end($array_keys) == $key) {
            $categories['other'] = $lang->other;
        }
        
    }
} catch (Exception $e) {

}

$pt->categories  = ToObject($categories);
$pt->sub_categories = $sub_categories;

$movies_categories = array();
try {
    $all_movies_categories = $db->where('type','movie_category')->get(T_LANGS);
    if (!empty($all_movies_categories)) {
    
        foreach ($all_movies_categories as $key => $value) {
            $array_keys = array_keys($all_movies_categories);
            if ($value->lang_key != 'other') {
                if (!empty($value->lang_key) && !empty($lang->{$value->lang_key})) {
                    $movies_categories[$value->lang_key] = $lang->{$value->lang_key};
                }
            }
            if (end($array_keys) == $key) {
                $movies_categories['other'] = $lang->other;
            }
        }
    }
    else{
        $movies_categories['other'] = $lang->other;
    }
} catch (Exception $e) {

}
$pt->movies_categories = $movies_categories;



$error_icon   = '<i class="fa fa-exclamation-circle"></i> ';
$success_icon = '<i class="fa fa-check"></i> ';
define('IS_LOGGED', $pt->loggedin);
define('none', null);



if (pt_is_banned($_SERVER["REMOTE_ADDR"]) === true) {
    $banpage = PT_LoadPage('terms/ban');
    exit($banpage);
}


if ($pt->config->user_ads == 'on') {

    if (!isset($_COOKIE['_uads'])) {
        setcookie('_uads', htmlentities(serialize(array(
            'date' => strtotime('+1 day'),
            'uaid_' => array()
        ))), time() + (10 * 365 * 24 * 60 * 60),'/');
    }

    $pt->user_ad_cons = array(
        'date' => strtotime('+1 day'),
        'uaid_' => array()
    );

    if (!empty($_COOKIE['_uads'])) {
        $pt->user_ad_cons = unserialize(html_entity_decode($_COOKIE['_uads']));
    }

    if (!is_array($pt->user_ad_cons) || !isset($pt->user_ad_cons['date']) || !isset($pt->user_ad_cons['uaid_'])) {
        setcookie('_uads', htmlentities(serialize(array(
            'date' => strtotime('+1 day'),
            'uaid_' => array()
        ))), time() + (10 * 365 * 24 * 60 * 60),'/');
    }

    if (is_array($pt->user_ad_cons) && isset($pt->user_ad_cons['date']) && $pt->user_ad_cons['date'] < time()) {
        setcookie('_uads', htmlentities(serialize(array(
            'date' => strtotime('+1 day'),
            'uaid_' => array()
        ))),time() + (10 * 365 * 24 * 60 * 60),'/');
    }
}

$pt->mode = (!empty($_COOKIE['mode'])) ? $_COOKIE['mode'] : null;
if ($pt->config->night_mode == 'night_default' && empty($pt->mode)) {
    $pt->mode = 'night';
}
if (empty($_COOKIE['mode']) || !in_array($_COOKIE['mode'], array('night','day')) && empty($pt->mode)) {
    $pt->mode = ($pt->config->night_mode == 'night_default' || $pt->config->night_mode == 'night') ? 'night' : 'day';
    setcookie("mode", $pt->mode, time() + (10 * 365 * 24 * 60 * 60), "/");
}

if (!empty($_POST['mode']) && in_array($_POST['mode'], array('night','day'))) {
    setcookie("mode", $_POST['mode'], time() + (10 * 365 * 24 * 60 * 60), "/");
    $pt->mode = $_POST['mode'];
}

if (!empty($_GET['mode']) && in_array($_GET['mode'], array('night','day'))) {
    setcookie("mode", $_GET['mode'], time() + (10 * 365 * 24 * 60 * 60), "/");
    $pt->mode = $_GET['mode'];
}

if ($pt->config->night_mode == 'light') {
    $pt->mode = 'light';
}

$site_url    = $pt->config->site_url;
$request_url = $_SERVER['REQUEST_URI'];
$fl_currpage = "{$site_url}{$request_url}";


if (empty($_SESSION['uploads'])) {

    $_SESSION['uploads'] = array();

    if (empty($_SESSION['uploads']['videos'])) {
        $_SESSION['uploads']['videos'] = array();
    }

    if (empty($_SESSION['uploads']['images'])) {
        $_SESSION['uploads']['images'] = array();
    }
}

$pt->theme_using = 'default';
$path_to_details = './themes/' . $config['theme'] . '/fonts/info.json';
if (file_exists($path_to_details)) {
    $get_theme_info = file_get_contents($path_to_details);
    $decode_json = json_decode($get_theme_info, true);
    if (!empty($decode_json['name'])) {
        $pt->theme_using = $decode_json['name'];
    }
}

$pt->continents = array('Asia','Australia','Africa','Europe','America','Atlantic','Pacific','Indian');
try {
    $pt->blocked_array = GetBlockedIds();
} catch (Exception $e) {
    $pt->blocked_array = [];
}

try {
    $pt->custom_pages = $db->get(T_CUSTOM_PAGES);
} catch (Exception $e) {
    $pt->custom_pages = [];
}

$pt->config->currency_array = unserialize($pt->config->currency_array);
$pt->config->currency_symbol_array = unserialize($pt->config->currency_symbol_array);

$pt->paypal_currency = array('USD','EUR','AUD','BRL','CAD','CZK','DKK','HKD','HUF','INR','ILS','JPY','MYR','MXN','TWD','NZD','NOK','PHP','PLN','GBP','RUB','SGD','SEK','CHF','THB');
$pt->checkout_currency = array('USD','EUR','AED','AFN','ALL','ARS','AUD','AZN','BBD','BDT','BGN','BMD','BND','BOB','BRL','BSD','BWP','BYN','BZD','CAD','CHF','CLP','CNY','COP','CRC','CZK','DKK','DOP','DZD','EGP','FJD','GBP','GTQ','HKD','HNL','HRK','HUF','IDR','ILS','INR','JMD','JOD','JPY','KES','KRW','KWD','KZT','LAK','LBP','LKR','LRD','MAD','MDL','MMK','MOP','MRO','MUR','MVR','MXN','MYR','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','SAR','SBD','SCR','SEK','SGD','SYP','THB','TND','TOP','TRY','TTD','TWD','UAH','UYU','VND','VUV','WST','XCD','XOF','YER','ZAR');
$pt->stripe_currency = array('USD','EUR','AUD','BRL','CAD','CZK','DKK','HKD','HUF','ILS','JPY','MYR','MXN','TWD','NZD','NOK','PHP','PLN','RUB','SGD','SEK','CHF','THB','GBP');

require 'assets/includes/paypal_config.php';
require 'assets/import/ftp/vendor/autoload.php';
require 'context_data.php';
require_once('assets/includes/onesignal_config.php');