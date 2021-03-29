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
            $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'الإيجارات');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'مؤجر');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'انقضاء');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'دفع');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'أفلام مستأجرة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'مقاطع الفيديو المستأجرة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'هذا الفيديو غير متاح ، يجب عليك استئجار الفيديو لمشاهدته.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'سيتوقف عرض إعلاناتك بمجرد وصولك إلى هذا المبلغ.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', '');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'اختر الفئات التي ترغب في رؤيتها على صفحتك الرئيسية.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'علق على نشاطك.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'لا توجد أنشطة للعرض');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'هل أنت متأكد أنك تريد حذف هذا النشاط؟ لا يمكن التراجع عن هذا الإجراء.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'تم تحديث مشاركتك بنجاح.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'تحرير النشاط');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'لم يعجبك نشاطك');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'اعجبني نشاطك');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'أنشطة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'لم يتم العثور على أنشطة في الوقت الحالي.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'إنشاء مشاركة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'إنشاء منشور جديد');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'صورة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'اكتب رسالة...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'تم إنشاء مشاركتك بنجاح.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'أحدث الأنشطة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'الحد الأقصى لحملتك الإعلانية');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'تم إرسال الإشعار الخاص بك بنجاح');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'إجمالي الإنفاق الإنفاق الحد');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'إضافة مقطع فيديو جديد إلى قائمة التشغيل الخاصة بهم');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'الفئة المفضلة');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'ألغيت اشتراكك في قائمة التشغيل');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'مشترك في قائمة التشغيل الخاصة بك');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'اشترك للحصول على الإخطارات');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'مشترك في إخطارات قائمة التشغيل');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'سعر الايجار');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'يجب أن يكون سعر إيجار الفيديو رقميًا وأكبر من');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'سعر إيجار الفيديو هذا هو:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'استأجر الفيديو الخاص بك');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'فترة الإيجار ستنتهي في');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'الرجاء تسجيل الدخول لمشاهدة هذا الفيديو');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Rentals');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'verhuurd');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'verstrijken');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Betaald');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Gehuurde films');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Gehuurde video&#39;s');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'Deze video is niet beschikbaar, je moet de video huren om hem te bekijken.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', '');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'heeft gereageerd op je activiteit.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Kies welke categorieën u op uw startpagina wilt zien.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'heeft gereageerd op je activiteit.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'Geen activiteiten om te bekijken');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'Weet u zeker dat u deze activiteit wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Uw bericht is succesvol bijgewerkt.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Activiteit bewerken');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'vond je activiteit niet leuk');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'vond je activiteit leuk');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'Activiteiten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'Momenteel geen activiteiten gevonden.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Maak bericht');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Nieuw bericht maken');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Beeld');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Schrijf een bericht...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Uw bericht is succesvol aangemaakt.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Meest recente activiteiten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Maximumlimiet voor uw advertentiecampagne');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Uw melding is succesvol verzonden');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Totale uitgavenlimiet voor advertenties');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'heeft een nieuwe video toegevoegd aan hun afspeellijst');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Favoriete categorie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'afgemeld bij uw afspeellijst');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'geabonneerd op je afspeellijst');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Meld u aan voor meldingen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Geabonneerd op meldingen voor afspeellijsten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Huurprijs');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'De huurprijs van de video moet numeriek zijn en groter dan');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'Deze video huurprijs is:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'je video gehuurd');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'Huurperiode eindigt om');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Log in om deze video te bekijken');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Les locations');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'Loué');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'Expiration');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Payé');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Films loués');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Vidéos louées');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'Cette vidéo n&#39;est pas disponible, vous devez louer la vidéo pour la regarder.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Vos annonces ne seront plus diffusées une fois ce montant atteint.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'a commenté votre activité.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Choisissez les catégories que vous souhaitez voir sur votre page d&#39;accueil.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'a commenté votre activité.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'Aucune activité à voir');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'Voulez-vous vraiment supprimer cette activité? Cette action ne peut pas être annulée.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Votre message a été mis à jour avec succès.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Modifier l&#39;activité');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'n&#39;a pas aimé votre activité');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'aimé votre activité');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'Activités');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'Aucune activité trouvée pour l&#39;instant.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Créer une publication');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Créer un nouveau message');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Image');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Écrire un message...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Votre message a été créé avec succès.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Activités les plus récentes');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Limite maximale pour votre campagne d&#39;annonces');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Votre notification a bien été envoyée');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Limite totale des dépenses publicitaires');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'a ajouté une nouvelle vidéo à sa playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Catégorie préférée');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'désabonné de votre playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'abonné à votre playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Abonnez-vous aux notifications');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Abonné aux notifications de playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Prix ​​de location');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'Le prix de location de la vidéo doit être numérique et supérieur à');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'Le prix de location de cette vidéo est:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'loué votre vidéo');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'La période de location se terminera à');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Veuillez vous connecter pour regarder cette vidéo');
        } else if ($value == 'german') {
           $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Vermietungen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'Gemietet');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'Ablauf');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Bezahlt');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Leihfilme');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Gemietete Videos');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'Dieses Video ist nicht verfügbar. Sie müssen das Video ausleihen, um es anzusehen.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Ihre Anzeigen werden nicht mehr geschaltet, sobald Sie diesen Betrag erreicht haben.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'hat Ihre Aktivität kommentiert.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Wählen Sie aus, welche Kategorien Sie auf Ihrer Homepage sehen möchten.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'hat Ihre Aktivität kommentiert.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'Keine Aktivitäten zum Anzeigen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'Möchten Sie diese Aktivität wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Ihr Beitrag wurde erfolgreich aktualisiert.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Aktivität bearbeiten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'mochte deine Aktivität nicht');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'mochte Ihre Aktivität');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'Aktivitäten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'Derzeit wurden keine Aktivitäten gefunden.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Beitrag erstellen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Neuen Beitrag erstellen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Bild');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Eine Nachricht schreiben...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Ihr Beitrag wurde erfolgreich erstellt.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Letzte Aktivitäten');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Maximales Limit für Ihre Werbekampagne');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Ihre Benachrichtigung wurde erfolgreich gesendet');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', '');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'hat ein neues Video zu ihrer Wiedergabeliste hinzugefügt');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Lieblingskategorie');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'von Ihrer Wiedergabeliste abgemeldet');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'Abonniert Ihre Wiedergabeliste');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Benachrichtigungen abonnieren');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Playlist-Benachrichtigungen abonniert');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Mietpreis');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'Der Videomietpreis sollte numerisch und höher als sein');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'Dieser Videomietpreis ist:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'habe dein Video ausgeliehen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'Die Mietzeit endet um');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Bitte loggen Sie sich ein, um dieses Video anzusehen');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Аренда');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'арендованный');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'истечение');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'оплаченный');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Арендованные фильмы');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Арендованные видео');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'Это видео не доступно, вы должны арендовать видео, чтобы посмотреть его.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Ваши объявления прекратят показ, как только вы достигнете этой суммы.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'прокомментировал вашу деятельность.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Выберите, какие категории вы хотели бы видеть на своей домашней странице.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'прокомментировал вашу деятельность.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'Нет действий для просмотра');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', '');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Ваш пост был успешно обновлен.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Редактировать активность');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'не понравилась ваша деятельность');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'понравилась твоя деятельность');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'мероприятия');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'На данный момент никаких действий не найдено.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Создать сообщение');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Создать новый пост');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Образ');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Напишите сообщение...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Ваш пост был успешно создан.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Самые последние мероприятия');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Максимальный лимит для вашей рекламной кампании');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Ваше уведомление было успешно отправлено');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Общий лимит расходов на рекламу');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'добавил новое видео в свой плейлист');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Любимая категория');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', '');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'подписался на ваш плейлист');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Подписаться на уведомления');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Подписка на уведомления о плейлисте');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Стоимость аренды');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'Стоимость аренды видео должна быть числовой и превышать');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'Стоимость аренды этого видео:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'арендовал ваше видео');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'Срок аренды заканчивается');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Пожалуйста, войдите, чтобы посмотреть это видео');
        } else if ($value == 'spanish') {
           $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Alquileres');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'Alquilado');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'Expiración');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Pagado');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Películas alquiladas');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Videos alquilados');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'Este video no está disponible, debe alquilar el video para verlo.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Sus anuncios dejarán de publicarse una vez que alcance esta cantidad.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'comentó tu actividad.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Elija qué categorías le gustaría ver en su página de inicio.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'comentó tu actividad.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'No hay actividades para ver');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', '¿Estás seguro de que deseas eliminar esta actividad? Esta acción no se puede deshacer.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Su publicación ha sido actualizada con éxito.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Editar actividad');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'no me gustó tu actividad');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'me gustó tu actividad');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'Ocupaciones');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'No se han encontrado actividades por ahora.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Crear publicación');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Crear nueva publicación');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Imagen');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Escribe un mensaje...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Tu publicación ha sido creada con éxito.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Actividades mas recientes');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Límite máximo para su campaña publicitaria');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Su notificación ha sido enviada exitosamente');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Límite de gasto total en anuncios');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'agregó un nuevo video a su lista de reproducción');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Categoría favorita');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'darse de baja de su lista de reproducción');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'suscrito a tu lista de reproducción');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Suscríbase para recibir notificaciones');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Suscrito a notificaciones de listas de reproducción');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Precio de alquiler');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'El precio del alquiler del video debe ser numérico y mayor que');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'Este precio de alquiler de video es:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'alquiló su video');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'El período de alquiler finalizará a las');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Inicia sesión para ver este video');
        } else if ($value == 'turkish') {
           $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'kiralama');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'kiralanmış');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'vade');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Ücretli');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Kiralanan Filmler');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Kiralanan Videolar');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'Bu video kullanılamıyor, videoyu izlemek için kiralamanız gerekiyor.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Bu miktara ulaştığınızda reklamlarınızın yayını durdurulur.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'etkinliğiniz hakkında yorum yaptı.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Ana sayfanızda görmek istediğiniz kategorileri seçin.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'etkinliğiniz hakkında yorum yaptı.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'Görüntülenecek etkinlik yok');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'Bu etkinliği silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Yayınınız başarıyla güncellendi.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Etkinliği Düzenle');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'aktiviteni beğenmedim');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'aktiviteni beğendim');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'faaliyetler');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'Şimdilik etkinlik bulunamadı.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Gönderi Oluştur');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Yeni yayın oluştur');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'görüntü');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Bir mesaj yaz...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Yayınınız başarıyla oluşturuldu.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'En son etkinlikler');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Reklam kampanyanız için maksimum sınır');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Bildiriminiz başarıyla gönderildi');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Toplam reklam harcama sınırı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'oynatma listesine yeni bir video ekledi');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Favori kategori');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'oynatma listesinden çıkıldı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'oynatma listenize abone oldu');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Bildirimler için Abone Olun');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Oynatma Listesi Bildirimlerine Abone Oldu');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Kira bedeli');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'Video kira fiyatı sayısal olmalı ve daha yüksek olmalıdır');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'Bu video kira fiyatı:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'videonuzu kiraladı');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'Kira süresi şu tarihte sona erecek:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Bu videoyu izlemek için lütfen giriş yapın');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Rentals');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'Rented');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'Expiry');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Paid');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Rented Movies');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Rented Videos');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'This video is not available, you have to rent the video to watch it.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Your ads will stop running once you reach this amount.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'commented on your activity.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Choose which categories you would like to see on your home page.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'commented on your activity.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'No activities to view');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'Are you sure you want to delete this activity? This action can\'t be undo.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Your post has been successfully updated.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Edit Activity');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'disliked your activity');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'liked your activity');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'Activities');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'No activities found for now.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Create Post');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Create new post');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Image');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Write a message...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Your post has been successfully created.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Most recent activities');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Max limit for your ads campaign');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Your notification has been successfully sent');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Total ads spending limit');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'added a new video to their playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Favourite category');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'unsubscribed from your playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'subscribed to your playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Subscribe for Notifications');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Subscribed to Playlist Notifications');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Rent price');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'The video rent price should be numeric and greater than');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'This video rent price is:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'rented your video');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'Rent period will end at');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Please login to watch this video');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'rentals', 'Rentals');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented', 'Rented');
    $lang_update_queries[] = PT_UpdateLangs($value, 'expiry', 'Expiry');
    $lang_update_queries[] = PT_UpdateLangs($value, 'paid', 'Paid');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_movies', 'Rented Movies');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rented_videos', 'Rented Videos');
    $lang_update_queries[] = PT_UpdateLangs($value, 'you_have_to_rent_video', 'This video is not available, you have to rent the video to watch it.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'your_ads_will_stop', 'Your ads will stop running once you reach this amount.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_actvity', 'commented on your activity.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'choose_which_categories', 'Choose which categories you would like to see on your home page.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'commented_ur_activity', 'commented on your activity.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_more_activity', 'No activities to view');
    $lang_update_queries[] = PT_UpdateLangs($value, 'delete_activity_confirmation', 'Are you sure you want to delete this activity? This action can\'t be undo.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_edited', 'Your post has been successfully updated.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'edit_activity', 'Edit Activity');
    $lang_update_queries[] = PT_UpdateLangs($value, 'disliked_ur_activity', 'disliked your activity');
    $lang_update_queries[] = PT_UpdateLangs($value, 'liked_ur_activity', 'liked your activity');
    $lang_update_queries[] = PT_UpdateLangs($value, 'activities', 'Activities');
    $lang_update_queries[] = PT_UpdateLangs($value, 'no_activities_found_for_now', 'No activities found for now.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_post', 'Create Post');
    $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_post', 'Create new post');
    $lang_update_queries[] = PT_UpdateLangs($value, 'image', 'Image');
    $lang_update_queries[] = PT_UpdateLangs($value, 'write_message', 'Write a message...');
    $lang_update_queries[] = PT_UpdateLangs($value, 'post_created', 'Your post has been successfully created.');
    $lang_update_queries[] = PT_UpdateLangs($value, 'recent_activities', 'Most recent activities');
    $lang_update_queries[] = PT_UpdateLangs($value, 'total_ads_limit', 'Max limit for your ads campaign');
    $lang_update_queries[] = PT_UpdateLangs($value, 'notification_sent', 'Your notification has been successfully sent');
    $lang_update_queries[] = PT_UpdateLangs($value, 'ad_lifetime_limit', 'Total ads spending limit');
    $lang_update_queries[] = PT_UpdateLangs($value, 'added_video_playlist', 'added a new video to their playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'fav_category', 'Favourite category');
    $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribed_u_playlist', 'unsubscribed from your playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_u_playlist', 'subscribed to your playlist');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_playlist', 'Subscribe for Notifications');
    $lang_update_queries[] = PT_UpdateLangs($value, 'subscribed_to_playlist', 'Subscribed to Playlist Notifications');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Rent price');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price_error', 'The video rent price should be numeric and greater than');
    $lang_update_queries[] = PT_UpdateLangs($value, 'video_rent_price', 'This video rent price is:');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_to_see', 'rented your video');
    $lang_update_queries[] = PT_UpdateLangs($value, 'rent_time_will', 'Rent period will end at');
    $lang_update_queries[] = PT_UpdateLangs($value, 'please_login_to_see_video', 'Please login to watch this video');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }
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
                     <h2 class="light">Update to v1.8 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                               <li>[Added] ability to rent a video system.</li>
                               <li>[Added] ability to set only admin can upload videos from admin panel. [enable/disable]</li>
                               <li>[Added] emojie support for video description. </li>
                               <li>[Added] ability to subscribe to a playlist only so if playlist gets updated user shall get a notification. [enable/disable] </li>
                               <li>[Added] ability for users to set in the settings from which categories they want to see videos on homepage. </li>
                               <li>[Added] ability to set daily/lifetime budget for ads. </li>
                               <li>[Added] require subcription before being able to access site. [enable/disable]</li>
                               <li>[Added] mass notifications system.</li>
                               <li>[Added] register by invitation code system. </li>
                               <li>[Added] auto delete system, delete videos from date to date, type and size. </li>
                               <li>[Added] auto subscribe system. </li>
                               <li>[Added] ability to reposition cover from profile page. </li>
                               <li>[Added] activities system, user now can post status. </li>
                               <li>[Added] 12+ more APIs. </li>
                               <li>[Removed] .mp4 etc when video get uploaded from title. </li>
                               <li>[Updated] Google Login API. </li>
                               <li>[Improved] Design on some senctions. </li>
                               <li>[Fixed] 45+ important bugs. </li>
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
    "UPDATE `config` SET `value` = '1.8' WHERE `name` = 'version';",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'require_login', 'off');",
    "ALTER TABLE `videos` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'who_upload', 'all');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'rent_videos_system', 'off');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'admin_com_rent_videos', '0');",
    "CREATE TABLE `uploaded_videos` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL DEFAULT '0',`path` varchar(300) NOT NULL DEFAULT '',`time` int(50) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'playlist_subscribe', 'on');",
    "CREATE TABLE `playlist_subscribers` (`id` int(11) NOT NULL AUTO_INCREMENT,`list_id` varchar(50) NOT NULL DEFAULT '',`subscriber_id` int(11) NOT NULL DEFAULT '0',`time` int(50) NOT NULL DEFAULT '0',`active` int(11) NOT NULL DEFAULT '1',PRIMARY KEY (`id`),KEY `user_id` (`list_id`),KEY `subscriber_id` (`subscriber_id`),KEY `active` (`active`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `notifications` CHANGE `type` `type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",
    "ALTER TABLE `users` ADD `fav_category` VARCHAR(400) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `new_email`;",
    "ALTER TABLE `user_ads` ADD `lifetime_limit` FLOAT(11) NOT NULL DEFAULT '0' AFTER `day_spend`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'require_subcription', 'off');",
    "ALTER TABLE `notifications` ADD `full_link` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `sent_push`;",
    "CREATE TABLE `admininvitations` (`id` int(11) NOT NULL AUTO_INCREMENT,`code` varchar(300) NOT NULL DEFAULT '0',`posted` varchar(50) NOT NULL DEFAULT '0',PRIMARY KEY (`id`),KEY `code` (`code`(255))) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `admininvitations` ADD `status` INT(11) NOT NULL DEFAULT '0' AFTER `posted`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'auto_subscribe', '');",
    "ALTER TABLE `users` ADD `total_ads` FLOAT(11) NOT NULL DEFAULT '0' AFTER `fav_category`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'post_system', 'on');",
    "ALTER TABLE `likes_dislikes` ADD `activity_id` INT(11) NOT NULL DEFAULT '0' AFTER `post_id`;",
    "ALTER TABLE `comments` ADD `activity_id` INT(11) NOT NULL DEFAULT '0' AFTER `post_id`;",
    "CREATE TABLE `activities` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL DEFAULT '0',`text` varchar(300) NOT NULL DEFAULT '',`image` varchar(300) NOT NULL DEFAULT '',`time` varchar(50) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "UPDATE `langs` SET `english` = 'Please {{login}} to watch this video' WHERE `langs`.`lang_key` = 'please_login_to_see_video';",
    "ALTER TABLE `users` CHANGE `wallet` `wallet` FLOAT NOT NULL DEFAULT '0';",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rentals');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rented');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'expiry');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'paid');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rented_movies');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rented_videos');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'you_have_to_rent_video');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'your_ads_will_stop');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'commented_ur_actvity');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'choose_which_categories');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'commented_ur_activity');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_more_activity');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'delete_activity_confirmation');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'post_edited');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'edit_activity');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'disliked_ur_activity');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'liked_ur_activity');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'activities');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_activities_found_for_now');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'create_post');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'create_new_post');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'image');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'write_message');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'post_created');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'recent_activities');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'total_ads_limit');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'notification_sent');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ad_lifetime_limit');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'added_video_playlist');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'fav_category');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'unsubscribed_u_playlist');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscribed_u_playlist');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscribe_to_playlist');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscribed_to_playlist');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent_price');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_rent_price_error');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_rent_price');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent_to_see');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent_time_will');",
"INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'please_login_to_see_video');",
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