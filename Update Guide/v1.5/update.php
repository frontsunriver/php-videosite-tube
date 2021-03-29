<?php
if (file_exists('./assets/init.php')) {
    require_once('./assets/init.php');
} else {
    die('Please put this file in the home directory !');
}

function PT_UpdateLangs($lang, $key, $value) {
    global $sqlConnect;
    $update_query         = "UPDATE langs SET `{lang}` = '{lang_text}' WHERE `lang_key` = '{lang_key}'";
    $update_replace_array = array(
        "{lang}",
        "{lang_text}",
        "{lang_key}"
    );
    return str_replace($update_replace_array, array(
        $lang,
        mysqli_real_escape_string($sqlConnect, $value),
        $key
    ), $update_query);
}


$updated = false;
if (!empty($_GET['updated'])) {
    $updated = true;
}
if (!empty($_POST['query'])) {
    $query = mysqli_query($mysqli, base64_decode($_POST['query']));
    if ($query) {
        $data['status'] = 200;
    } else {
        $data['status'] = 400;
        $data['error']  = mysqli_error($mysqli);
    }
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}
if (!empty($_POST['update_langs'])) {
    $data  = array();
    $query = mysqli_query($sqlConnect, "SHOW COLUMNS FROM `langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }

    unset($data[0]);
    unset($data[1]);

    $lang_update_queries = array();
    foreach ($data as $key => $value) {
        $value = ($value);
        if ($value == 'arabic') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'لا مزيد من الاشتراكات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'بيع أشرطة الفيديو بأي ثمن');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'حدد سعرًا للمشاهد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'أقل سعر يمكنك تعيينه هو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'يتم بيع هذا الفيديو ، يجب عليك شراء الفيديو لمشاهدته.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'دفع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'مقاطع الفيديو المدفوعة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'لم يتم العثور على مقاطع فيديو مدفوعة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'المعاملات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'هوية شخصية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'اسم المدفوع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'لجنة الموقع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'زمن');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'اشتريت الفيديو الخاص بك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'سعر الفيديو هذا هو:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'اشترى');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'توازن');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'يجب أن يكون سعر الفيديو رقميًا وأكبر من');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'تم التحقق من هذا الفيديو بواسطة فريقنا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'هذا المقطع لم يعد متوفرا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'لديك حق الوصول إلى جميع مقاطع الفيديو ، مدفوعة ومجانية كما كنت مسؤولا.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'صافي الأرباح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'حد تحميل المستخدم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'لقد وصلت إلى الحد الأقصى للتحميل ، إذا كنت ترغب في زيادته');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'الرجاء التواصل معنا');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'لقد وصلت إلى الحد الأقصى للتحميل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'تحميل حتى');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'تحميل مقاطع فيديو غير محدودة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'توثيق ذو عاملين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'تعطيل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'مكن');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'لقد أرسلنا إليك رمز التأكيد إلى عنوان بريدك الإلكتروني.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'تأكيد الكود');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'رمز تأكيد خطأ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'قم بتشغيل تسجيل الدخول المكوَّن من خطوتين لتحسين مستوى أمان حسابك ، وبمجرد تشغيله ، ستستخدم كل من كلمة المرور ورمز الحماية المكون من 6 أرقام والمرسلين إلى بريدك الإلكتروني لتسجيل الدخول.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'تاريخ الرفع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'الساعة الأخيرة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'اليوم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'هذا الاسبوع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'هذا الشهر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'هذا العام');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'فيديو ستوديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'عرض التحليلات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'الإعجابات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'يكره');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'تحليلات الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'مجموع يحب');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'مجموع يكره');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'عدد المشاهدات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'عرض التقرير');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'لوحة القيادة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'أحدث تعليقات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'مجموع التعليقات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'مجموع التعليقات اليوم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'مجموع التعليقات هذا الشهر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'مجموع التعليقات هذا العام');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'تعديل التعليق');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'تحليلات القناة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'مجموع المشتركين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'معظم الفيديوهات التي تمت مشاهدتها');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'أحب معظم الفيديوهات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'مقاطع الفيديو الأكثر إعجابًا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'مقاطع الفيديو الأكثر تعليقًا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'الشهر الماضي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'مشتركين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'الأرباح الكلية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'أرباح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'تتم إضافة الفيديو الخاص بك إلى قائمة الانتظار ، يرجى التحقق مرة أخرى في غضون بضع دقائق.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'تتم إضافة هذا الفيديو إلى قائمة الانتظار ، يرجى التحقق مرة أخرى في غضون بضع دقائق.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'ترتيب حسب');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'تعيين للمستخدم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'المستخدم غير موجود');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'القنوات الشعبية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'لا مزيد من القنوات لإظهارها');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'لم يتم العثور على قنوات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'مصنف بواسطة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'الفئة الفرعية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'لا شيء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'الكل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'هذا الفيديو غير متوفر في موقعك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'جيو الحظر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'موقعك غير معروف ، لذا تم حظر هذا الفيديو.يجوز لك إعادة المحاولة لاحقًا.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'أرباح الإعلانات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'أرباح الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'كسب المبيعات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'تحليلات الإعلانات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'كل الوقت');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'آخر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'تحليلات');
        } else if ($value == 'dutch') {
             $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'Geen abonnementen meer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Verkoop video\'s voor elke prijs');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Stel een prijs in voor de kijker');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Minimumprijs die u kunt instellen is');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'Deze video wordt verkocht, je moet de video kopen om deze te bekijken.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Betalen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Betaalde video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'Geen betaalde video\'s gevonden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'transacties');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'ID kaart');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Naam betaler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Site Commissie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Tijd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'heb je video gekocht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'Deze videoprijs is:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'Gekocht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Balans');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'De videoprijs moet numeriek en groter zijn dan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'Deze video wordt geverifieerd door ons team');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'Deze video is niet langer beschikbaar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'Je hebt toegang tot alle video\'s, betaald en gratis als je een beheerder bent.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Netto inkomen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'Gebruikers upload limiet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'U heeft uw maximale uploadlimiet bereikt, als u deze wilt verhogen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'Gelieve ons te contacteren');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'U heeft uw maximale uploadlimiet bereikt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Upload tot');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Upload onbeperkt video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Twee-factor-authenticatie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'onbruikbaar maken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'in staat stellen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'We hebben je de bevestigingscode gestuurd naar je e-mailadres.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Bevestigingscode');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Foutieve bevestigingscode');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Schakel login in 2 stappen in om de beveiliging van uw account te verbeteren. Als u eenmaal bent ingeschakeld, gebruikt u zowel uw wachtwoord als een uit 6 cijfers bestaande beveiligingscode die naar uw e-mailadres is gestuurd om u aan te melden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Upload datum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Laatste uur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Vandaag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'Deze week');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'Deze maand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'Dit jaar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Video Studio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'Bekijk Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'sympathieën');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Houdt niet van');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Video Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Totaal houdt van');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Totaal houdt niet van');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Totaal aantal weergaven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'Bekijk rapport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Dashboard');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'laatste Reacties');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Totaal commentaar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Totaal aantal reacties vandaag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Totaal aantal reacties deze maand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Totaal aantal reacties dit jaar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Commentaar bewerken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Kanaalanalyses');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Totaal aantal abonnees');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Meest bekeken video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Meest populaire video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Meest gehate video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'De meeste video\'s met commentaar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'Vorige maand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'abonnees');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'totale winst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'verdiensten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Je video wordt aan de wachtrij toegevoegd. Probeer het over enkele minuten opnieuw.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'Deze video wordt aan de wachtrij toegevoegd. Probeer het over enkele minuten opnieuw.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sorteer op');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Toewijzen aan gebruiker');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'Gebruiker bestaat niet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Populaire kanalen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'Geen kanalen meer om te laten zien');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'Geen kanalen gevonden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Filteren op');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Subcategorie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Geen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'Allemaal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'Deze video is niet beschikbaar op jouw locatie.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo-blokkering');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Uw locatie is onbekend, dus deze video is geblokkeerd. kunt het later opnieuw proberen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Inkomsten uit advertenties');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Video-inkomsten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Verkoop verdienen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Analytics voor advertenties');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'Altijd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'anders');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'Analytics');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'Pas plus d\'abonnements');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Vendre des vidéos à tout prix');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Fixer un prix pour le spectateur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Le prix minimum que vous pouvez définir est');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'Cette vidéo est en vente, vous devez acheter la vidéo pour la regarder.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Payer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Vidéos payées');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'Aucune vidéo payée trouvée');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'Transactions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'ID');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Nom du payeur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Commission de chantier');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Temps');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'acheté votre vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'Le prix de cette vidéo est:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'Acheté');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Équilibre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'Le prix de la vidéo doit être numérique et supérieur à');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'Cette vidéo est vérifiée par notre équipe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'Cette vidéo n\'est plus disponible');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'Vous avez accès à toutes les vidéos, payantes et gratuites, car vous êtes un administrateur.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Bénéfice net');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'Limite de téléchargement utilisateur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'Vous avez atteint votre limite maximale de téléchargement, si vous souhaitez l\'augmenter');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'Contactez nous s\'il vous plait');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'Vous avez atteint votre limite de téléchargement maximale');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Télécharger jusqu\'à');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Télécharger des vidéos illimitées');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Authentification à deux facteurs');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'Désactiver');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'Activer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'Nous vous avons envoyé le code de confirmation à votre adresse e-mail.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Code de confirmation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Mauvais code de confirmation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Activez la connexion en deux étapes pour renforcer la sécurité de votre compte. Une fois activé, vous utiliserez votre mot de passe et un code de sécurité à 6 chiffres envoyé à votre adresse e-mail pour vous connecter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Date de dépôt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Dernière heure');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Aujourd\'hui');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'Cette semaine');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'Ce mois-ci');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'Cette année');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Studio vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'Voir Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Aime');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'N\'aime pas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Analyse vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Total de J\'aime');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Total n\'aime pas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Vues totales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'Voir le rapport');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Tableau de bord');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'Derniers Commentaires');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Total des commentaires');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Total des commentaires aujourd\'hui');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Total des commentaires ce mois-ci');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Total des commentaires cette année');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Modifier le commentaire');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Analyse de canal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Nombre total d\'abonnés');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Vidéos les plus visionnées');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Vidéos les plus appréciées');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Vidéos les plus détestées');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'Vidéos les plus commentées');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'Le mois dernier');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Les abonnés');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'Total des gains');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'Gains');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Votre vidéo est en train d\'être ajoutée à la file d\'attente. Veuillez vérifier dans quelques minutes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'Cette vidéo est en train d\'être ajoutée à la file d\'attente. Veuillez vérifier à nouveau dans quelques minutes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Trier par');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Assigner à l\'utilisateur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'L\'utilisateur n\'est pas exister');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Chaînes populaires');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'Plus de chaînes à montrer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'Aucune chaîne trouvée');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Filtrer par');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Sous catégorie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Aucun');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'Tout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'Cette vidéo n\'est pas disponible dans votre région.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Blocage géographique');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Votre position est inconnue, cette vidéo a donc été bloquée. Vous pouvez réessayer plus tard.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Revenu des annonces');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Vidéos Gains');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Ventes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Analyse des annonces');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'Tout le temps');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Autre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'Analytique');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'Keine weiteren Abonnements');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Verkaufen Sie Videos um jeden Preis');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Legen Sie einen Preis für den Viewer fest');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Mindestpreis, den Sie einstellen können, ist');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'Dieses Video wird verkauft, Sie müssen es kaufen, um es anzusehen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Zahlen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Bezahlte Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'Keine bezahlten Videos gefunden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'Transaktionen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'ICH WÜRDE');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Name des Zahlers');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Standortkommission');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Zeit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'kaufte dein video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'Dieser Videopreis beträgt:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'Gekauft');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Balance');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'Der Videopreis sollte numerisch und größer als sein');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'Dieses Video wird von unserem Team überprüft');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'Dieses Video ist nicht mehr verfügbar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'Sie haben Zugriff auf alle Videos, bezahlt und kostenlos, da Sie ein Administrator sind.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Nettoverdienst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'Benutzer-Upload-Limit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'Sie haben Ihr maximales Upload-Limit erreicht, wenn Sie es erhöhen möchten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'bitte kontaktieren Sie uns');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'Sie haben Ihr maximales Upload-Limit erreicht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Laden Sie bis zu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Lade unbegrenzt Videos hoch');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Zwei-Faktor-Authentifizierung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'Deaktivieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'Aktivieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'Wir haben Ihnen den Bestätigungscode an Ihre E-Mail-Adresse gesendet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Bestätigungscode');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Falscher Bestätigungscode');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Aktivieren Sie die Anmeldung in zwei Schritten, um die Sicherheit Ihres Kontos zu erhöhen. Nach dem Einschalten verwenden Sie sowohl Ihr Passwort als auch einen 6-stelligen Sicherheitscode, der an Ihre E-Mail gesendet wird, um sich anzumelden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Hochladedatum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Letzte Stunde');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Heute');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'Diese Woche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'Diesen Monat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'Dieses Jahr');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Videostudio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'Analytics anzeigen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Likes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Abneigungen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Video Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Likes insgesamt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Total Abneigungen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Gesamtansichten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'Zeige Bericht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Instrumententafel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'neueste Kommentare');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Kommentare insgesamt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Kommentare heute insgesamt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Kommentare insgesamt in diesem Monat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Kommentare insgesamt in diesem Jahr');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Kommentar bearbeiten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Channel Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Abonnenten insgesamt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Meistgesehene Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Meistgeliebte Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Beliebteste Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'Meist kommentierte Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'Im vergangenen Monat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Abonnenten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'Gesamteinnahmen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'Verdienste');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Ihr Video wird zur Warteschlange hinzugefügt. Bitte versuchen Sie es in wenigen Minuten noch einmal.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'Dieses Video wird zur Warteschlange hinzugefügt. Bitte versuchen Sie es in wenigen Minuten noch einmal.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sortiere nach');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Einem Benutzer zuweisen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'Benutzer ist nicht vorhanden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Beliebte Kanäle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'Keine Kanäle mehr zu zeigen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'Keine Channels gefunden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Filtern nach');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Unterkategorie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Keiner');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'Alles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'Dieses Video ist an Ihrem Standort nicht verfügbar.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo-Blocking');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Ihr Standort ist unbekannt, daher wurde dieses Video gesperrt. Sie können es später erneut versuchen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Werbeeinnahmen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Videos Einnahmen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Verkäufe verdienen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Anzeigenanalysen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'Alle zeit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Andere');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'Analytics');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'Нет больше подписок');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Продавать видео по любой цене');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Установить цену для зрителя');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Минимальная цена, которую вы можете установить,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'Это видео продается, вы должны купить видео, чтобы посмотреть его.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'платить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Платные видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'Платные видео не найдены');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'операции');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'Я БЫ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Имя плательщика');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Комиссия сайта');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Время');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'купил ваше видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'Цена этого видео:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'купленный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Остаток средств');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'Цена видео должна быть числовой и превышать');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'Это видео проверено нашей командой');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'Это видео больше не доступно');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'У вас есть доступ ко всем видео, платным и бесплатным, поскольку вы являетесь администратором.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Чистая выручка');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'Предел загрузки пользователя');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'Вы достигли максимального лимита загрузки, если хотите увеличить его');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'пожалуйста свяжитесь с нами');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'Вы достигли максимального ограничения загрузки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Загрузить до');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Загружайте неограниченное количество видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Двухфакторная аутентификация');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'запрещать');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'включить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'Мы отправили вам код подтверждения на ваш адрес электронной почты.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Код для подтверждения');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Неверный код подтверждения');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Включите двухэтапную регистрацию, чтобы повысить уровень безопасности своей учетной записи. После включения вы будете использовать для входа в свой пароль и 6-значный код безопасности, отправленный на вашу электронную почту.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Дата загрузки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Последний час');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'сегодня');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'На этой неделе');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'Этот месяц');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'В этом году');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Видеостудия');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'Просмотр аналитики');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Нравится');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Не нравится');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Видео Аналитика');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Всего лайков');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Всего не нравится');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Всего просмотров');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'Посмотреть отчет');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Приборная доска');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'Последние комментарии');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Всего комментариев');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Всего комментариев сегодня');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Всего комментариев в этом месяце');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Всего комментариев в этом году');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Редактировать комментарий');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Канальная аналитика');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Всего подписчиков');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Самые популярные видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Самые популярные видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Самые популярные видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'Самые комментируемые видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'Прошлый месяц');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Подписчики');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'Общий доход');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'прибыль');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Ваше видео добавляется в очередь, пожалуйста, проверьте его через несколько минут.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'Это видео добавляется в очередь, пожалуйста, зайдите через несколько минут.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Сортировать по');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Назначить пользователю');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'Пользователь не существует');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Популярные каналы');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'Нет больше каналов для показа');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'Каналы не найдены');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Сортировать по');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Подкатегория');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Никто');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'Все');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'Это видео недоступно в вашем регионе.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo Blocking');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Ваше местоположение неизвестно, поэтому это видео было заблокировано. Вы можете попробовать позже.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Доходы от рекламы');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Видео Заработок');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Доход от продаж');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Рекламная аналитика');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'Все время');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Другой');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'аналитика');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'No mas suscripciones');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Vende videos a cualquier precio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Establecer un precio para el espectador');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'El precio mínimo que puede establecer es');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'Este video se está vendiendo, tienes que comprar el video para verlo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Paga');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Videos de pago');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'No se encontraron videos pagados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'Actas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'CARNÉ DE IDENTIDAD');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Nombre del pagador');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Vídeo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Comisión del sitio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Hora');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'compré tu video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'El precio de este video es:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'Comprado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Equilibrar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'El precio del video debe ser numérico y mayor que');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'Este video es verificado por nuestro equipo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'Este video ya no está disponible');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'Tienes acceso a todos los videos, de pago y gratis como eres administrador.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Ganancias netas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'Límite de carga del usuario');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'Has alcanzado tu límite máximo de carga, si deseas aumentarlo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'por favor contáctenos');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'Has alcanzado tu límite máximo de subida.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Subir hasta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Subir videos ilimitados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Autenticación de dos factores');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'Inhabilitar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'Habilitar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'Le hemos enviado el código de confirmación a su dirección de correo electrónico.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Código de confirmación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Código de confirmación incorrecto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Active el inicio de sesión en dos pasos para aumentar la seguridad de su cuenta. Una vez que lo haya activado, utilizará su contraseña y un código de seguridad de 6 dígitos enviado a su correo electrónico para iniciar sesión.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Fecha de carga');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Ultima hora');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Hoy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'Esta semana');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'Este mes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'Este año');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Estudio de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'Ver Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Gustos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Aversiones');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Video Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Me gusta en total');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Aversiones totales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Vistas totales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'Vista del informe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Tablero');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'últimos comentarios');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Total de comentarios');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Total de comentarios hoy');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Total de comentarios este mes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Total de comentarios de este año');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Editar comentario');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Analítica de canales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Total de suscriptores');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Videos más vistos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Videos que mas me gustaron');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Los videos más disgustados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'Videos más comentados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'El mes pasado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Suscriptores');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'Ganancias Totales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'Ganancias');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Su video se está agregando a la cola, por favor, vuelva en unos minutos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'Este video se está agregando a la cola, por favor revise de nuevo en unos minutos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Ordenar por');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Asignar a usuario');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'El usuario no existe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Canales populares');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'No hay más canales para mostrar.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'No se encontraron canales');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Filtrado por');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Subcategoría');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Ninguna');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'Todos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'Este video no está disponible en tu ubicación.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Bloqueo geográfico');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Su ubicación es desconocida, por lo que este video fue bloqueado. Puedes intentarlo más tarde.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Ganancias de los anuncios');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Videos de ganancias');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Ventas ganando');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Ads Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'Todo el tiempo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Otro');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'Analítica');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'Başka abonelik yok');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Videoları herhangi bir fiyattan satmak');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Görüntüleyici için bir fiyat belirleme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Ayarlayabileceğiniz minimum fiyat:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'Bu video satılıyor, izlemek için videoyu satın almanız gerekiyor.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'ödeme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Ücretli Videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'Ücretli video bulunamadı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'işlemler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'İD');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Ödeme adı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Site Komisyonu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'zaman');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'videonuzu satın aldı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'Bu video fiyatı:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'satın alındı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Denge');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'Video fiyatı sayısal ve daha büyük olmalıdır');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'Bu video ekibimiz tarafından doğrulandı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'Bu video artık mevcut değil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'Tüm videolara, yönetici olduğunuzdan ücretli ve ücretsiz erişebilirsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Net kazançlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'Kullanıcı Yükleme Sınırı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'Artırmak isterseniz, maksimum yükleme sınırınıza ulaştınız');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'lütfen bizimle iletişime geçin');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'Maksimum yükleme sınırınıza ulaştınız');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Kadar yükle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Sınırsız video yükle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'İki faktörlü kimlik doğrulama');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'Devre dışı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'etkinleştirme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'Size e-posta adresinize onay kodunu gönderdik.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Onay kodu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Yanlış onay kodu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Hesabınızın güvenliğini artırmak için 2 adımlı giriş özelliğini açın. Açıldıktan sonra, giriş yapmak için e-postanıza gönderilen şifrenizi ve 6 basamaklı bir güvenlik kodunu kullanacaksınız.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Yükleme tarihi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Son saat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Bugün');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'Bu hafta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'Bu ay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'Bu yıl');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Video Stüdyosu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'Analytics\'i görüntüle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Seviyor');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Beğenmeme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Video Analizi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Toplam Beğeniler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Toplam Sevmediğim');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Toplam görüntülenme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'Raporu görüntüle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'gösterge paneli');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'son Yorumlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Toplam Yorumlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Bugün Toplam Yorum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Bu Ayın Toplam Yorumu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Bu Yanda Toplam Yorum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Yorumu Düzenle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Kanal Analizi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Toplam Aboneler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'En Çok İzlenen Videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'En Çok İzlenen Videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'En Beğenilmeyen Videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'En Çok Yorumlanan Videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'Geçen ay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Aboneler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'toplam kazanç');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'Kazanç');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Videonuz sıraya ekleniyor, lütfen birkaç dakika içinde tekrar kontrol edin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'Bu video kuyruğa ekleniyor, lütfen birkaç dakika içinde tekrar kontrol edin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Göre sırala');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Kullanıcıya Atama');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'Kullanıcı mevcut değil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Popüler Kanallar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'Gösterilecek başka kanal yok');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'Kanal bulunamadı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Tarafından filtre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Alt Kategori');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'Yok');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'Herşey');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'Bu video bulunduğunuz yerde mevcut değil.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Coğrafi Engelleme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Konumunuz bilinmiyor, bu nedenle bu video engellendi. Daha sonra tekrar deneyebilirsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Reklam Kazançları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Videolar Kazançları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Satış Kazançları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Reklam Analizi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'Her zaman');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Diğer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'analitik');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'No more subscriptions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Sell videos at any price');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Price (Leave empty for free videos)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Minimum price you can set is');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'This video is being sold, you have to purchase the video to watch it.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Purchase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Paid Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'No paid videos found');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'Transactions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'ID');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Payer Name');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Site Commission');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Time');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'purchased your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'This video price is:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'Purchases');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Balance');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'The video price should be numeric and greater than');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'This video is verified by our team');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'This video is no longer available');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'You have access to all videos, paid and free as you are an admin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Net earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'User Upload Limit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'You have reached your maximum upload limit, if you wish to increase it');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'please contact us');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'You have reached your maximum upload limit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Upload up to');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Upload unlimited videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Two-factor authentication');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'Disable');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'Enable');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'We have sent you the confirmation code to your email address.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Confirmation Code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Wrong confirmation code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Turn on 2-step login to level-up your account\'s security, Once turned on, you\'ll use both your password and a 6-digit security code sent to your email to log in.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Upload Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Last hour');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Today');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'This week');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'This month');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'This year');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Video Studio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'View Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Likes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Dislikes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Video Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Total Likes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Total Dislikes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Total Views');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'View report');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Dashboard');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'Latest Comments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Total Comments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Comments Today');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Comments This Month');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Comments This Year');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Edit Comment');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Channel Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Total Subscribers');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Most Viewed Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Most Liked Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Most Disliked Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'Most Commented Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'This month compared to last month');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Subscribers');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'Total Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Your video is being added to queue, please check back in few minutes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'This video is being added to queue, please check back in few minutes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sort By');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Assign To User');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'User is not exist');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Popular Channels');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'No more channels to show');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'No channels found');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Filter By');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Sub Category');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'None');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'All');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'This video is not available in your location.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo Blocking');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Your location is unknown, therefore this video was blocked.\r\nYou may try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Ads Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Video Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Sales Earning');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Ads Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'All Time');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Other');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'Analytics');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_s_to_show', 'No more subscriptions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sell_videos', 'Sell videos at any price');
            $lang_update_queries[] = PT_UpdateLangs($value, 'set_p_v', 'Price (Leave empty for free videos)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'p_m_than_', 'Minimum price you can set is');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see', 'This video is being sold, you have to purchase the video to watch it.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay', 'Purchase');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_videos', 'Paid Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_videos_found_paid', 'No paid videos found');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transactions', 'Transactions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'id', 'ID');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payer_name', 'Payer Name');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video', 'Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'site_com', 'Site Commission');
            $lang_update_queries[] = PT_UpdateLangs($value, 'time', 'Time');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paid_to_see', 'purchased your video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price', 'This video price is:');
            $lang_update_queries[] = PT_UpdateLangs($value, 'purchased', 'Purchases');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_', 'Balance');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_price_error', 'The video price should be numeric and greater than');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_verified', 'This video is verified by our team');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available', 'This video is no longer available');
            $lang_update_queries[] = PT_UpdateLangs($value, 'admin_can_see', 'You have access to all videos, paid and free as you are an admin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'net_earn', 'Net earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_upload_limit', 'User Upload Limit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_reached_upload_limit', 'You have reached your maximum upload limit, if you wish to increase it');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_contact', 'please contact us');
            $lang_update_queries[] = PT_UpdateLangs($value, '_reached_max_limit', 'You have reached your maximum upload limit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up', 'Upload up to');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_up_no_limit', 'Upload unlimited videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor', 'Two-factor authentication');
            $lang_update_queries[] = PT_UpdateLangs($value, 'disable', 'Disable');
            $lang_update_queries[] = PT_UpdateLangs($value, 'enable', 'Enable');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sent_two_factor_email', 'We have sent you the confirmation code to your email address.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_code', 'Confirmation Code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_confirm_code', 'Wrong confirmation code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'two_factor_description', 'Turn on 2-step login to level-up your account\'s security, Once turned on, you\'ll use both your password and a 6-digit security code sent to your email to log in.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_date', 'Upload Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_hour', 'Last hour');
            $lang_update_queries[] = PT_UpdateLangs($value, 'today', 'Today');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_week', 'This week');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_month', 'This month');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_year', 'This year');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_studio', 'Video Studio');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_analytics', 'View Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'likes', 'Likes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislikes', 'Dislikes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_analytics', 'Video Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_likes', 'Total Likes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_dislikes', 'Total Dislikes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_views', 'Total Views');
            $lang_update_queries[] = PT_UpdateLangs($value, 'view_report', 'View report');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dashboard', 'Dashboard');
            $lang_update_queries[] = PT_UpdateLangs($value, 'latest_comments', 'Latest Comments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments', 'Total Comments');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_today', 'Comments Today');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_month', 'Comments This Month');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_comments_year', 'Comments This Year');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_comment', 'Edit Comment');
            $lang_update_queries[] = PT_UpdateLangs($value, 'channel_analytics', 'Channel Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_sub', 'Total Subscribers');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_viewed', 'Most Viewed Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_liked', 'Most Liked Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_disliked', 'Most Disliked Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_most_commented', 'Most Commented Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_month', 'This month compared to last month');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribers', 'Subscribers');
            $lang_update_queries[] = PT_UpdateLangs($value, 'total_earn', 'Total Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'earnings', 'Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ur_video_queue', 'Your video is being added to queue, please check back in few minutes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'this_video_queue', 'This video is being added to queue, please check back in few minutes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sort_by', 'Sort By');
            $lang_update_queries[] = PT_UpdateLangs($value, 'assign_to_user', 'Assign To User');
            $lang_update_queries[] = PT_UpdateLangs($value, 'user_not_exists', 'User is not exist');
            $lang_update_queries[] = PT_UpdateLangs($value, 'popular_channels', 'Popular Channels');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_channels_to_show', 'No more channels to show');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_channels_found_for_now', 'No channels found');
            $lang_update_queries[] = PT_UpdateLangs($value, 'filter_by', 'Filter By');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sub_category', 'Sub Category');
            $lang_update_queries[] = PT_UpdateLangs($value, 'none', 'None');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all', 'All');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_not_available_location', 'This video is not available in your location.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'geo_blocking', 'Geo Blocking');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unknown_location', 'Your location is unknown, therefore this video was blocked.\r\nYou may try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_earnings', 'Ads Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'videos_earnings', 'Video Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'sales_earnings', 'Sales Earning');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ads_analytics', 'Ads Analytics');
            $lang_update_queries[] = PT_UpdateLangs($value, 'all_time', 'All Time');
            $lang_update_queries[] = PT_UpdateLangs($value, 'other', 'Other');
            $lang_update_queries[] = PT_UpdateLangs($value, 'analytics', 'Analytics');
        }
    }

    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }

    $data  = array();
    $query = mysqli_query($sqlConnect, "SHOW COLUMNS FROM `langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
     $data[] = $fetched_data['Field'];
    }

    unset($data[0]);
    unset($data[1]);
    unset($data[2]);

    $lang_update_first_queries = '';
    $first = "INSERT INTO `langs` (`id`, `lang_key`,`type`";
    $categories_array = array();
    $query_list = array();
    foreach ($data as $key => $value) {
        include './assets/langs/'.$value.'.php';
        $categories_array[$value] = $categories;
        if (empty($lang_update_first_queries)) {
            $lang_update_first_queries = $first.",`".$value."`";
        }
        else{
            if (end($data) == $value) {
                $lang_update_first_queries = $lang_update_first_queries.",`".$value."`) VALUES  (NULL";
            }
            else{
                $lang_update_first_queries = $lang_update_first_queries.",`".$value."`";
            }
        }
    }
    foreach ($categories as $key => $value) {
        $query_list[$key] = '';
    }
    $all = '';
    foreach ($categories_array as $key => $lang) {

        foreach ($lang as $cat_key => $cat_value) {
            if (empty($query_list[$cat_key])) {
                $query_list[$cat_key] = $lang_update_first_queries.",'".$cat_key."','category','".$cat_value."'";
            }
            else{
                if (end($data) == $key) {
                    $query_list[$cat_key] = $query_list[$cat_key].",'".$cat_value."');";
                     mysqli_query($sqlConnect,$query_list[$cat_key]);
                }
                else{
                    $query_list[$cat_key] = $query_list[$cat_key].",'".$cat_value."'";
                }
            }
        }
    }

    $name = md5(microtime()) . '_updated.php';
    rename('update.php', $name);
}
?>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <title>Updating PlayTube</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <style>
         @import url('https://fonts.googleapis.com/css?family=Roboto:400,500');
         @media print {
            .wo_update_changelog {max-height: none !important; min-height: !important}
            .btn, .hide_print, .setting-well h4 {display:none;}
         }
         * {outline: none !important;}
         body {background: #f3f3f3;font-family: 'Roboto', sans-serif;}
         .light {font-weight: 400;}
         .bold {font-weight: 500;}
         .btn {height: 52px;line-height: 1;font-size: 16px;transition: all 0.3s;border-radius: 2em;font-weight: 500;padding: 0 28px;letter-spacing: .5px;}
         .btn svg {margin-left: 10px;margin-top: -2px;transition: all 0.3s;vertical-align: middle;}
         .btn:hover svg {-webkit-transform: translateX(3px);-moz-transform: translateX(3px);-ms-transform: translateX(3px);-o-transform: translateX(3px);transform: translateX(3px);}
         .btn-main {color: #ffffff;background-color: #00BCD4;border-color: #00BCD4;}
         .btn-main:disabled, .btn-main:focus {color: #fff;}
         .btn-main:hover {color: #ffffff;background-color: #0dcde2;border-color: #0dcde2;box-shadow: -2px 2px 14px rgba(168, 72, 73, 0.35);}
         svg {vertical-align: middle;}
         .main {color: #00BCD4;}
         .wo_update_changelog {
          border: 1px solid #eee;
          padding: 10px !important;
         }
         .content-container {display: -webkit-box; width: 100%;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;flex-direction: column;min-height: 100vh;position: relative;}
         .content-container:before, .content-container:after {-webkit-box-flex: 1;box-flex: 1;-webkit-flex-grow: 1;flex-grow: 1;content: '';display: block;height: 50px;}
         .wo_install_wiz {position: relative;background-color: white;box-shadow: 0 1px 15px 2px rgba(0, 0, 0, 0.1);border-radius: 10px;padding: 20px 30px;border-top: 1px solid rgba(0, 0, 0, 0.04);}
         .wo_install_wiz h2 {margin-top: 10px;margin-bottom: 30px;display: flex;align-items: center;}
         .wo_install_wiz h2 span {margin-left: auto;font-size: 15px;}
         .wo_update_changelog {padding:0;list-style-type: none;margin-bottom: 15px;max-height: 440px;overflow-y: auto; min-height: 440px;}
         .wo_update_changelog li {margin-bottom:7px; max-height: 20px; overflow: hidden;}
         .wo_update_changelog li span {padding: 2px 7px;font-size: 12px;margin-right: 4px;border-radius: 2px;}
         .wo_update_changelog li span.added {background-color: #4CAF50;color: white;}
         .wo_update_changelog li span.changed {background-color: #e62117;color: white;}
         .wo_update_changelog li span.improved {background-color: #9C27B0;color: white;}
         .wo_update_changelog li span.compressed {background-color: #795548;color: white;}
         .wo_update_changelog li span.fixed {background-color: #2196F3;color: white;}
         input.form-control {background-color: #f4f4f4;border: 0;border-radius: 2em;height: 40px;padding: 3px 14px;color: #383838;transition: all 0.2s;}
input.form-control:hover {background-color: #e9e9e9;}
input.form-control:focus {background: #fff;box-shadow: 0 0 0 1.5px #a84849;}
         .empty_state {margin-top: 80px;margin-bottom: 80px;font-weight: 500;color: #6d6d6d;display: block;text-align: center;}
         .checkmark__circle {stroke-dasharray: 166;stroke-dashoffset: 166;stroke-width: 2;stroke-miterlimit: 10;stroke: #7ac142;fill: none;animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;}
         .checkmark {width: 80px;height: 80px; border-radius: 50%;display: block;stroke-width: 3;stroke: #fff;stroke-miterlimit: 10;margin: 100px auto 50px;box-shadow: inset 0px 0px 0px #7ac142;animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;}
         .checkmark__check {transform-origin: 50% 50%;stroke-dasharray: 48;stroke-dashoffset: 48;animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;}
         @keyframes stroke { 100% {stroke-dashoffset: 0;}}
         @keyframes scale {0%, 100% {transform: none;}  50% {transform: scale3d(1.1, 1.1, 1); }}
         @keyframes fill { 100% {box-shadow: inset 0px 0px 0px 54px #7ac142; }}
      </style>
   </head>
   <body>
      <div class="content-container container">
         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
               <div class="wo_install_wiz">
                 <?php if ($updated == false) { ?>
                  <div>
                     <h2 class="light">Update to v1.5 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                            <li>[Added] video studio, view detailed charts and analytics of videos, views, likes, dislikes, comments and many other features. </li>
                            <li>[Added] paid videos system, user can sell his own videos to other viewers + admin commission</li>
                            <li>[Added] auto import videos using assigned users, admin can assign a user, and the videos will be imported to the user's account.</li>
                            <li>[Added] Upload disk limit for all users, pro users, and for specific users.</li>
                            <li>[Added] video seconds on comments, start a video from a spesfic seconds.</li>
                            <li>[Added] Subscription list to the left sidebar on youplay theme</li>
                            <li>[Added] Ajax load, content are loaded faster and smoother. </li>
                            <li>[Added] filter system on search page. </li>
                            <li>[Added] Two-factor authentication. </li>
                            <li>[Added] Identify the speed of the internet and select the quality based on that.</li>
                            <li>[Added] HTML editor for announcements</li>
                            <li>[Added] Popular Channels To browse most Precent popular channels.</li>
                            <li>[Added] The ability to change video author</li>
                            <li>[Added] 2 new players, videojs & fluid video player with preload support.</li>
                            <li>[Added] max ffmpeg process in same time, you can set how many ffmpeg process can run in same time.</li>
                            <li>[Added] the ability for admin to view ads from admin panel > ads.</li>
                            <li>[Added] the ability to import videos from twitch.tv for admin and for users.</li>
                            <li>[Added] GEO blocking, user can restrict a video from being viewed from blocked locations.</li>
                            <li>[Added] the ability to view ads from videos that are embeded on other sites.</li>
                            <li>[Added] onesingal API, to send push notifications to the mobile apps.</li>
                            <li>[Added] sub categories.</li>
                            <li>[Added] The ability to manage categories from admin panel.</li>
                            <li>[Fixed] few important bugs. </li>
                        </ul>
                        <p class="hide_print">Note: The update process might take few minutes.</p>
                        <p class="hide_print">Important: If you got any fail queries, please copy them, open a support ticket and send us the details.</p>
                        <br>
                             <button class="pull-right btn btn-default" onclick="window.print();">Share Log</button>
                             <button type="button" class="btn btn-main" id="button-update">
                             Update 
                             <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path>
                             </svg>
                          </button>
                     </div>
                     <?php }?>
                     <?php if ($updated == true) { ?>
                      <div>
                        <div class="empty_state">
                           <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                           </svg>
                           <p>Congratulations, you have successfully updated your site. Thanks for choosing WoWonder.</p>
                           <br>
                           <a href="<?php echo $wo['config']['site_url'] ?>" class="btn btn-main" style="line-height:50px;">Home</a>
                        </div>
                     </div>
                     <?php }?>
                  </div>
               </div>
            </div>
            <div class="col-md-1"></div>
         </div>
      </div>
   </body>
</html>
<script>  
var queries = [
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'sell_videos_system', 'on');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'admin_com_sell_videos', '1');",
    "CREATE TABLE `videos_transactions` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL DEFAULT '0',`paid_id` int(11) NOT NULL DEFAULT '0',`video_id` int(11) NOT NULL DEFAULT '0',`amount` varchar(11) NOT NULL DEFAULT '0',`admin_com` varchar(11) NOT NULL DEFAULT '0',`currency` varchar(11) NOT NULL DEFAULT 'USD',`time` varchar(50) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'who_sell', 'users');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'auto_approve_', 'yes');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'com_type', '0');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'upload_system_type', '0');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'max_upload_all_users', '1000000000');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'max_upload_free_users', '1000000000');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'max_upload_pro_users', '1000000000');",
     "ALTER TABLE `users` ADD `user_upload_limit` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `donation_paypal_email`;",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'player_type', 'default');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'two_factor_setting', 'on');",
     "ALTER TABLE `users` ADD `two_factor` INT(11) NOT NULL DEFAULT '0' AFTER `user_upload_limit`;",
     "CREATE TABLE `views` ( `id` int(11) NOT NULL AUTO_INCREMENT,`video_id` int(11) NOT NULL DEFAULT '0',`fingerprint` text NOT NULL,`user_id` int(11) NOT NULL DEFAULT '0',`time` varchar(50) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
     "ALTER TABLE `users` ADD `last_month` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `two_factor`;",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'queue_count', '0');",
     "CREATE TABLE `queue` (`id` int(11) NOT NULL AUTO_INCREMENT,`video_id` int(11) NOT NULL DEFAULT '0',`video_res` varchar(20) NOT NULL DEFAULT '',`processing` int(11) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'popular_channels', 'on');",
     "ALTER TABLE `videos` ADD `sell_video` INT(11) NOT NULL DEFAULT '0';",
     "ALTER TABLE `videos` ADD `sub_category` INT(11) NOT NULL DEFAULT '0' AFTER `sell_video`;",
     "ALTER TABLE `videos` ADD `twitch` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `facebook`, ADD `twitch_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `twitch`;",
     "ALTER TABLE `videos` ADD `geo_blocking` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `sub_category`;",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'twitch_api', 'twb88q5mhne1gsrwvkhtlugvrqniks');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'twitch_import', 'on');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'geo_blocking', 'on');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'server_key', '<?php echo md5(time())?>');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'earn_from_ads', 'on');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'push', '1');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'push_id', '');",
     "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'push_key', '');",
     "ALTER TABLE `notifications` ADD `sent_push` INT(11) NOT NULL DEFAULT '0' AFTER `time`;",
     "ALTER TABLE `users` ADD `device_id` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `email_code`;",
     "ALTER TABLE `langs` ADD `type` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `lang_key`;",
     "ALTER TABLE `videos` CHANGE `category_id` `category_id` VARCHAR(100) NOT NULL DEFAULT '';",
     "ALTER TABLE `videos` CHANGE `sub_category` `sub_category` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",
     "INSERT INTO `langs` (`id`, `lang_key`, `type`) VALUES (NULL, 'other', 'category')",
     "ALTER TABLE `notifications` ADD INDEX(`sent_push`);",
     "ALTER TABLE `payments` ADD INDEX(`type`);",
     "ALTER TABLE `payments` ADD INDEX(`user_id`);",
     "ALTER TABLE `payments` ADD INDEX(`amount`);",
     "ALTER TABLE `queue` ADD INDEX(`video_id`);",
     "ALTER TABLE `queue` ADD INDEX(`processing`);",
     "ALTER TABLE `queue` ADD INDEX(`video_res`);",
     "ALTER TABLE `reports` ADD INDEX(`video_id`);",
     "ALTER TABLE `reports` ADD INDEX(`article_id`);",
     "ALTER TABLE `reports` ADD INDEX(`ad_id`);",
     "ALTER TABLE `reports` ADD INDEX(`profile_id`);",
     "ALTER TABLE `reports` ADD INDEX(`user_id`);",
     "ALTER TABLE `site_ads` ADD INDEX(`active`);",
     "ALTER TABLE `site_ads` CHANGE `code` `code` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;",
     "ALTER TABLE `typings` ADD INDEX(`user_one`);",
     "ALTER TABLE `typings` ADD INDEX(`user_two`);",
     "ALTER TABLE `user_ads` ADD INDEX(`type`);",
     "ALTER TABLE `user_ads` ADD INDEX(`location`);",
     "ALTER TABLE `user_ads` ADD INDEX(`placement`);",
    "ALTER TABLE `user_ads` ADD INDEX(`user_id`);",
    "ALTER TABLE `user_ads` ADD INDEX(`category`);",
    "ALTER TABLE `user_ads` ADD INDEX(`status`)",
    "ALTER TABLE `videos` ADD INDEX(`twitch`);",
    "ALTER TABLE `videos` ADD INDEX(`sub_category`);",
    "ALTER TABLE `videos` ADD INDEX(`geo_blocking`);",
    "ALTER TABLE `videos` ADD INDEX(`sell_video`);",
    "ALTER TABLE `views` ADD INDEX(`video_id`);",
    "ALTER TABLE `views` CHANGE `fingerprint` `fingerprint` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",
    "ALTER TABLE `views` ADD INDEX(`user_id`);",
    "ALTER TABLE `views` ADD INDEX(`fingerprint`);",
    "ALTER TABLE `views` ADD INDEX(`time`);",
    "ALTER TABLE `lists` CHANGE `user_id` `user_id` INT(11) NOT NULL DEFAULT '0';",
    "ALTER TABLE `pt_posts` ADD INDEX(`user_id`);",
    "ALTER TABLE `pt_posts` ADD INDEX(`title`);",
    "ALTER TABLE `pt_posts` ADD INDEX(`active`);",
    "ALTER TABLE `site_ads` CHANGE `active` `active` INT(11) NOT NULL DEFAULT '0';",
    "ALTER TABLE `users` CHANGE `last_month` `last_month` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;",
    "CREATE TABLE `ads_transactions` (`id` int(11) NOT NULL AUTO_INCREMENT,`ad_id` int(11) NOT NULL DEFAULT '0',`video_owner` int(11) NOT NULL DEFAULT '0',`amount` varchar(11) NOT NULL DEFAULT '0',`type` varchar(50) NOT NULL DEFAULT '',`time` varchar(100) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `pt_posts` CHANGE `category` `category` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_more_s_to_show')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'sell_videos')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'set_p_v')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'p_m_than_')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_see')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'paid_videos')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_videos_found_paid')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'transactions')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'id')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'payer_name')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'site_com')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'time')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'paid_to_see')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_price')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'purchased')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'balance_')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_price_error')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_verified')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_not_available')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'admin_can_see')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'net_earn')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'user_upload_limit')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'user_reached_upload_limit')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'please_contact')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, '_reached_max_limit')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_up')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_up_no_limit')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'two_factor')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'disable')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'enable')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'sent_two_factor_email')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'confirm_code')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'wrong_confirm_code')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'two_factor_description')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_date')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'last_hour')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'today')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'this_week')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'this_month')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'this_year')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_studio')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'view_analytics')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'likes')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'dislikes')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_analytics')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_likes')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_dislikes')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_views')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'view_report')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'dashboard')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'latest_comments')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_comments')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_comments_today')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_comments_month')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_comments_year')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'edit_comment')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'channel_analytics')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_sub')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'the_most_viewed')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'the_most_liked')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'the_most_disliked')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'the_most_commented')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'last_month')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscribers')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_earn')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'earnings')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ur_video_queue')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'this_video_queue')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'sort_by')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'assign_to_user')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'user_not_exists')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'popular_channels')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_more_channels_to_show')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_channels_found_for_now')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'filter_by')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'sub_category')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'none')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'all')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_not_available_location')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'geo_blocking')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'unknown_location')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ads_earnings')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'videos_earnings')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'sales_earnings')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ads_analytics')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'all_time')",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'analytics');",
];

$('#input_code').bind("paste keyup input propertychange", function(e) {
    if (isPurchaseCode($(this).val())) {
        $('#button-update').removeAttr('disabled');
    } else {
        $('#button-update').attr('disabled', 'true');
    }
});

function isPurchaseCode(str) {
    var patt = new RegExp("(.*)-(.*)-(.*)-(.*)-(.*)");
    var res = patt.test(str);
    if (res) {
        return true;
    }
    return false;
}

$(document).on('click', '#button-update', function(event) {
    if ($('body').attr('data-update') == 'true') {
        window.location.href = '<?php echo $site_url?>';
        return false;
    }
    $(this).attr('disabled', true);
    $('.wo_update_changelog').html('');
    $('.wo_update_changelog').css({
        background: '#1e2321',
        color: '#fff'
    });
    $('.setting-well h4').text('Updating..');
    $(this).attr('disabled', true);
    RunQuery();
});

var queriesLength = queries.length;
var query = queries[0];
var count = 0;
function b64EncodeUnicode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}
function RunQuery() {
    var query = queries[count];
    $.post('?update', {
        query: b64EncodeUnicode(query)
    }, function(data, textStatus, xhr) {
        if (data.status == 200) {
            $('.wo_update_changelog').append('<li><span class="added">SUCCESS</span> ~$ mysql > ' + query + '</li>');
        } else {
            $('.wo_update_changelog').append('<li><span class="changed">FAILED</span> ~$ mysql > ' + query + '</li>');
        }
        count = count + 1;
        if (queriesLength > count) {
            setTimeout(function() {
                RunQuery();
            }, 100);
        } else {
            $('.wo_update_changelog').append('<li><span class="added">Updating Langauges & Categories</span> ~$ languages.sh, Please wait, this might take some time..</li>');
            $.post('?run_lang', {
                update_langs: 'true'
            }, function(data, textStatus, xhr) {
              $('.wo_update_changelog').append('<li><span class="fixed">Finished!</span> ~$ Congratulations! you have successfully updated your site. Thanks for choosing PlayTube.</li>');
              $('.setting-well h4').text('Update Log');
              $('#button-update').html('Home <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"> <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path> </svg>');
              $('#button-update').attr('disabled', false);
              $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
              $('body').attr('data-update', 'true');
            });
        }
        $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
    });
}
</script>