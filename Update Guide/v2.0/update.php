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
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'معلوماتي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'عمر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'الرجاء اختيار المعلومات التي ترغب في تنزيلها');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'نوع العضو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'عضو محترف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'عضو مجاني');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'غوغل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'توليد ملف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'تحميل الملف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'ملفك جاهز للتنزيل!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'تحميل مقطورة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'مقطورة فيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'تقييد الفيديو من التضمين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'كود تتبع جوجل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'معرف تتبع جوجل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'الدردشة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'السماح بالمحادثة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'حظر الدردشة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'النشرة الإخبارية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'المقرر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'تاريخ النشر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'تنسيق التاريخ غير صحيح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'أضف نصًا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'نص الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'يجب أن يكون العنوان بين 10/200');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'مدة الفيديو غير صالحة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'اللون');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'لون الخلفية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'نص');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'أعلى اليسار');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'اعلى اليمين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'أسفل اليسار');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'أسفل اليمين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'مركز');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'الرجاء تحديد جزء آخر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'جزء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'آسف لا يمكنك توليد أكثر من 5 بطاقات.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'تم نشر البطاقة بنجاح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'إضافة بطاقة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'يمكنك تتبع ملفك الشخصي ومقاطع الفيديو الخاصة بك باستخدام Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(المنطقة الزمنية UTC)');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'Mijn informatie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Leeftijd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Kies welke informatie u wilt downloaden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Type lid');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Pro-lid');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'gratis lid');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Genereer bestand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Download bestand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Je bestand is klaar om te downloaden!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Trailer uploaden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Video-trailer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Voorkom dat video wordt ingesloten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Google-trackingcode');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Google-tracking-ID');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Chatten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Sta chating toe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Blokkeer chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Nieuwsbrief');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Gepland');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Publicatie datum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Verkeerde datumnotatie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Voeg tekst toe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Videotekst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Titel moet tussen 10/200 liggen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Ongeldige videoduur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Kleur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Achtergrond kleur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Tekst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Linksboven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'Rechtsboven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Linksonder');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Rechts onder');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Centrum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Selecteer een ander onderdeel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Een deel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Sorry, je kunt niet meer dan 5 kaarten genereren.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'De kaart is met succes gepubliceerd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Voeg een kaart toe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'U kunt uw eigen profiel en video\'s volgen met Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(UTC-tijdzone)');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'Mon information');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Âge');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Veuillez choisir les informations que vous souhaitez télécharger');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Type de membre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Membre Pro');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'Membre gratuit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Générer un fichier');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Télécharger un fichier');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Votre fichier est prêt à être téléchargé!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Télécharger la bande-annonce');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Bande-annonce vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Interdire l\'intégration de la vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Code de suivi Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Identifiant de suivi Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Bavardage');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Autoriser le chat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Bloquer le chat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Bulletin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Programmé');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Date de publication');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Format de date incorrect');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Ajouter du texte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Texte vidéo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Le titre doit être compris entre 10/200');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Durée de la vidéo non valide');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Couleur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Couleur de l\'arrière plan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Texte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'En haut à gauche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'En haut à droite');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'En bas à gauche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'En bas à droite');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Centre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Veuillez sélectionner une autre pièce');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Partie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Désolé, vous ne pouvez pas générer plus de 5 cartes.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'La carte a été publiée avec succès');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Ajouter une carte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'Vous pouvez suivre votre propre profil et vos vidéos avec Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(Fuseau horaire UTC)');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'Meine Information');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Alter');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Bitte wählen Sie aus, welche Informationen Sie herunterladen möchten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Mitgliedertyp');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Pro Mitglied');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'Freies Mitglied');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Datei generieren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Download-Datei');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Ihre Datei kann heruntergeladen werden!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Trailer hochladen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Video Trailer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Beschränken Sie das Einbetten von Videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Google Tracking Code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Google Tracking-ID');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Chatten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Chating zulassen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Block Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Newsletter');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Geplant');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Veröffentlichungsdatum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Falsches Datumsformat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Text hinzufügen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Videotext');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Der Titel muss zwischen 10/200 liegen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Ungültige Videodauer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Farbe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Hintergrundfarbe');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Oben links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'Oben rechts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Unten links');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Unten rechts');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Center');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Bitte wählen Sie ein anderes Teil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Teil');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Leider können Sie nicht mehr als 5 Karten generieren.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'Die Karte wurde erfolgreich veröffentlicht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Karte hinzufügen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'Mit Google Analytics können Sie Ihr eigenes Profil und Ihre eigenen Videos verfolgen!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(UTC-Zeitzone)');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'Моя информация');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Возраст');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Пожалуйста, выберите, какую информацию вы хотите скачать');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Тип участника');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Член профи');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'Бесплатный член');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Создать файл');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Загрузка файла');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Ваш файл готов к загрузке!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Загрузить трейлер');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Видео трейлер');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Ограничить встраивание видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Код отслеживания Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Идентификатор отслеживания Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'В чате');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Разрешить чат');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Блокировать чат');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Новостная рассылка');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'по расписанию');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Дата публикации');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Неверный формат даты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Добавить текст');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Видео текст');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Название должно быть между 10/200.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Неверная продолжительность видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Цвет');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Фоновый цвет');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Текст');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Верхний левый');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'В правом верхнем углу');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Нижний левый');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Внизу справа');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Центр');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Пожалуйста, выберите другую часть');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Часть');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Извините, вы не можете сгенерировать более 5 карт.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'Карта успешно опубликована');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Добавить карту');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'Вы можете отслеживать свой профиль и видео с помощью Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(Часовой пояс UTC)');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'Mi informacion');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Edad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Elija qué información desea descargar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Tipo de miembro');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Miembro Pro');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'miembro gratuito');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Generar archivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Descargar archivo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', '¡Su archivo está listo para descargar!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Subir tráiler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Trailer de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Restringir la inserción de videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Código de seguimiento de Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'ID de seguimiento de Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Charlando');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Permitir chatear');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Chatear en bloque');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Boletin informativo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Programado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Fecha de publicación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Formato de fecha incorrecto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Añadir texto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Texto de video');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'El título debe estar entre 10/200');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Duración de video no válida');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Color');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Color de fondo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Texto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Arriba a la izquierda');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'Parte superior derecha');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Abajo a la izquierda');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Abajo a la derecha');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Centrar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Seleccione otra parte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Parte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Lo sentimos, no puede generar más de 5 tarjetas.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'La tarjeta se ha publicado con éxito');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Agregar tarjeta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', '¡Puede rastrear su propio perfil y videos con Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(Zona horaria UTC)');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'Benim bilgim');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Yaş');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Lütfen indirmek istediğiniz bilgileri seçin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Üye Tipi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Pro Üye');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'Ücretsiz Üye');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Dosya oluştur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Dosyayı indir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Dosyanız indirilmeye hazır!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Fragmanı Yükle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Video Fragmanı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Videonun Gömülmesini Kısıtla');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Google İzleme Kodu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Google İzleme Kimliği');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Sohbet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Sohbet etmeye izin ver');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Sohbet Etmeyi Engelle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Haber bülteni');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Planlandı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Yayın tarihi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Yanlış tarih biçimi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Yazı ekle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Video Metni');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Başlık 10/200 arasında olmalıdır');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Geçersiz video süresi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Renk');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Arka plan rengi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Metin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Sol üst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'Sağ üst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Sol alt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Sağ alt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Merkez');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Lütfen başka bir bölüm seçin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Bölüm');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Üzgünüz, 5\'ten fazla kart üretemezsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'Kart başarıyla yayınlandı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Kart ekle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'Google Analytics ile kendi profilinizi ve videolarınızı takip edebilirsiniz!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(UTC saat dilimi)');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'My Information');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Age');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Please choose which information you would like to download');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Member Type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Pro Member');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'Free Member');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Generate file');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Download File');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Your file is ready to download!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Upload Trailer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Video Trailer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Restrict Video From Embedding');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Google Tracking Code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Google Tracking Id');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Allow Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Block Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Newsletter');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Scheduled');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Publication Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Wrong date format');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Add Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Video Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Title must be between 10/200');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Invalid video duration');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Color');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Background Color');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Top Left');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'Top Right');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Bottom Left');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Bottom Right');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Center');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Please select another part');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Part');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Sorry you can`t generate more than 5 cards.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'The card has been published successfully');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Add Card');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'You can track your own profile and videos with Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(UTC timezone)');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_information', 'My Information');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age', 'Age');
            $lang_update_queries[] = PT_UpdateLangs($value, 'to_download', 'Please choose which information you would like to download');
            $lang_update_queries[] = PT_UpdateLangs($value, 'member_type', 'Member Type');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pro_member', 'Pro Member');
            $lang_update_queries[] = PT_UpdateLangs($value, 'free_member', 'Free Member');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google', 'Google');
            $lang_update_queries[] = PT_UpdateLangs($value, 'generate_file', 'Generate file');
            $lang_update_queries[] = PT_UpdateLangs($value, 'download_file', 'Download File');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_ready', 'Your file is ready to download!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upload_trailer', 'Upload Trailer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_trailer', 'Video Trailer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'restrict_embedding', 'Restrict Video From Embedding');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_code', 'Google Tracking Code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'google_tracking_id', 'Google Tracking Id');
            $lang_update_queries[] = PT_UpdateLangs($value, 'chating', 'Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'allow_chating', 'Allow Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block_chating', 'Block Chating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'newsletters', 'Newsletter');
            $lang_update_queries[] = PT_UpdateLangs($value, 'scheduled', 'Scheduled');
            $lang_update_queries[] = PT_UpdateLangs($value, 'publication_date', 'Publication Date');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_date_format', 'Wrong date format');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payu', 'PayU');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_text', 'Add Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_text', 'Video Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_title', 'Title must be between 10/200');
            $lang_update_queries[] = PT_UpdateLangs($value, 'invalid_video_duration', 'Invalid video duration');
            $lang_update_queries[] = PT_UpdateLangs($value, 'color', 'Color');
            $lang_update_queries[] = PT_UpdateLangs($value, 'background_color', 'Background Color');
            $lang_update_queries[] = PT_UpdateLangs($value, 'text', 'Text');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_left', 'Top Left');
            $lang_update_queries[] = PT_UpdateLangs($value, 'top_right', 'Top Right');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_left', 'Bottom Left');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bottom_right', 'Bottom Right');
            $lang_update_queries[] = PT_UpdateLangs($value, 'center', 'Center');
            $lang_update_queries[] = PT_UpdateLangs($value, 'please_select_another_part', 'Please select another part');
            $lang_update_queries[] = PT_UpdateLangs($value, 'part', 'Part');
            $lang_update_queries[] = PT_UpdateLangs($value, 'you_cant_make_more', 'Sorry you can`t generate more than 5 cards.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_published', 'The card has been published successfully');
            $lang_update_queries[] = PT_UpdateLangs($value, 'add_card', 'Add Card');
            $lang_update_queries[] = PT_UpdateLangs($value, 'track_your_own_profile', 'You can track your own profile and videos with Google Analytics!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'utc_timezone', '(UTC timezone)');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }
    $users = $db->get(T_USERS);
    if (!empty($users)) {
        foreach ($users as $key => $user) {
            if (empty($user->time)) {
                $db->where('id', $user->id)->update(T_USERS, array(
                    'time' => strtotime($user->registered . '/01')
                ));
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
                     <h2 class="light">Update to v2.0 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                               <li>[Added] the ability to turn off chat on live steam. </li>
                               <li>[Added] new admin panel, v2 with many new features.</li>
                               <li>[Added] ability to add trailer with movie [enable/disable]. </li>
                               <li>[Added] ability to restrict a video from embeding while uploading [enable/disable].</li>
                               <li>[Added] pro users can have Google anaylytics on their channel [enable/disable].</li>
                               <li>[Added] ability to add texts/cards in specific part of the video. </li>
                               <li>[Added] see online users [admin panel] </li>
                               <li>[Added] notification for the admin when someone request withdrawal in admin panel, also notification for reports, verification requests and bank receipts.</li>
                               <li>[Added] new turkish payment gateway</li>
                               <li>[Added] scheduled upload videos in Privacy: Public, Private, Unlisted, Scheduled.</li>
                               <li>[Added] subscribe to newsletters. </li>
                               <li>[Added] the ability to download your own data from settings page. </li>
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
    "UPDATE `config` SET `value` = '2.0' WHERE `name` = 'version';",
    "ALTER TABLE `users` ADD `info_file` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `daily_points`;",
    "ALTER TABLE users ROW_FORMAT=DYNAMIC;",
    "ALTER TABLE `users` ADD `time` INT(11) NOT NULL DEFAULT '0' AFTER `registered`;",
    "ALTER TABLE `notifications` ADD `admin` INT(11) NOT NULL DEFAULT '0' AFTER `full_link`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'trailer_system', 'on');",
    "ALTER TABLE `videos` ADD `trailer` VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `is_stock`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'restrict_embedding_system', 'off');",
    "ALTER TABLE `videos` ADD `embedding` INT(11) NOT NULL DEFAULT '0' AFTER `trailer`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'pro_google', 'on');",
    "ALTER TABLE `users` ADD `google_tracking_code` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `info_file`;",
    "ALTER TABLE `videos` ADD `live_chating` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'on' AFTER `embedding`;",
    "ALTER TABLE `users` ADD `newsletters` INT(11) NOT NULL DEFAULT '0' AFTER `google_tracking_code`;",
    "ALTER TABLE `videos` ADD `publication_date` INT(50) NOT NULL DEFAULT '0' AFTER `live_chating`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_mode', '1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_merchant_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_secret_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_name', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_surname', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_gsm_number', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payu_buyer_email', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'video_text_system', 'off');",
    "CREATE TABLE `cards` ( `id` int(11) NOT NULL AUTO_INCREMENT, `video_id` int(11) NOT NULL DEFAULT '0', `title` varchar(300) NOT NULL DEFAULT '', `url` text, `duration` varchar(33) NOT NULL DEFAULT '00:00', `type` varchar(100) NOT NULL DEFAULT '', `time` int(11) NOT NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "ALTER TABLE `cards` ADD `user_id` INT(11) NOT NULL DEFAULT '0' AFTER `video_id`;",
    "ALTER TABLE `cards` ADD `color` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `duration`, ADD `background_color` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `color`;",
    "ALTER TABLE `cards` ADD `part` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `type`;",
    "ALTER TABLE `cards` ADD `ref_video` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`;",
    "ALTER TABLE `cards` ADD INDEX(`video_id`);",
    "ALTER TABLE `cards` ADD INDEX(`ref_video`);",
    "ALTER TABLE `cards` ADD INDEX(`type`);",
    "ALTER TABLE `cards` ADD INDEX(`part`);",
    "ALTER TABLE `notifications` ADD INDEX(`admin`);",
    "ALTER TABLE `cards` ADD INDEX(`user_id`);",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'my_information');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'age');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'to_download');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'member_type');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pro_member');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'free_member');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'google');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'generate_file');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'download_file');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'file_ready');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upload_trailer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_trailer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'restrict_embedding');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'google_tracking_code');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'google_tracking_id');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'chating');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'allow_chating');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'block_chating');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'newsletters');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'scheduled');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'publication_date');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'wrong_date_format');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'payu');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'add_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'invalid_title');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'invalid_video_duration');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'color');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'background_color');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'top_left');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'top_right');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'bottom_left');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'bottom_right');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'center');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_another_part');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'part');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'you_cant_make_more');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'card_published');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'add_card');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'track_your_own_profile');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'utc_timezone');",
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