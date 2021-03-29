<?php 

$page = 'dashboard';
if (!empty($_GET['page'])) {
    $page = PT_Secure($_GET['page']);
}


$page_loaded = '';
$pages = array(
    'dashboard', 
    'general-settings', 
    'site-settings', 
    'email-settings', 
    'social-login',
    's3',
    'prosys-settings',
    'manage-payments',
    'payment-requests', 
    'manage-users', 
    'manage-videos', 
    'import-from-youtube', 
    'import-from-dailymotion',
    'import-from-twitch', 
    'manage-video-ads', 
    'create-video-ad', 
    'edit-video-ad', 
    'manage-website-ads', 
    'manage-user-ads',
    'manage-themes', 
    'change-site-desgin', 
    'create-new-sitemap', 
    'manage-pages', 
    'changelog',
    'backup',
    'create-article',
    'edit-article',
    'manage-articles',
    'manage-profile-fields',
    'add-new-profile-field',
    'edit-profile-field',
    'payment-settings',
    'verification-requests',
    'manage-announcements',
    'ban-users',
    'custom-design',
    'api-settings',
    'manage-video-reports',
    'manage-languages',
    'add-language',
    'edit-lang',
    'manage_categories',
    'manage_sub_categories',
    'push-notifications-system',
    'sold_videos_analytics',
    'manage-movies',
    'manage-movies-category',
    'manage-comments',
    'manage-custom-pages',
    'add-new-custom-page',
    'edit-custom-page',
    'manage-currencies',
    'bank-receipts',
    'earnings'
);

if (in_array($page, $pages)) {
    $page_loaded = PT_LoadAdminPage("$page/content");
} 

if (empty($page_loaded)) {
    header("Location: " . PT_Link('admincp'));
    exit();
}

