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
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'خلق المادة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'إنشاء مقال جديد');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Descritpion');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'المقالة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'يجب أن يكون العنوان أكثر من 5 أحرف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'يجب أن يكون الوصف أكثر من 15 حرفًا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'ملف الصورة غير صالح ، يرجى تحديد صورة صالحة.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'فئة غير صالحة ، يرجى التحقق من التفاصيل الخاصة بك.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'شكرًا ، تم إرسال مقالك ، وهو قيد المراجعة ، يرجى التحقق مرة أخرى لاحقًا.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'مقالاتي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'هل أنت متأكد أنك تريد حذف هذه المقالة؟ لا يمكن التراجع عن هذا الإجراء');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'تحرير المادة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'أفلام');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'هل هو فيلم؟');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'نعم فعلا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'لا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'عنوان الفيلم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'نجوم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'مفصولة بفاصلة ،');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'منتج');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'إطلاق سراح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(بين 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'المدة الزمنية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'جودة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'تقييم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'سعر الإيجار (اتركه فارغًا لمقاطع الفيديو المجانية)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'أو يمكنك استئجاره لمدة 24 ساعة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'تأجير');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'سينتهي هذا الفيديو في');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'استئجار هذا الفيلم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'بالنسبة للأفلام ، يجب ألا يزيد حجم الغطاء عن 400 × 570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'لمشاهدة هذا الفيلم ، عليك شراءه.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'تحويل الأرباح إلى المحفظة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'قم بتحويل الأموال إلى المحفظة ، حتى تتمكن من استخدامها للإعلانات.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'بمجرد تحويل المبلغ ، لن تتمكن من سحبه.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'رصيدك هو {{balance}} ، لا يمكنك التحويل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'نقل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'تم تحويل رصيدك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'الحد الأقصى للمبلغ الذي يمكنك نقله هو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'أكثر نشاطا');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'لم يتم العثور على أفلام');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'ماذا تريد أن تشاهد؟');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'أكثر لمشاهدة! لمتابعة مشاهدة هذا الفيديو ، عليك شراءه.');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Maak een artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Maak een nieuw artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'descritpion');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'Het artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'De titel moet uit meer dan 5 tekens bestaan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'De beschrijving moet uit meer dan 15 tekens bestaan');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'Het beeldbestand is niet geldig, selecteer een geldige afbeelding.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Ongeldige categorie, controleer uw gegevens.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Bedankt, uw artikel is verzonden en het wordt beoordeeld. Kom later nog eens terug.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'Mijn artikelen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Weet je zeker dat je dit artikel wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Bewerk artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Films');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Is het een film?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Ja');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'Nee');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Film titel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Stars');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Gescheiden door komma,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Producent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Vrijlating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(Tussen 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'Looptijd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Kwaliteit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Beoordeling');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Huurprijs (laat leeg voor gratis video\'s)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Of u kunt het voor 24 uur huren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Huur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'Deze video verloopt om');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Huur deze film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'Voor films mag de omslag niet groter zijn dan 400x570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'Om deze film te bekijken, moet je hem kopen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Overdracht van inkomsten naar portemonnee');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Geld overboeken naar de portemonnee, zodat u ze voor advertenties kunt gebruiken.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Zodra het bedrag is overgemaakt, kunt u ze niet meer opnemen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Uw saldo is {{balance}}, u kunt niet overschrijven');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Overdracht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Je saldo is overgedragen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'Het maximale bedrag dat u kunt overboeken is');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Meest actief');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'Geen films gevonden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'Wat zou je willen zien?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'Meer om te zien! om deze video te blijven bekijken, moet je hem kopen.');
            
        } else if ($value == 'french') {
           $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Créer un article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Créer un nouvel article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Description');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'L\'article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'Le titre doit comporter plus de 5 caractères.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'La description doit comporter plus de 15 caractères.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'Le fichier image n\'est pas valide, veuillez sélectionner une image valide.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Catégorie non valide, veuillez vérifier vos coordonnées.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Merci, votre article a été soumis et il est en train d\'être revu, revenez plus tard.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'Mes articles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Êtes-vous sûr de vouloir supprimer cet article? Cette action ne peut pas être annulée');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Modifier l\'article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Films');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Est-ce un film?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Oui');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'Non');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Titre du film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Étoiles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Séparé par une virgule,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Producteur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Libération');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(Entre 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'Durée');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Qualité');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Évaluation');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Prix de location (Laissez vide pour les vidéos gratuites)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Ou vous pouvez le louer pour 24 heures');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Location');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'Cette vidéo expirera le');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Louez ce film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'Pour les films, la taille de la couverture ne doit pas dépasser 400x570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'Pour regarder ce film, vous devez l\'acheter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Transférer les revenus dans un portefeuille');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Transférez de l\'argent dans un portefeuille afin que vous puissiez les utiliser pour des publicités.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Une fois le montant transféré, vous ne pourrez plus les retirer.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Votre solde est {{balance}}, vous ne pouvez pas transférer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Transfert');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Votre solde a été transféré.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'Le montant maximum que vous pouvez transférer est de');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Le plus actif');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'Aucun film trouvé');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'Que voudriez-vous regarder?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'Plus à regarder! pour continuer à regarder cette vidéo, vous devez l\'acheter.');

        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Artikel erstellen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Neuen Artikel erstellen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Beschreibung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'Der Artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'Der Titel sollte aus mehr als 5 Zeichen bestehen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'Die Beschreibung sollte mehr als 15 Zeichen umfassen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'Die Bilddatei ist nicht gültig. Bitte wählen Sie ein gültiges Bild aus.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Ungültige Kategorie. Bitte überprüfen Sie Ihre Angaben.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Vielen Dank, Ihr Artikel wurde eingereicht, und er wird überprüft. Bitte versuchen Sie es später erneut.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'Meine Artikel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Möchten Sie diesen Artikel wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Artikel bearbeiten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Filme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Ist es ein Film?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Ja');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'Nein');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Filmtitel');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Sterne');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Durch Komma getrennt,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Hersteller');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Veröffentlichung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(Zwischen 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'Dauer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Qualität');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Bewertung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Mietpreis (für kostenlose Videos leer lassen)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Oder Sie können es für 24 Stunden mieten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Miete');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'Dieses Video läuft am um');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Mieten Sie diesen Film');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'Bei Filmen sollte die Covergröße nicht größer als 400 x 570 sein.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'Um diesen Film anzusehen, müssen Sie ihn kaufen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Übertragen Sie die Einnahmen in die Brieftasche');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Überweisen Sie Geld in die Brieftasche, damit Sie sie für Anzeigen verwenden können.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Sobald der Betrag überwiesen ist, können Sie ihn nicht mehr abheben.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Ihr Guthaben ist {{Guthaben}}. Sie können nicht übertragen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Ihr Guthaben wurde übertragen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'Der Höchstbetrag, den Sie überweisen können, ist');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Am aktivsten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'Keine Filme gefunden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'Was würdest du gerne sehen?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'Mehr zu sehen! Um dieses Video weiter anzusehen, müssen Sie es kaufen.');
        } else if ($value == 'russian') {

            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Создать статью');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Создать новую статью');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Смотреть подробное описание');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'Статья');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'Название должно быть более 5 символов');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'Описание должно быть более 15 символов');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'Файл изображения недействителен, пожалуйста, выберите правильное изображение.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Неверная категория, пожалуйста, проверьте ваши данные.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Спасибо, ваша статья была отправлена, и она проверяется, пожалуйста, зайдите позже.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'Мои статьи');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Вы уверены, что хотите удалить эту статью? Это действие не может быть отменено');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Редактировать статью');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Фильмы');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Это фильм?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'да');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'нет');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Название фильма');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Звезды');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Разделенные запятой,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Режиссер');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Релиз');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(От 1 до 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'продолжительность');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Качественный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Рейтинг');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Стоимость аренды (оставьте пустым для бесплатных видео)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Или вы можете арендовать его на 24 часа');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Арендная плата');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'Это видео истекает в');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Прокат этого фильма');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'Для фильмов размер обложки не должен превышать 400х570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'Чтобы посмотреть этот фильм, вы должны приобрести его.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Перевести заработок на кошелек');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Переведите деньги на кошелек, чтобы вы могли использовать их для рекламы.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Как только сумма переведена, вы не сможете ее снять.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Ваш баланс {{баланс}}, Вы не можете перевести');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Перечислить');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Ваш баланс был переведен.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'Максимальная сумма, которую вы можете перевести');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Наиболее активны');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'Фильмы не найдены');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'Что бы вы хотели посмотреть?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'Больше смотреть! Чтобы продолжить просмотр этого видео, вы должны приобрести его.');
            
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Crear articulo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Crear nuevo articulo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Description');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'El artículo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'El título debe tener más de 5 caracteres.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'La descripción debe tener más de 15 caracteres.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'El archivo de imagen no es válido, seleccione una imagen válida.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Categoría no válida, por favor revise sus detalles.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Gracias, su artículo fue enviado y está siendo revisado, por favor, vuelva más tarde.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'Mis articulos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', '¿Estás seguro de que quieres eliminar este artículo? Esta acción no se puede deshacer.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Editar artículo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Películas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', '¿Es una película?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Sí');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'No');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Título de la película');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Estrellas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Separados por comas,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Productor');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Lanzamiento');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(Entre 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'Duración');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Calidad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Clasificación');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Precio de renta (dejar vacio para videos gratis)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'O puedes alquilarlo por 24 horas.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Alquilar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'Este video expirará en');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Alquilar esta pelicula');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'Para películas, el tamaño de la cubierta no debe ser más de 400x570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'Para ver esta película, tienes que comprarla.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Transferencia de ganancias a la billetera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Transfiera dinero a la billetera, para que pueda utilizarlos para anuncios.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Una vez que la cantidad se transfiere, no podrá retirarlas.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Tu saldo es {{balance}}, no puedes transferir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Transferir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Su saldo fue transferido.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'La cantidad máxima que puede transferir es');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Mas activo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'No se encontraron peliculas');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', '¿Qué te gustaría ver?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', '¡Más para ver! Para seguir viendo este video, debes comprarlo.');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Makale oluştur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Yeni makale oluştur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Descritpion');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'Makale');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'Başlık 5 karakterden fazla olmalı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'Açıklama 15 karakterden fazla olmalı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'Resim dosyası geçerli değil, lütfen geçerli bir resim seçin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Geçersiz kategori, Lütfen bilgilerinizi kontrol ediniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Teşekkürler, makaleniz gönderildi ve inceleniyor, lütfen daha sonra tekrar kontrol edin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'Makalelerim');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Bu makaleyi silmek istediğinize emin misiniz? Bu işlem geri alınamaz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Makaleyi düzenle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'filmler');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Bu bir film mi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Evet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'Yok hayır');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Film başlığı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Yıldızlar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Virgülle ayrılmış,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'yapımcı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Serbest bırakmak');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(1 -> 10 arası)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'süre');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Kalite');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Değerlendirme');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Kira Fiyatı (Ücretsiz videolar için boş bırakın)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Veya 24 saatliğine kiralayabilirsiniz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Kira');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'Bu videonun süresi bitecek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Bu filmi kirala');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'Filmler için kapak boyutu 400x570\'den fazla olmamalıdır.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'Bu filmi izlemek için satın almanız gerekir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Kazançları cüzdanınıza aktarın');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'M-cüzdanınıza para aktarın, böylece reklamlar için kullanabilirsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Tutar bir kez transfer edildiğinde, onları çekemezsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Bakiyeniz {{balance}}, Transfer edemezsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Aktar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Bakiyeniz devredildi.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'Aktarabileceğiniz maksimum tutar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'En aktif');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'Film bulunamadı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'Ne izlemek istersin?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'İzlemek için daha fazlası! Bu videoyu izlemeye devam etmek için satın almalısınız.');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Create article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Create new article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Description');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'The article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'The title should be more than 5 characters');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'The description should be more than 15 characters');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'The Image file is not valid, please select a valid image.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Invalid category, Please check your details.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Thank you, your article has been submitted, and it\'s being reviewed, please check back later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'My articles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Are you sure you want to delete this article? This action can\'t be undo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Edit article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Movies');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Is it a movie?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Yes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'No');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Movie title');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Stars');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Separated by comma,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Producer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Release');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(Between 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'Duration');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Quality');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Rating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Rent Price (Leave empty for free videos)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Or you can rent it for 24 hour');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Rent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'This video will expire at ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Rent this movie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'For movies, the cover size should not be more than 400x570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'To watch this movie, you have to purchase it.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Transfer earnings to wallet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Transfer money to wallet, so you would be able to use them for ads.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Once the amount is transferred, you won\'t be able to withdrawal them.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Your balance is {{balance}}, You can\'t transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Your balance was transferred.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'The maximum amount that you can transfer is');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Most active');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'No movies found');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'What you would like to watch?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'More to watch! to continue watching this video, you have to purchase it.');
        } else if ($value != 'english') {
           $lang_update_queries[] = PT_UpdateLangs($value, 'create_article', 'Create article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_new_article', 'Create new article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'descritpion', 'Description');
            $lang_update_queries[] = PT_UpdateLangs($value, 'the_article', 'The article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_title', 'The title should be more than 5 characters');
            $lang_update_queries[] = PT_UpdateLangs($value, 'short_description', 'The description should be more than 15 characters');
            $lang_update_queries[] = PT_UpdateLangs($value, 'image_not_valid', 'The Image file is not valid, please select a valid image.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'category_not_valid', 'Invalid category, Please check your details.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'reviewed_article', 'Thank you, your article has been submitted, and it\'s being reviewed, please check back later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'my_articles', 'My articles');
            $lang_update_queries[] = PT_UpdateLangs($value, 'delete_article_text', 'Are you sure you want to delete this article? This action can\'t be undo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'edit_article', 'Edit article');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies', 'Movies');
            $lang_update_queries[] = PT_UpdateLangs($value, 'is_movie', 'Is it a movie?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'yes', 'Yes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no', 'No');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movie_title', 'Movie title');
            $lang_update_queries[] = PT_UpdateLangs($value, 'stars', 'Stars');
            $lang_update_queries[] = PT_UpdateLangs($value, 'by_comma', 'Separated by comma,');
            $lang_update_queries[] = PT_UpdateLangs($value, 'producer', 'Producer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'release', 'Release');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating_btween', '(Between 1 -> 10)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration', 'Duration');
            $lang_update_queries[] = PT_UpdateLangs($value, 'quality', 'Quality');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rating', 'Rating');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_price', 'Rent Price (Leave empty for free videos)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_text', 'Or you can rent it for 24 hour');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent', 'Rent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_expire', 'This video will expire at ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'rent_video', 'Rent this movie');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cover_size', 'For movies, the cover size should not be more than 400x570.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_text', 'To watch this movie, you have to purchase it.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_earnings', 'Transfer earnings to wallet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer_money', 'Transfer money to wallet, so you would be able to use them for ads.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'withdrawal_earnings', 'Once the amount is transferred, you won\'t be able to withdrawal them.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'cant_transfer', 'Your balance is {{balance}}, You can\'t transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'transfer', 'Transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'balance_transferred', 'Your balance was transferred.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'max_can_transfer', 'The maximum amount that you can transfer is');
            $lang_update_queries[] = PT_UpdateLangs($value, 'most_active', 'Most active');
            $lang_update_queries[] = PT_UpdateLangs($value, 'no_movies_found', 'No movies found');
            $lang_update_queries[] = PT_UpdateLangs($value, 'movies_page_search', 'What you would like to watch?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'pay_to_see_video', 'More to watch! to continue watching this video, you have to purchase it.');
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
                     <h2 class="light">Update to v1.6 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                            <li>[Added] Movies system, now admin can add movies, manage movies categories, sell movies to users.</li>
                            <li>[Added] pagination system, now all videos load thru pagination system and not thru "load more videos" button. </li>
                            <li>[Added] the ability to upload a demo video for videos that being sold.</li>
                            <li>[Added] dailymotion monetization system. </li>
                            <li>[Added] the ability for users to create and submit articles to admin. </li>
                            <li>[Added] now ads are being shown on articles page too.</li>
                            <li>[Added] the ability for user to transfter funds from earnings to wallet, so they can buy ads from their own earnings.</li>
                            <li>[Added] slider to home page. </li>
                            <li>[Fixed] few important bugs on both themes. </li>
                            <li>[Improved] site header in default theme.</li>
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
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'videos_load_limit', '20');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'demo_video', 'on');",
    "ALTER TABLE `videos` ADD `demo` VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `geo_blocking`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'all_create_articles', 'on');",
    "ALTER TABLE `videos` ADD `is_movie` INT(11) NOT NULL DEFAULT '0' AFTER `demo`;",
    "ALTER TABLE `videos` ADD `stars` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `is_movie`;",
    "ALTER TABLE `videos` ADD `producer` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `stars`;",
    "ALTER TABLE `videos` ADD `country` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `producer`;",
    "ALTER TABLE `videos` ADD `movie_release` VARCHAR(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `country`;",
    "ALTER TABLE `videos` ADD `quality` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `movie_release`;",
    "ALTER TABLE `videos` ADD `rating` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `quality`;",
    "ALTER TABLE `videos` ADD `rent_price` INT(11) NOT NULL DEFAULT '0' AFTER `rating`;",
    "ALTER TABLE `videos_transactions` ADD `type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `time`;",
    "ALTER TABLE `videos` ADD INDEX(`is_movie`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'movies_videos', 'on');",
    "ALTER TABLE `users` ADD `active_time` INT(50) NOT NULL DEFAULT '0' AFTER `last_month`;",
    "ALTER TABLE `users` ADD `active_expire` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `active_time`;",
    "ALTER TABLE `users` ADD INDEX(`active_time`);",
    "ALTER TABLE `videos` CHANGE `sell_video` `sell_video` VARCHAR(11) NOT NULL DEFAULT '0';",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'create_article');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'create_new_article');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'descritpion');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'the_article');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'short_title');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'short_description');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'image_not_valid');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'category_not_valid');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'reviewed_article');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'my_articles');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'delete_article_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'edit_article');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'movies');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'is_movie');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'yes');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'movie_title');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'stars');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'by_comma');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'producer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'release');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rating_btween');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'duration');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'quality');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rating');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent_price');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_expire');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'rent_video');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'cover_size');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'movies_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'transfer_earnings');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'transfer_money');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'withdrawal_earnings');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'cant_transfer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'transfer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'balance_transferred');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'max_can_transfer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'most_active');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'no_movies_found');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'movies_page_search');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_see_video');",
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