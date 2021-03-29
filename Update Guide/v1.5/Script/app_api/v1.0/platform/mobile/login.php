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

if (empty($_POST['username']) || empty($_POST['password'])) {
    $response_data       = array(
        'api_status'     => '400',
        'api_version'    => $api_version,
        'errors'         => array(
            'error_id'   => '1',
            'error_text' => 'Please enter your username and password'
        )
    );
}

else {
    $username        = PT_Secure($_POST['username']);
    $password        = PT_Secure($_POST['password']);
    $password_hashed = sha1($password);

    $db->where("(username = ? or email = ?)", array($username,$username));
    $db->where("password", $password_hashed);
    $user = $db->getOne(T_USERS);

    if (!empty($user)) {
        if ($user->active == 0) {
            $response_data       = array(
                'api_status'     => '304',
                'api_version'    => $api_version,
                'success_type'   => 'confirm_account',
                'errors'         => array(
                    'error_id'   => '2',
                    'error_text' => 'Your account is not active yet, please confirm your E-mail',
                    'email'      => $user->email
                ) 
            );
        } 
        
        else {
            if (!empty($_POST['device_id'])) {
                $db->where('id',$user->id)->update(T_USERS,array('device_id' => PT_Secure($_POST['device_id'])));
            }
            $session_id          = sha1(rand(11111, 99999)) . time() . md5(microtime());
            $platforms           = array('phone','web');
            foreach ($platforms as $platform_name) {
                $insert_data     = array(
                    'user_id'    => $user->id,
                    'session_id' => $session_id,
                    'time'       => time(),
                    'platform'   => $platform_name
                );

                $insert = $db->insert(T_SESSIONS, $insert_data);
            }

            $response_data       = array(
                'api_status'     => '200',
                'api_version'    => $api_version,
                'data'           => array(
                    'session_id' => $session_id,
                    'message'    => 'Successfully logged in, Please wait.',
                    'user_id'    => $user->id,
                    'cookie'     => $session_id
                ) 
            );
        }
    } 
    else {
        $response_data           = array(
            'api_status'         => '400',
            'api_version'        => $api_version,
            'errors'             => array(
                'error_id'       => '3',
                'error_text'     => 'Invalid username or password'
            ) 
        );
    }
}