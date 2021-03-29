<?php
if (empty($_GET['page'])) {
    header("Location: " . PT_Link('404'));
    exit();
}
$page         = PT_Secure($_GET['page']);
$limit        = 20;
$pt->rss_feed = false;
$pt->exp_feed = true;
$pages        = array(
    'trending',
    'category',
    'latest',
    'top'
);

if (!in_array($page, $pages)) {
    header("Location: " . PT_Link('404'));
    exit();
}
// pagination system 
$pt->page_number = isset($_GET['page_id']) && is_numeric($_GET['page_id']) && $_GET['page_id'] > 0 ? $_GET['page_id'] : 1;
$pt->limit_per_page = !empty($pt->config->videos_load_limit) && is_numeric($pt->config->videos_load_limit) && $pt->config->videos_load_limit > 0 ? (int) $pt->config->videos_load_limit : 20;
$db->pageLimit = $pt->limit_per_page;
// pagination system 

if (!empty($_GET['feed']) && $_GET['feed'] == 'rss') {
    $limit        = 50;
    $pt->rss_feed = true;

}
$pt->page_url_ = $pt->config->site_url.'/videos/'.$page.'?page_id='.$pt->page_number;
$cateogry_id = '';
$videos = array();
if ($page == 'trending') {
    $title  = $lang->trending;
    // $db->where('privacy', 0);
    // $videos = $db->where('time', time() - 172800, '>')->orderBy('views', 'DESC')->get(T_VIDEOS, $limit);

    // pagination system 
    $videos = $db->where('privacy', 0)->where('user_id',$pt->blocked_array , 'NOT IN')->where('time', time() - 172800, '>')->where('is_movie',0)->orderBy('views', 'DESC')->objectbuilder()->paginate(T_VIDEOS, $pt->page_number);
    $pt->total_pages = $db->totalPages;
    // pagination system 
} 

else if ($page == 'latest') {
    $title  = $lang->latest_videos;
    // $db->where('privacy', 0);
    // $videos = $db->orderBy('id', 'DESC')->get(T_VIDEOS, $limit);

    // pagination system 
    $videos = $db->where('privacy', 0)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_movie',0)->orderBy('id', 'DESC')->objectbuilder()->paginate(T_VIDEOS, $pt->page_number);
    $pt->total_pages = $db->totalPages;
    // pagination system 
} 

