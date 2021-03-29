<?php
if (!version_compare(PHP_VERSION, '5.4.0', '>=')) {
    exit("Required PHP_VERSION >= 5.4.0 , Your PHP_VERSION is : " . PHP_VERSION . "\n");
}
// +------------------------------------------------------------------------+
// | @author Deen Doughouz (DoughouzForest)
// | @author_url 1: http://www.playtubescript.com
// | @author_url 2: http://codecanyon.net/user/doughouzforest
// | @author_email: wowondersocial@gmail.com   
// +------------------------------------------------------------------------+
// | PlayTube - The Ultimate Video Sharing Platform
// | Copyright (c) 2017 PlayTube. All rights reserved.
// +------------------------------------------------------------------------+
date_default_timezone_set('UTC');
session_start();
require('assets/includes/functions_general.php');
require('assets/includes/tables.php');
require('assets/includes/functions_one.php');