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

$page = 'home';
if (isset($_GET['link1'])) {
    $page = $_GET['link1'];
}

if ($pt->config->pop_up_18 == 'on' && (((!empty($_COOKIE['pop_up_18']) && $_COOKIE['pop_up_18'] == 'no') || empty($_COOKIE['pop_up_18']))  && $page != 'age_block' && !IS_LOGGED)) {
    header('Location: ' .PT_Link($page));
    exit();
}

if (IS_LOGGED == true) {
    if ($user->last_active < (time() - 60)) {
        $update = $db->where('id', $user->id)->update('users', array(
            'last_active' => time()
        ));
    }
} 

if (file_exists("./sources/$page/content.php")) {
    include("./sources/$page/content.php");
}

if (empty($pt->content)) {
    include("./sources/404/content.php");
}


$data['title'] = $pt->title;
$data['description'] = $pt->description;
$data['keyword'] = $pt->keyword;
$data['page'] = $pt->page;
$data['url'] = $pt->page_url_;
$data['is_movie'] = false;
if ((!empty($pt->get_video) && $pt->get_video->is_movie) || $pt->page == 'movies') {
	$data['is_movie'] = true;
}

?>
<input type="hidden" id="json-data" value='<?php echo htmlspecialchars(json_encode($data));?>'>
<?php
echo $pt->content;
$db->disconnect();
unset($pt);
?>