else if ($page == 'top') {
    $title  = $lang->top_videos;

    $types = array('all_time','today','this_week','this_month','this_year');

    $pt->cat_type = 'all_time';
    if (!empty($_GET['type']) && in_array($_GET['type'], $types)) {
        $pt->cat_type = $_GET['type'];
    }

    if ($pt->cat_type == 'today') {
        $start = strtotime(date('M')." ".date('d').", ".date('Y')." 12:00am");
        $end = strtotime(date('M')." ".date('d').", ".date('Y')." 11:59pm");
    }
    elseif ($pt->cat_type == 'this_week') {
        $time = strtotime(date('l').", ".date('M')." ".date('d').", ".date('Y'));

        if (date('l') == 'Saturday') {
            $start = strtotime(date('M')." ".date('d').", ".date('Y')." 12:00am");
        }
        else{
            $start = strtotime('last saturday, 12:00am', $time);
        }

        if (date('l') == 'Friday') {
            $end = strtotime(date('M')." ".date('d').", ".date('Y')." 11:59pm");
        }
        else{
            $end = strtotime('next Friday, 11:59pm', $time);
        }
    }
    elseif ($pt->cat_type == 'this_month') {
        $start = strtotime("1 ".date('M')." ".date('Y')." 12:00am");
        $end = strtotime(cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))." ".date('M')." ".date('Y')." 11:59pm");
    }
    elseif ($pt->cat_type == 'this_year') {
        $start = strtotime("1 January ".date('Y')." 12:00am");
        $end = strtotime("31 December ".date('Y')." 11:59pm");
    }

    $page_num = 0;
    if ($pt->page_number > 0) {
        $page_num = ($pt->page_number - 1) * $limit;
    }

    if ($pt->cat_type == 'all_time') {
        // pagination system 
        $videos = $db->where('privacy', 0)->where('user_id',$pt->blocked_array , 'NOT IN')->where('is_movie',0)->orderBy('views', 'DESC')->objectbuilder()->paginate(T_VIDEOS, $pt->page_number);
        $pt->total_pages = $db->totalPages;
        
        // pagination system 
    }
    else{
        $videos = $db->rawQuery('SELECT video_id, COUNT(*) AS count FROM '.T_VIEWS.' v WHERE `time` >= '.$start.' AND `time` <= '.$end.'  AND (SELECT id FROM '.T_VIDEOS.' WHERE id = v.video_id AND is_movie = 0 AND privacy = 0 AND user_id NOT IN ('.implode(",", $pt->blocked_array).')) = video_id GROUP BY video_id ORDER BY count DESC LIMIT '.$page_num.','.$limit);

        $rows = $db->rawQuery('SELECT COUNT(*) FROM '.T_VIEWS.' v WHERE `time` >= '.$start.' AND `time` <= '.$end.'  AND (SELECT id FROM '.T_VIDEOS.' WHERE id = v.video_id AND is_movie = 0 AND privacy = 0 AND user_id NOT IN ('.implode(",", $pt->blocked_array).')) = video_id GROUP BY video_id');

        $new = new stdClass();
        foreach ($videos as $key => $value) {
            $new->{$key} = $db->where('id',$value->video_id)->getOne(T_VIDEOS);
        }
        $videos = $new;
        $pt->total_pages = ceil(count($rows) / $limit);

        $pt->page_url_ = $pt->config->site_url.'/videos/'.$page.'?page_id='.$pt->page_number.'&type='.$pt->cat_type;

    }


    // $db->where('privacy', 0);
    // $videos = $db->orderBy('views', 'DESC')->get(T_VIDEOS, $limit);
    
    
    // print_r('SELECT video_id, COUNT(*) AS count FROM '.T_VIEWS.' v WHERE `time` >= '.$this_year_start.' AND `time` <= '.$this_year_end.'  AND (SELECT id FROM '.T_VIDEOS.' WHERE id = v.video_id AND is_movie = 0 AND privacy = 0) = video_id GROUP BY video_id ORDER BY count DESC LIMIT '.$pt->page_number.','.$limit);
    // exit();
    
    // print_r($videos);
    // exit();
    
    // print_r($videos);
    // exit();

    
} 

else if ($page == 'category') {
    if (!empty($_GET['id'])) {
        if (in_array($_GET['id'], array_keys($categories))) {
            $pt->page_url_ = $pt->config->site_url.'/videos/'.$page.'/'.$_GET['id'].'?page_id='.$pt->page_number;
            $cateogry = PT_Secure($_GET['id']);
            $title    = $categories[$cateogry];
            $cateogry_id = "data-category='$cateogry'";
            if (!empty($_GET['sub_id'])) {
                 $is_found = $db->where('type',PT_Secure($_GET['id']))->where('lang_key',PT_Secure($_GET['sub_id']))->getValue(T_LANGS,'COUNT(*)');
                if ($is_found > 0) {
                    $pt->page_url_ = $pt->config->site_url.'/videos/'.$page.'/'.$_GET['id'].'/'.$_GET['sub_id'].'?page_id='.$pt->page_number;
                    $db->where('sub_category', PT_Secure($_GET['sub_id']));
                }
            }
            //$db->where('privacy', 0);
            //$category_old = str_replace('category__', '', $cateogry);
            // $videos   = $db->where('category_id = "' . $cateogry . '" OR category_id = "' . $category_old . '"')->orderBy('id', 'DESC')->get(T_VIDEOS, $limit);

            // pagination system 
            $videos = $db->where('privacy', 0)->where('user_id',$pt->blocked_array , 'NOT IN')->where('category_id = "' . $cateogry.'"')->where('is_movie',0)->orderBy('id', 'DESC')->objectbuilder()->paginate(T_VIDEOS, $pt->page_number);
            $pt->total_pages = $db->totalPages;
            // pagination system 
            
        } else {
            header("Location: " . PT_Link('404'));
            exit();
        }
    }
}

