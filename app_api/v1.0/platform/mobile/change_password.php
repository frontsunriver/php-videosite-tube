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
if (!IS_LOGGED) {
    $response_data = array(
        'api_status' => '400',
        'api_version' => $api_version,
        'errors' => array(
            'error_id' => '1',
            'error_text' => 'Not logged in'
        )
    );
} else if (empty($_POST['new_password']) || empty($_POST['confirm_new_password']) || empty($_POST['current_password'])) {
    $response_data = array(
        'api_status' => '400',
        'api_version' => $api_version,
        'errors' => array(
            'error_id' => '2',
            'error_text' => 'Bad Request, Invalid or missing parameter (new_password, confirm_new_password, current_password)'
        )
    );
} else {
    $user_data = PT_UserData($user->id);
    if (!empty($user_data->id)) {
        if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_new_password'])) {
            $errors =  $lang->please_check_details;
        } else {
            if ($user_data->password != sha1($_POST['current_password'])) {
                $errors = $lang->current_password_dont_match;
            }
            if (strlen($_POST['new_password']) < 4) {
                $errors = $lang->password_is_short;
            }
            if ($_POST['new_password'] != $_POST['confirm_new_password']) {
                $errors = $lang->new_password_dont_match;
            }
            if (empty($errors)) {
                $update_data = array(
                    'password' => sha1($_POST['new_password'])
                );
                $update = $db->where('id', PT_Secure($user_data->id))->update(T_USERS, $update_data);
                if ($update) {
                    $response_data = array(
                        'api_status' => '200',
                        'api_version' => $api_version,
                        'message' => $lang->setting_updated
                    );
                }
            } else {
                $response_data = array(
                    'api_status' => '400',
                    'api_version' => $api_version,
                    'errors' => array(
                        'error_id' => '2',
                        'error_text' => $errors
                    )
                );
            }
        }
    }
}