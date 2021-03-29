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
    unset($data[2]);
    $lang_update_queries = array();
    foreach ($data as $key => $value) {
        $value = ($value);
        if ($value == 'arabic') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'تعليق التحميل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'تعليق الاستيراد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'حي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'إنهاء العيش');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'انطلق مباشرة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'غير متصل على الانترنت');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', 'انتهى دفق {user}.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'كان حيا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'انضم إلى البث المباشر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'غادر البث المباشر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'بدأ البث المباشر.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'مقاطع فيديو حية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'كاش فري');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'رازورباي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'إيزيباي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'انقل رصيدك إلى محفظتك حتى تتمكن من استخدامه لإنشاء إعلانات واستخدام ميزات أخرى.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'لا يمكن أن يكون المبلغ أكبر من رصيدك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'ليس لديك رصيد كافي للتحويل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'نقاط');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'اربح {point} نقطة عن طريق التعليق على أي فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'اربح {point} نقطة مثل أي فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'اربح {point} نقطة مقابل عدم الإعجاب بأي فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'اربح {point} نقطة عن طريق تحميل أي فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'اربح {point} نقطة من خلال مشاهدة أي فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'نوع الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'فيديو الأسهم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'فيلم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'نوع الرخصة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'ترخيص إدارة الحقوق (RM)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'رخصة الاستخدام التحريري');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'ترخيص بدون حقوق ملكية (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'رخصة ممتدة بدون حقوق ملكية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'رخصة المشاع الإبداعي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'المجال العام');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'مقاطع فيديو الأسهم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'سعر دقيقة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'أقصى سعر');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Onderbreken van uploaden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Importeren onderbreken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Leven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Einde live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Ga leven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', '{user} stream is beëindigd.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'was live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'is lid geworden van livestream');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'live stream verlaten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'startte een livestream.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live video\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'zonder contant geld');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Verplaats uw saldo naar uw portemonnee, zodat u deze kunt gebruiken om advertenties te maken en andere functies te gebruiken.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Het bedrag kan niet hoger zijn dan uw saldo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'U heeft niet genoeg saldo om over te boeken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Punten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Verdien {punt} punten door op een video te reageren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Verdien {punt} punten door zoals elke video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Verdien {punt} punten door een video niet leuk te vinden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Verdien {punt} punten door een video te uploaden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Verdien {punt} punten door een video te bekijken');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Type video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Voorraadvideo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Licentie type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) -licentie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Licentie voor redactioneel gebruik');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty-vrije licentie (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty-vrije uitgebreide licentie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons-licentie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Publiek domein');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Stockvideo\'s');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Min. Prijs');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Max prijs');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Suspendre le téléchargement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Suspendre l\'importation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Vivre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Terminer en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Allez vivre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Hors ligne');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', 'Le flux de {utilisateur} est terminé.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'était en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'rejoint la diffusion en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'diffusion en direct gauche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'a commencé une diffusion en direct.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Vidéos en direct');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'sans argent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Déplacez votre solde vers votre portefeuille afin de pouvoir l\'utiliser pour créer des publicités et utiliser d\'autres fonctionnalités.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Le montant ne peut pas être supérieur à votre solde');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'Vous n\'avez pas assez de solde pour transférer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Points');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Gagnez {point} points en commentant n\'importe quelle vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Gagnez {point} points comme n\'importe quelle vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Gagnez {point} points en n\'aimant aucune vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Gagnez {point} points en téléversant n\'importe quelle vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Gagnez {point} points en regardant n\'importe quelle vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Type de vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Stock vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Type de licence');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Licence Rights Managed (RM)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Licence d\'utilisation éditoriale');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Licence libre de droits (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Licence étendue libre de droits');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Licence Creative Commons');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Domaine public');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Vidéos de stock');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Prix ​​min');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Prix ​​maximum');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Upload anhalten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Import anhalten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Leben');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Live beenden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Geh Leben');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', 'Der {Benutzer} Stream wurde beendet.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'war live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'Live-Stream beigetreten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'Live-Stream verlassen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'startete einen Live-Stream.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live-Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'bargeldlos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Verschieben Sie Ihr Guthaben in Ihre Brieftasche, damit Sie damit Anzeigen erstellen und andere Funktionen verwenden können.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Der Betrag kann nicht höher sein als Ihr Guthaben');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'Sie haben nicht genug Guthaben, um zu übertragen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Punkte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Sammeln Sie {Punkte} Punkte, indem Sie ein Video kommentieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Verdiene {Punkt} Punkte wie in jedem Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Verdiene {Punkt} Punkte, indem du ein Video nicht magst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Sammeln Sie {point} Punkte, indem Sie ein Video hochladen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Sammeln Sie {point} Punkte, indem Sie sich ein Video ansehen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Videotyp');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Stock Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Lizenz-Typ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) -Lizenz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Redaktionelle Nutzungslizenz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Lizenzfreie Lizenz (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Lizenzfreie erweiterte Lizenz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Stock Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Mindestpreis');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Maximaler Preis');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Приостановить загрузку');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Приостановить импорт');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Жить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Конец жизни');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Жить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Не в сети');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', 'Поток {user} закончился.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'был жив');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'присоединился к прямой трансляции');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'покинул прямую трансляцию');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'начал прямую трансляцию.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Живое видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'безналичный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Айзипай');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Переместите свой баланс в кошелек, чтобы вы могли использовать его для создания рекламы и других функций.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Сумма не может быть больше вашего баланса');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'У вас недостаточно средств для перевода');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Точки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Зарабатывайте {point} баллов, комментируя любое видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Зарабатывайте {point} баллов, ставя лайки любому видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Зарабатывайте {point} баллов, не ставя отметку "Мне понравилось" любое видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Зарабатывайте {point} баллов, загружая любое видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Зарабатывайте {point} баллов, просматривая любое видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Тип видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Стандартное видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Фильм');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Тип лицензии');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Лицензия с управляемыми правами (RM)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Лицензия на редакционное использование');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Бесплатная лицензия (РФ)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Расширенная лицензия без лицензионных отчислений');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Лицензия Creative Commons');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Всеобщее достояние');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Сток видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Минимальная цена');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Макс Цена');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Suspender carga');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Suspender importación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'En Vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Terminar en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Ir a vivir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Desconectado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', 'La transmisión de {user} ha finalizado.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'estaba en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'se unió a la transmisión en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'dejó la transmisión en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'comenzó una transmisión en vivo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Videos en vivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Pila de pagos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'sin efectivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Mueva su saldo a su billetera para que pueda usarlo para crear anuncios y usar otras funciones.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'La cantidad no puede ser mayor que su saldo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'No tienes saldo suficiente para transferir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Puntos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Gana {point} puntos comentando cualquier video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Gana {point} puntos por "Me gusta" en cualquier video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Gana {point} puntos si no te gusta un video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Gana {point} puntos subiendo cualquier video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Gana {point} puntos viendo cualquier video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Tipo de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Vídeo de archivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Película');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Tipo de licencia');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Licencia de derechos gestionados (RM)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Licencia de uso editorial');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Licencia libre de derechos (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Licencia extendida libre de derechos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Licencia Creative Commons');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Dominio publico');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Vídeos de archivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Precio min');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Precio máximo');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Yüklemeyi Askıya Al');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'İçe Aktarmayı Askıya Al');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Canlı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'Yayını bitir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Canlı yayına geç');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Çevrimdışı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', '{user} akışı sona erdi.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'canlıydı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'canlı yayına katıldı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'canlı yayından ayrıldı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'canlı yayın başlattı.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Canlı videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'nakitsiz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'İyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Bakiyenizi cüzdanınıza taşıyın, böylece reklam oluşturmak ve diğer özellikleri kullanmak için kullanabilirsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Tutar, bakiyenizden büyük olamaz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'Transfer etmek için yeterli bakiyeniz yok');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Puanlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Herhangi bir videoya yorum yaparak {point} puan kazanın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Herhangi bir video gibi {point} puan kazanın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Herhangi bir videoyu beğenmeyerek {point} puan kazanın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Herhangi bir videoyu yükleyerek {point} puan kazanın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Herhangi bir videoyu izleyerek {point} puan kazanın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Video Türü');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Stok Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'Lisans türü');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Yönetilen Haklar (RM) Lisansı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Haber Amaçlı Kullanım Lisansı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty Free Lisans (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Genişletilmiş Lisans');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons Lisansı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Kamu malı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Stok Videolar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Min Fiyat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Maksimum Fiyat');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Suspend Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Suspend Import');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'End live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Go live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', '{user} stream has ended.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'was live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'joined live stream');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'left live stream');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'started a live stream.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'cashfree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Move your balance to your wallet so you can use it to create ads and use other features.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Amount can`t be greater than your balance');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'You don`t have enough balance to transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Points');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Earn {point} points by commenting any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Earn {point} points by like any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Earn {point} points by dislike any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Earn {point} points by upload any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Earn {point} points by watching any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Video Type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Stock Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Movie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'License Type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Editorial Use License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty Free License (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Extended License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Stock Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Min Price');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Max Price');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_upload', 'Suspend Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'suspend_import', 'Suspend Import');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live', 'Live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'end_live', 'End live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'go_live', 'Go live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'offline', 'Offline');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stream_has_ended', '{user} stream has ended.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'was_live', 'was live');
            $lang_update_queries[] = PT_UpdateLangs($value, 'joined_live_video', 'joined live stream');
            $lang_update_queries[] = PT_UpdateLangs($value, 'left_live_video', 'left live stream');
            $lang_update_queries[] = PT_UpdateLangs($value, 'started_live_video', 'started a live stream.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'live_videos', 'Live videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paystack', 'Paystack');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cashfree', 'cashfree');
            $lang_update_queries[] = PT_UpdateLangs($value, 'razorpay', 'Razorpay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paysera', 'Paysera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'iyzipay', 'Iyzipay');
            $lang_update_queries[] = PT_UpdateLangs($value, 'move_balance_to_wallet', 'Move your balance to your wallet so you can use it to create ads and use other features.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'more_than_balance', 'Amount can`t be greater than your balance');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_balance_to_move', 'You don`t have enough balance to transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'points', 'Points');
            $lang_update_queries[] = PT_UpdateLangs($value, 'comment_video', 'Earn {point} points by commenting any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'like_video_point', 'Earn {point} points by like any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'dislike_video_point', 'Earn {point} points by dislike any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_video_point', 'Earn {point} points by upload any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'watch_video_point', 'Earn {point} points by watching any video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_type', 'Video Type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_video', 'Stock Video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie', 'Movie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'license_type', 'License Type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rights_managed_license', 'Rights Managed (RM) License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'editorial_use_license', 'Editorial Use License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_license', 'Royalty Free License (RF)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'royalty_free_extended_license', 'Royalty Free Extended License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'creative_commons_license', 'Creative Commons License');
            $lang_update_queries[] = PT_UpdateLangs($value, 'public_domain', 'Public Domain');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stock_videos', 'Stock Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'min_price', 'Min Price');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_price', 'Max Price');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
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
                     <h2 class="light">Update to v1.9 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                                <li>[Added] the ability to restrict rights of certain user from uploading / importing a video. </li>
                               <li>[Added] cronjob to remove videos from site that are already removed from YouTube. (/deleted_youtube.php)</li>
                               <li>[Added] new video player (cloudinary).</li>
                               <li>[Added] agora live stream system. </li>
                               <li>[Added] only paid users could stream, free or only admin could.</li>
                               <li>[Added] Paystack, Iyzipay, Paysera, Razorpay and cashfree payment methods.</li>
                               <li>[Added] stock video section (Add royality free, video with license & require membership to download)</li>
                               <li>[Added] IMA vast ads support for Google video ads (new player is only supported) </li>
                               <li>[Added] ability to choose custom categories to appear on homepage. </li>
                               <li>[Added] ability to pay per view feature for publisher. </li>
                               <li>[Added] ability to re-arrange videos in playlist. </li>
                               <li>[Added] ability to set articles as featured on homepage. </li>
                               <li>[Added] point system, users can earn points by doing several activities in the site. </li>
                               <li>[Added] sticky video player (on scroll).</li>
                               <li>[Fixed] Important security bug. </li>
                               <li>[Fixed] 5+ important bugs. </li>
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
                           <p>Congratulations, you have successfully updated your site. Thanks for choosing PlayTube.</p>
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
    "UPDATE `config` SET `value` = '1.9' WHERE `name` = 'version';",
    "ALTER TABLE `users` ADD `suspend_upload` INT(11) NOT NULL DEFAULT '0' AFTER `total_ads`, ADD `suspend_import` INT(11) NOT NULL DEFAULT '0' AFTER `suspend_upload`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'live_video', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'live_video_save', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'agora_live_video', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'agora_app_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'agora_customer_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'agora_customer_certificate', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_s3_2', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'bucket_name_2', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_s3_key_2', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'amazone_s3_s_key_2', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'region_2', 'eu-west-1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'who_use_live', 'all');",
    "ALTER TABLE `videos` ADD `stream_name` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `rent_price`;",
    "ALTER TABLE `videos` ADD `live_time` INT(50) NOT NULL DEFAULT '0' AFTER `stream_name`;",
    "ALTER TABLE `videos` ADD `live_ended` INT(11) NOT NULL DEFAULT '0' AFTER `live_time`;",
    "ALTER TABLE `videos` ADD `agora_resource_id` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `live_ended`;",
    "ALTER TABLE `videos` ADD `agora_sid` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `agora_resource_id`;",
    "CREATE TABLE `live_sub_users` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL DEFAULT '0', `post_id` int(11) NOT NULL DEFAULT '0', `is_watching` int(11) NOT NULL DEFAULT '0', `time` int(50) NOT NULL DEFAULT '0', PRIMARY KEY (`id`), KEY `time` (`time`), KEY `is_watching` (`is_watching`), KEY `post_id` (`post_id`), KEY `user_id` (`user_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paystack_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paystack_secret_key', '');",
    "ALTER TABLE `users` ADD `paystack_ref` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `suspend_import`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_mode', 'sandBox');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_client_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'cashfree_secret_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'razorpay_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'razorpay_key_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'razorpay_key_secret', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paysera_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paysera_mode', '1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paysera_project_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paysera_sign_password', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_mode', '1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_secret_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_name', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_surname', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_gsm_number', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_buyer_email', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_identity_number', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_city', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_address', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_country', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'iyzipay_zip', '');",
    "ALTER TABLE `users` ADD `ConversationId` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `paystack_ref`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'fav_category', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'show_articles', 'on');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'sticky_video', 'on');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'point_level_system', '1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'point_allow_withdrawal', '0');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'dollar_to_point_cost', '100');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'likes_point', '5');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'dislikes_point', '2');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'watching_point', '2');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'free_day_limit', '1000');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'pro_day_limit', '2000');",
    "ALTER TABLE `users` ADD `point_day_expire` INT(50) NOT NULL DEFAULT '0' AFTER `ConversationId`;",
    "ALTER TABLE `users` ADD `points` FLOAT(11) UNSIGNED NOT NULL DEFAULT '0' AFTER `point_day_expire`, ADD `daily_points` INT(11) NOT NULL DEFAULT '0' AFTER `points`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'upload_point', '20');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'stock_videos', 'on');",
    "ALTER TABLE `videos` ADD `license` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `agora_sid`;",
    "ALTER TABLE `videos` ADD `is_stock` INT(11) NOT NULL DEFAULT '0' AFTER `license`;",
    "ALTER TABLE `videos` CHANGE `sell_video` `sell_video` FLOAT(11) UNSIGNED NOT NULL DEFAULT '0';",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'comments_point', '10');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'suspend_upload');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'suspend_import');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'live');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'end_live');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'go_live');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'offline');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'stream_has_ended');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'was_live');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'joined_live_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'left_live_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'started_live_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'live_videos');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'paystack');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'cashfree');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'razorpay');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'paysera');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'iyzipay');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'move_balance_to_wallet');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'more_than_balance');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_balance_to_move');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'points');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'comment_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'like_video_point');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'dislike_video_point');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_video_point');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'watch_video_point');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_type');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'stock_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'movie');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'license_type');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rights_managed_license');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'editorial_use_license');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'royalty_free_license');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'royalty_free_extended_license');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'creative_commons_license');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'public_domain');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'stock_videos');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'min_price');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'max_price');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'stream_has_ended');",
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
            }, 1500);
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