use Bhaktaraz\RSSGenerator\Item;
use Bhaktaraz\RSSGenerator\Feed;
use Bhaktaraz\RSSGenerator\Channel;


//Export rss feed
if ($pt->rss_feed) {   
    $rss_feed_xml   = "";
    $fl_rss_feed    = new Feed();
    $fl_rss_channel = new Channel();


    $fl_rss_channel
        ->title($pt->config->title)
        ->description($pt->config->description)
        ->url($pt->config->site_url)
        ->appendTo($fl_rss_feed);

    if (is_array($videos)) {
        foreach ($videos as $feed_item_data) {
            $feed_item_data = PT_GetVideoByID($feed_item_data, 0, 0, 0);
            $thumbnail = $feed_item_data->org_thumbnail;
            if (strpos($feed_item_data->thumbnail, 'upload/photos') !== false) {
                $thumbnail = PT_GetMedia($feed_item_data->org_thumbnail);
            }
            $fl_rss_item    = new Item();
            $fl_rss_item
             ->title($feed_item_data->title)
             ->description($feed_item_data->markup_description)
             ->url($feed_item_data->url)
             ->pubDate($feed_item_data->time)
             ->guid($feed_item_data->url,true)
             ->media(array(
                'attr'  => 'url',
                'ns'    => 'thumbnail',
                'link'  => $thumbnail))
             ->appendTo($fl_rss_channel);
        }
    }

    header('Content-type: text/rss+xml');
    echo($fl_rss_feed);
    exit();
}



$pt->show_sub = false;
$pt->sub_categories_array = array();
foreach ($pt->sub_categories as $cat_key => $subs) {
    $pt->sub_categories_array["'".$cat_key."'"] = '<option value="">'.$lang->all.'</option>';
    foreach ($subs as $sub_key => $sub_value) {
        $pt->sub_categories_array["'".$cat_key."'"] .= '<option value="'.array_keys($sub_value)[0].'" '.((!empty($_GET['sub_id']) && $_GET['sub_id'] == array_keys($sub_value)[0]) ? "selected" : "") .'>'.$sub_value[array_keys($sub_value)[0]].'</option>';
    }
    if (!empty($_GET['id']) && $_GET['id'] == $cat_key) {
        $pt->show_sub = true;
    }
}


$html_videos = '';
if (!empty($videos)) {
    foreach ($videos as $key => $video) {
    	$video = PT_GetVideoByID($video, 0, 0, 0);
        $html_videos .= PT_LoadPage('videos/list', array(
            'ID' => $video->id,
            'VID_ID' => $video->id,
	        'TITLE' => $video->title,
	        'VIEWS' => $video->views,
            'VIEWS_NUM' => number_format($video->views),
	        'USER_DATA' => $video->owner,
	        'THUMBNAIL' => $video->thumbnail,
	        'URL' => $video->url,
	        'TIME' => $video->time_ago,
            'DURATION' => $video->duration,
            'VIDEO_ID_' => PT_Slug($video->title, $video->video_id),
            'GIF' => $video->gif
        ));
    }
}
if (empty($videos) || empty(ToArray($videos))) {
	$html_videos = '<div class="text-center no-content-found empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video-off"><path d="M16 16v1a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2m5.66 0H14a2 2 0 0 1 2 2v3.34l1 1L23 7v10"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>' . $lang->no_videos_found_for_now . '</div>';
}
$pt->videos_count= count(ToArray($videos));
$pt->page        = $page;
$pt->title       = $title . ' | ' . $pt->config->title;
$pt->description = $pt->config->description;
$pt->keyword     = @$pt->config->keyword;
$pt->content     = PT_LoadPage('videos/content', array(
    'TITLE' => $title,
    'VIDEOS' => $html_videos,
    'TYPE' => $page,
    'CATEGORY_ID' => $cateogry_id
));