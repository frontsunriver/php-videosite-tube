<?php
if (IS_LOGGED == false) {
    header("Location: " . PT_Link('login'));
    exit();
}
$user_id               = $user->id;
$pt->is_admin          = PT_IsAdmin();
$pt->is_settings_admin = false;

if (isset($_GET['user']) && !empty($_GET['user']) && ($pt->is_admin === true)) {
    if (empty($db->where('username', PT_Secure($_GET['user']))->getValue(T_USERS, 'count(*)'))) {
        header("Location: " . PT_Link(''));
        exit();
    }
    $user_id               = $db->where('username', PT_Secure($_GET['user']))->getValue(T_USERS, 'id');
    $pt->is_settings_admin = true;
}

$pt->settings     = PT_UserData($user_id);
$pt->setting_page = 'general';
$pages_array      = array(
    'general',
    'profile',
    'password',
    'privacy',
    'change',
    'social',
    'avatar',
    'email',
    'delete',
    'monetization',
    'withdrawals',
    'verification',
    'balance',
    'two_factor'
);

if ($pt->settings->id == $user->id) {
    $pages_array = array(
        'general',
        'profile',
        'password',
        'privacy',
        'change',
        'social',
        'avatar',
        'email',
        'delete',
        'monetization',
        'withdrawals',
        'verification',
        'balance',
        'two_factor'
    );
}
$pt->page_url_ = $pt->config->site_url.'/settings';
if (!empty($_GET['page']) && $_GET['page'] == 'two_factor' && $pt->config->two_factor_setting != 'on') {
    header("Location: " . PT_Link(''));
    exit();
}
if (!empty($_GET['page'])) {
    if (in_array($_GET['page'], $pages_array)) {
        if ($_GET['page'] != 'balance') {
            $pt->setting_page = $_GET['page'];
            $pt->page_url_ = $pt->config->site_url.'/settings/'.$pt->setting_page;
        }
        else{
            if (($pt->config->usr_v_mon == 'off' && $pt->config->sell_videos_system == 'off')) {
                $pt->setting_page = 'general';
                $pt->page_url_ = $pt->config->site_url.'/settings/'.$pt->setting_page;
            }
            else{
                $pt->setting_page = $_GET['page'];
                $pt->page_url_ = $pt->config->site_url.'/settings/'.$pt->setting_page;
            }
        }
    }
}

$pt->user_setting = '';
if (!empty($_GET['user'])) {
    $pt->user_setting = 'user=' . $_GET['user'] . '&';
    $pt->page_url_ = $pt->config->site_url.'/settings/'.$pt->setting_page.'/'.$_GET['user'];
}
$countries = '';
foreach ($countries_name as $key => $value) {
    $selected = ($key == $pt->settings->country_id) ? 'selected' : '';
    $countries .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
}



// Get user custom Fields
if ($pt->setting_page == 'general') {
    $db->where('placement','general');
} 

else if ($pt->setting_page == 'profile') {
    $db->where('placement',array('profile','social'),'IN');
}

$pt->profile_fields = null;
$pt->profile_fields = $db->where('active','1')->get(T_FIELDS);
$pt->user->fields   = $db->where('user_id',$user_id)->getOne(T_USR_PROF_FIELDS);
$pt->user->fields   = (is_object($pt->user->fields)) ? get_object_vars($pt->user->fields) : array();
$custom_fields      = "";


foreach ($pt->profile_fields as $field_data) {
    $field_data->fid  = 'fid_' . $field_data->id;
    $field_data->name = preg_replace_callback("/{{LANG (.*?)}}/", function($m) use ($pt) {
        return (isset($pt->lang->$m[1])) ? $pt->lang->$m[1] : '';
    }, $field_data->name);

    $field_data->description = preg_replace_callback("/{{LANG (.*?)}}/", function($m) use ($pt) {
        return (isset($pt->lang->$m[1])) ? $pt->lang->$m[1] : '';
    }, $field_data->description);

    if ($field_data->type == 'select') {
        $fid       = '';
        $pt->field = $field_data;
        if (!empty($pt->user->fields[$field_data->fid])) {
            $fid   = $pt->user->fields[$field_data->fid];
        } 

        $pt->fid   = $fid;
        $custom_fields .= PT_LoadPage('settings/custom-options',array(
            "FID"  => $fid,
            "NAME" => $field_data->name,
            "DESC" => $field_data->description,
        ));
    }

    else if ($field_data->type == 'textbox' || $field_data->type == 'textarea') {
        $fid       = '';
        $pt->field = $field_data;
        if (!empty($pt->user->fields[$field_data->fid])) {
            $fid   = $pt->user->fields[$field_data->fid];
        } 

        $pt->fid   = $fid;
        $custom_fields .= PT_LoadPage('settings/custom-inputs',array(
            "ID"   =>  $field_data->id,
            "FID"  => $fid,
            "NAME" => $field_data->name,
            "DESC" => $field_data->description,
        ));
    }


}

$withdrawal_history = "";
if ($pt->setting_page == 'withdrawals') {
    $user_withdrawals  = $db->where('user_id',$pt->user->id)->get(T_WITHDRAWAL_REQUESTS);  
    foreach ($user_withdrawals as $withdrawal) {
        $pt->withdrawal_stat = $withdrawal->status;
        $withdrawal_history .= PT_LoadPage("settings/includes/withdrawals-list",array(
            'W_ID' => $withdrawal->id,
            'W_REQUESTED' => date('Y-F-d',$withdrawal->requested),
            'W_AMOUNT' => number_format($withdrawal->amount, 2),
            'W_CURRENCY' => $withdrawal->currency,
        ));
    }
}


$pt->page        = 'settings';
$pt->title       = $lang->settings . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword     = $pt->config->keyword;
$pt->content     = PT_LoadPage("settings/content", array(
    'SETTINGSPAGE' => PT_LoadPage("settings/$pt->setting_page", array(
        'USER_DATA' => $pt->settings,
        'COUNTRIES_LAYOUT' => $countries,
        'CUSTOM_FIELDS' => $custom_fields,
        'WITHDRAWAL_HISTORY_LIST' => $withdrawal_history,
        'CUSTOM_DATA' => ((!empty($custom_fields)) ? "1" : "0"),
        'ADMIN_LAYOUT' => PT_LoadPage('settings/admin', array(
            'USER_DATA' => $pt->settings
        ))
    ))
));
