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
error_reporting(0);
require_once( "./assets/import/hybridauth/hybridauth/Hybrid/Auth.php" );
require_once( "./assets/import/hybridauth/hybridauth/Hybrid/Endpoint.php" );

Hybrid_Endpoint::process();