if ($page == 'dashboard') {
    if ($pt->config->last_admin_collection < (time() - 1800)) {
        $update_information = PT_UpdateAdminDetails();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin Panel | <?php echo $pt->config->title; ?></title>
    <link rel="icon" href="<?php echo $pt->config->theme_url ?>/img/icon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery/jquery.min.js'); ?>"></script>
    <link href="<?php echo PT_LoadAdminLink('plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo PT_LoadAdminLink('plugins/node-waves/waves.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/animate-css/animate.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/morrisjs/morris.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo PT_LoadAdminLink('plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css'); ?>" rel="stylesheet">
    <link href="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo PT_LoadAdminLink('css/themes/all-themes.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/bootstrap-select/css/bootstrap-select.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
    <link href="<?php echo PT_LoadAdminLink('plugins/m-popup/magnific-popup.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo $pt->config->theme_url; ?>/js/jquery.form.min.js"></script>
    <link href="<?php echo $pt->config->theme_url; ?>/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <?php if ($page == 'sold_videos_analytics' || $page == 'earnings') { ?>
        <script src="<?php echo $pt->config->theme_url; ?>/js/highcharts/highcharts.js"></script>
        <script src="<?php echo $pt->config->theme_url; ?>/js/highcharts/exporting.js"></script>
        <link href="<?php echo $pt->config->theme_url; ?>/js/lib/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo $pt->config->theme_url; ?>/js/lib/jquery-datatable/jquery.dataTables.js"></script>
        <script src="<?php echo $pt->config->theme_url; ?>/js/lib/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <?php } ?>

</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo PT_Link(''); ?>"><?php echo $pt->config->title ?></a>
            </div>
            <div class="navbar-header pull-right">
                <div class="form-group form-float pt_admin_hdr_srch">
                    <div class="form-line">
                        <input type="text" id="search_for" name="search_for" class="form-control" onkeyup="searchInFiles($(this).val())" placeholder="Search Settings">
                    </div>
                    <div class="pt_admin_hdr_srch_reslts" id="search_for_bar"></div>
                </div>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo $user->avatar; ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name"><a href="<?php echo $user->url; ?>" target="_blank"><?php echo $user->name; ?></a></div>
                    <div class="email"><?php echo $user->email; ?></div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li <?php echo ($page == 'dashboard') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo PT_LoadAdminLinkSettings(''); ?>">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li <?php echo ($page == 'general-settings' || $page == 'site-settings' || $page == 'payment-settings' || $page == 'email-settings' || $page == 'social-login' || $page == 's3' || $page == 'manage-currencies') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'general-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('general-settings'); ?>">General Settings</a>
                            </li>
                            <li <?php echo ($page == 'site-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('site-settings'); ?>">Site Settings</a>
                            </li>
                            <li <?php echo ($page == 'email-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('email-settings'); ?>">E-mail Settings</a>
                            </li>
                            <li <?php echo ($page == 'social-login') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('social-login'); ?>">Social Login Settings</a>
                            </li>
                            <li <?php echo ($page == 's3') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('s3'); ?>">Amazon S3 & FTP Settings</a>
                            </li>

                            <li <?php echo ($page == 'payment-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('payment-settings'); ?>">Payment Settings</a>
                            </li> 
                            <li <?php echo ($page == 'manage-currencies') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-currencies'); ?>">Manage Currencies</a>
                            </li>   
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-languages' || $page == 'add-language' || $page == 'edit-lang') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">language</i>
                            <span>Languages</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'add-language') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('add-language'); ?>">Add New Language & Keys</a>
                            </li>
                            <li <?php echo ($page == 'manage-languages') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-languages'); ?>">Manage Languages</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-users'  || $page == 'add-new-profile-field' || $page == 'edit-profile-field' || $page == 'verification-requests') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_circle</i>
                            <span>Users</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-users') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-users'); ?>">Manage Users</a>
                            </li>
                            <li <?php echo ($page == 'manage-profile-fields') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-profile-fields'); ?>">Manage Custom Profile Fields</a>
                            </li>
                            <li <?php echo ($page == 'verification-requests') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('verification-requests'); ?>">Manage Verification Requests</a>
                            </li>
                        </ul>
                        
                    </li>

                    <li <?php echo ($page == 'manage-videos' || $page == 'import-from-youtube' || $page == 'import-from-dailymotion' || $page == 'sold_videos_analytics' || $page == 'import-from-twitch') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">video_library</i>
                            <span>Videos</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-videos') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-videos'); ?>">Manage Videos</a>
                            </li>
                            <!-- <li <?php echo ($page == 'sold_videos_analytics') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('sold_videos_analytics'); ?>">Sold Videos Analytics</a>
                            </li> -->
                            <li <?php echo ($page == 'import-from-youtube' || $page == 'import-from-dailymotion' || $page == 'import-from-twitch') ? 'class="active"' : ''; ?>>
                                <a href="javascript:void(0);" class="menu-toggle">Import Videos</a>
                                <ul class="ml-menu">
                                    <li <?php echo ($page == 'import-from-youtube') ? 'class="active"' : ''; ?>>
                                        <a href="<?php echo PT_LoadAdminLinkSettings('import-from-youtube'); ?>">Import From YouTube</a>
                                    </li>
                                    <li <?php echo ($page == 'import-from-dailymotion') ? 'class="active"' : ''; ?>>
                                        <a href="<?php echo PT_LoadAdminLinkSettings('import-from-dailymotion'); ?>">Import From Dailymotion</a>
                                    </li>
                                    <li <?php echo ($page == 'import-from-twitch') ? 'class="active"' : ''; ?>>
                                        <a href="<?php echo PT_LoadAdminLinkSettings('import-from-twitch'); ?>">Import From Twitch</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li <?php echo ($page == 'sell_videos') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('sell_videos'); ?>">Paid Videos</a>
                            </li> -->
                        </ul>
                    </li>
                    
                    <li <?php echo ($page == 'manage-movies' || $page == 'manage-movies-category') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">video_library</i>
                            <span>Movies</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-movies-category') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-movies-category'); ?>">Manage movies category</a>
                            </li>
                            <li <?php echo ($page == 'manage-movies') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-movies'); ?>">Manage movies</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-articles' || $page == 'create-article' || $page == 'edit-article') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">library_books</i>
                            <span>Articles</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'create-article') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('create-article'); ?>">Add New Article</a>
                            </li>
                            <li <?php echo ($page == 'manage-articles') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-articles'); ?>">Manage Articles</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage_categories' || $page == 'manage_sub_categories') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">more_vert</i>
                            <span>Categories</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage_categories') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage_categories'); ?>">Manage Categories</a>
                            </li>
                            <li <?php echo ($page == 'manage_sub_categories') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage_sub_categories'); ?>">Manage Sub Categories</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'earnings') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo PT_LoadAdminLinkSettings('earnings'); ?>">
                            <i class="material-icons">credit_card</i>
                            <span>Earnings</span>
                        </a>
                    </li>
                    <li <?php echo ($page == 'manage-comments') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo PT_LoadAdminLinkSettings('manage-comments'); ?>">
                            <i class="material-icons">comment</i>
                            <span>Manage Comments</span>
                        </a>
                    </li>
                    <li <?php echo ($page == 'bank-receipts') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo PT_LoadAdminLinkSettings('bank-receipts'); ?>">
                            <i class="material-icons">credit_card</i>
                            <span>Manage Bank Receipts</span>
                        </a>
                    </li>
                    <li <?php echo ($page == 'manage-video-ads' || $page == 'create-video-ad' || $page == 'edit-video-ad' || $page == 'payment-requests' || $page == 'manage-website-ads' || $page == 'manage-user-ads') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">attach_money</i>
                            <span>Advertisement</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-video-ads') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-video-ads'); ?>">Manage Video Ads</a>
                            </li>
                            <li <?php echo ($page == 'manage-website-ads') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-website-ads'); ?>">Manage Website Ads</a>
                            </li>
                            <li <?php echo ($page == 'manage-user-ads') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-user-ads'); ?>">Manage User Ads</a>
                            </li>
                            <li <?php echo ($page == 'payment-requests') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('payment-requests'); ?>">Payment Requests</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'prosys-settings' || $page == 'manage-payments') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">star</i>
                            <span>Pro System</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'prosys-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('prosys-settings'); ?>">Pro System Settings</a>
                            </li>
                            <li <?php echo ($page == 'manage-payments') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-payments'); ?>">Recent Payments</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-themes' || $page == 'change-site-desgin' || $page == 'custom-design') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">color_lens</i>
                            <span>Design</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-themes') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-themes'); ?>">Themes</a>
                            </li>
                            <li <?php echo ($page == 'change-site-desgin') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('change-site-desgin'); ?>">Change Site Design</a>
                            </li>
                            <li <?php echo ($page == 'custom-design') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('custom-design'); ?>">Custom Design</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-announcements' || $page == 'ban-users') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">build</i>
                            <span>Tools</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-announcements') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-announcements'); ?>">Manage Announcements</a>
                            </li>
                            <li <?php echo ($page == 'ban-users') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('ban-users'); ?>">Ban Users</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-video-reports') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">flag</i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-video-reports') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-video-reports'); ?>">
                                    Manage video reports
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'manage-pages' || $page == 'add-new-custom-page' || $page == 'manage-custom-pages' || $page == 'edit-custom-page') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">description</i>
                            <span>Pages</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'manage-custom-pages' || $page == 'add-new-custom-page' || $page == 'edit-custom-page') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-custom-pages'); ?>">Manage Custom Pages</a>
                            </li>
                            <li <?php echo ($page == 'manage-pages') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('manage-pages'); ?>">Manage Pages</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'create-new-sitemap') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">power_input</i>
                            <span>Sitemap</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'create-new-sitemap') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('create-new-sitemap'); ?>">Create Sitemap</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'api-settings' || $page == 'push-notifications-system') ? 'class="active"' : ''; ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">compare_arrows</i>
                            <span>Mobile & API Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php echo ($page == 'api-settings') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('api-settings'); ?>">Manage API Access Keys</a>
                            </li>
                            <li <?php echo ($page == 'push-notifications-system') ? 'class="active"' : ''; ?>>
                                <a href="<?php echo PT_LoadAdminLinkSettings('push-notifications-system'); ?>">Push Notifications System</a>
                            </li>
                        </ul>
                    </li>
                    <li <?php echo ($page == 'backup') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo PT_LoadAdminLinkSettings('backup'); ?>">
                            <i class="material-icons">backup</i>
                            <span>Backup</span>
                        </a>
                    </li>
                    <li <?php echo ($page == 'changelog') ? 'class="active"' : ''; ?>>
                        <a href="<?php echo PT_LoadAdminLinkSettings('changelog'); ?>">
                            <i class="material-icons">update</i>
                            <span>Changelogs</span>
                        </a>
                    </li>
                     <li >
                        <a href="http://docs.playtubescript.com" target="_blank">
                            <i class="material-icons">more_vert</i>
                            <span>FAQs & Docs</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    Copyright &copy; <?php  echo date('Y') ?> <a href="javascript:void(0);"><?php echo $pt->config->name; ?></a>.
                </div>
                <div class="version">
                    <b>Version: </b> <?php echo $pt->config->script_version ?>
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <?php echo $page_loaded; ?>
    </section>
    
    <!-- Bootstrap Core Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/bootstrap/js/bootstrap.js'); ?>"></script>

    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/buttons.flash.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/jszip.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/pdfmake.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/vfs_fonts.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/buttons.html5.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-datatable/extensions/export/buttons.print.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('js/pages/tables/jquery-datatable.js'); ?>"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/bootstrap-select/js/bootstrap-select.js'); ?>"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>

    <!-- ColorPicker Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/node-waves/waves.js'); ?>"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-countto/jquery.countTo.js'); ?>"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/raphael/raphael.min.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/morrisjs/morris.js'); ?>"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo PT_LoadAdminLink('plugins/jquery-sparkline/jquery.sparkline.js'); ?>"></script>
    <!-- TinyMce Text Editor  -->
    <script src="<?php echo PT_LoadAdminLink('plugins/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
    <!-- Bootstrap tagsinput Plugin Js  -->
    <script src="<?php echo PT_LoadAdminLink('plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.js'); ?>"></script>

    <!-- Jquery Alert Plugin Js-->
    <script src="<?php echo PT_LoadAdminLink('plugins/sweetalert/sweetalert.min.js'); ?>"></script>

     <!-- Jquery Magnific Pop-up Plugin Js-->
    <script src="<?php echo PT_LoadAdminLink('plugins/m-popup/jquery.magnific-popup.min.js'); ?>"></script>


    <script src="<?php echo PT_LoadAdminLink('plugins/codemirror-5.30.0/lib/codemirror.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/codemirror-5.30.0/mode/css/css.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('plugins/codemirror-5.30.0/mode/javascript/javascript.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo PT_LoadAdminLink('plugins/codemirror-5.30.0/lib/codemirror.css'); ?>">
    <!-- Custom Js -->
    <script src="<?php echo PT_LoadAdminLink('js/admin.js'); ?>"></script>
    <script src="<?php echo PT_LoadAdminLink('js/pages/index.js'); ?>"></script>
</body>

</html>
<style> 
.sidebar .user-info {
    background: #0095d8;
}
[type="checkbox"]:checked + label:before {
    border-right: 2px solid #333;
}
</style>
<script>
<?php echo PT_LoadAdminPage('js/main'); ?>

function searchInFiles(keyword) {
    if (keyword.length > 2) {
        $.post('<?php echo $pt->config->site_url; ?>/aj/ap/search_in_pages', {keyword: keyword}, function(data, textStatus, xhr) {
            if (data.html != '') {
                $('#search_for_bar').html(data.html)
            }
            else{
                $('#search_for_bar').html('')
            }
        });
    }
    else{
        $('#search_for_bar').html('')
    }
}
$(window).load(function() {
    jQuery.fn.highlight = function (str, className) {
        if (str != '') {
            var aTags = document.getElementsByTagName("h2");
            var bTags = document.getElementsByTagName("label");
            var searchText = str.toLowerCase();

            if (aTags.length > 0) {
                for (var i = 0; i < aTags.length; i++) {
                    var tag_text = aTags[i].textContent.toLowerCase();
                    if (tag_text.indexOf(searchText) != -1) {
                        $(aTags[i]).addClass(className)
                    }
                }
            }

            if (bTags.length > 0) {
                for (var i = 0; i < bTags.length; i++) {
                    var tag_text = bTags[i].textContent.toLowerCase();
                    if (tag_text.indexOf(searchText) != -1) {
                        $(bTags[i]).addClass(className)
                    }
                }
            }
        }
    };
    jQuery.fn.highlight("<?php echo (!empty($_GET['highlight']) ? $_GET['highlight'] : '') ?>",'highlight_text');
});
</script>
