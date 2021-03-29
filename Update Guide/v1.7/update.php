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
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'حد الإنفاق في اليوم');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'مزود البريد الإلكتروني مدرج في القائمة السوداء وغير مسموح به ، يرجى اختيار مزود بريد إلكتروني آخر.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'أنت أقل من 18 عامًا ولا يمكنك الوصول إلى هذا الموقع لمدة {ساعة} (ساعات).');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'هل عمرك 18 سنة فما فوق؟');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'المعالجة - قد يستغرق هذا بضع دقائق');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'منع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'رفع الحظر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'مستخدمين محجوبين');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'صفحة مخصص');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'إدارة الجلسات');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'المتصفح');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'اخر ظهور');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'عنوان IP');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'اختيار طريقة الدفع');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'باي بال');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'عنوان');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'مدينة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'حالة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'الرمز البريدي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'هاتف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'رقم البطاقة');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'تم رفض دفعتك ، يرجى الاتصال بالمصرف أو مصدر البطاقة والتأكد من أن لديك الأموال المطلوبة.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'بطاقة الائتمان');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'لتأكيد الدفع ، يرجى الانتظار ..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'تم رفض الدفع ، يرجى المحاولة مرة أخرى لاحقًا.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'تحويل مصرفي');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'استعرض لتحميل');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'تم إرسال طلبك بنجاح ، وسوف نخطرك بمجرد الموافقة عليه');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'تم رفض إيصالك المصرفي!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'تمت الموافقة على إيصالك المصرفي!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'يرجى ترقية حسابك لتحميل مقاطع الفيديو');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'يجب أن يكون تنسيق المدة مثل 03:33');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'يرجى ملاحظة أنه إذا كان عمرك أقل من 18 عامًا ، فلن تتمكن من الوصول إلى هذا الموقع.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'سعر الاشتراك (كم يدفع المستخدمون للاشتراك في قناتك؟)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'أرباح الاشتراك');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'اشتر الآن ، أو افتح جميع محتويات {{USERNAME}} لمجرد {{PRICE}} في الشهر فقط!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'اشترك في {{PRICE}} واطلق العنان لجميع مقاطع الفيديو.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'مشتريات الفيديو');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Bestedingslimiet per dag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'De e-mailprovider staat op de zwarte lijst en is niet toegestaan, kies een andere e-mailprovider.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'U bent jonger dan 18 jaar, u hebt gedurende {uur} uur (uren) geen toegang tot deze site.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'Ben je 18 jaar of ouder?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Verwerking - dit kan een paar minuten duren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Blok');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'deblokkeren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Geblokkeerde gebruikers');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Aangepaste pagina');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Sessies beheren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'browser');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Laatst gezien');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'IP adres');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Kies een betaal methode');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Adres');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'stad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Staat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'ritssluiting');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Telefoon');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Kaartnummer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Uw betaling is geweigerd. Neem contact op met uw bank of creditcardmaatschappij en zorg dat u over het benodigde geld beschikt.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Kredietkaart');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Bevestiging van uw betaling, even geduld aub ..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Betaling geweigerd. Probeer het later opnieuw.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Bankoverschrijving');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Blader naar uploaden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Uw verzoek is succesvol verzonden, wij zullen u op de hoogte brengen zodra het is goedgekeurd');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Uw bankbewijs is geweigerd!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Uw bank-factuur is goedgekeurd!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Voer een upgrade van uw account uit om video\'s te uploaden');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Duurindeling moet ongeveer 03:33 zijn');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Houd er rekening mee dat als u jonger bent dan 18 jaar, u geen toegang kunt krijgen tot deze site.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Abonnementsprijs (Hoeveel gebruikers betalen zich om zich te abonneren op je kanaal?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Abonnementswinst');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Koop nu, OF ontgrendel alle content van {{USERNAME}} voor slechts {{PRICE}} per maand!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Abonneer je op {{PRICE}} en ontgrendel alle video\'s.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Video-aankopen');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Limite de dépenses par jour');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'Le fournisseur de messagerie est sur la liste noire et non autorisé. Veuillez choisir un autre fournisseur de messagerie.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'Vous avez moins de 18 ans, vous ne pouvez pas accéder à ce site pendant {heure} heure (s).');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'Avez-vous 18 ans ou plus?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Traitement - cela peut prendre quelques minutes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Bloc');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'Débloquer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Utilisateurs bloqués');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Page personnalisée');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Gérer les sessions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'Navigateur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Dernier vu');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'Adresse IP');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Choisissez une méthode de paiement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'Pay Pal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Adresse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'Ville');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Etat');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Zip *: français');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Téléphone');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Numéro de carte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Votre paiement a été refusé, veuillez contacter votre banque ou votre émetteur de carte et assurez-vous de disposer des fonds nécessaires.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Carte de crédit');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Confirmant votre paiement, veuillez patienter ..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Paiement refusé, veuillez réessayer plus tard.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Virement bancaire');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Parcourir pour télécharger');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Votre demande a été envoyée avec succès, nous vous en informerons une fois approuvée');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Votre ticket de banque a été refusé!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Votre reçu de banque a été approuvé!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Veuillez mettre à jour votre compte pour télécharger des vidéos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Le format de la durée doit être comme 03:33');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Veuillez noter que si vous avez moins de 18 ans, vous ne pourrez pas accéder à ce site.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Prix de l\'abonnement (Combien d\'utilisateurs paieront-ils pour s\'abonner à votre chaîne?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Gains d\'abonnement');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Achetez maintenant OU déverrouillez tout le contenu de {{USERNAME}} pour seulement {{PRICE}} un mois!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Abonnez-vous à {{PRICE}} et déverrouillez toutes les vidéos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Achat de vidéos');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Ausgabenlimit pro Tag');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'Der E-Mail-Anbieter ist auf der schwarzen Liste und nicht zulässig. Bitte wählen Sie einen anderen E-Mail-Anbieter.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'Sie sind jünger als 18 Jahre und können für {hour} hour (s) nicht auf diese Site zugreifen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'Bist du 18 Jahre alt oder älter?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Verarbeitung - Dies kann einige Minuten dauern');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Block');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'Entsperren');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Blockierte Benutzer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Benutzerdefinierte Seite');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Sitzungen verwalten');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'Browser');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Zuletzt gesehen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'IP Adresse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Wählen Sie eine Bezahlungsart');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Kasse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Adresse');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'Stadt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Zustand');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Postleitzahl');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Telefon');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Kartennummer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Ihre Zahlung wurde abgelehnt. Wenden Sie sich an Ihre Bank oder Ihren Kartenaussteller, und vergewissern Sie sich, dass Sie über das erforderliche Guthaben verfügen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Kreditkarte');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Bitte warten Sie, bis die Zahlung bestätigt wurde.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Zahlung abgelehnt. Bitte versuchen Sie es später erneut.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Überweisung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Zum Hochladen durchsuchen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Ihre Anfrage wurde erfolgreich gesendet. Wir werden Sie benachrichtigen, sobald sie genehmigt wurde');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Ihre Bankquittung wurde abgelehnt!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Ihre Bankquittung wurde genehmigt!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Bitte aktualisiere dein Konto, um Videos hochzuladen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Das Dauerformat muss 03:33 sein');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Bitte beachten Sie, dass Sie unter 18 Jahren nicht auf diese Website zugreifen können.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Abonnementpreis (Wie viel Nutzer zahlen, um Ihren Kanal zu abonnieren?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Abo-Einnahmen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Kaufen Sie jetzt oder schalten Sie den gesamten Inhalt von {{USERNAME}} für nur {{PRICE}} einen Monat frei!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Abonniere {{PRICE}} und schalte alle Videos frei.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Videokäufe');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Лимит расходов в день');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'Поставщик электронной почты находится в черном списке и не допускается, выберите другого поставщика электронной почты.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'Вам не исполнилось 18 лет, и вы не можете получить доступ к этому сайту в течение {часов} часов.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'Вам 18 лет или больше?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Обработка - это может занять несколько минут');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'блок');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'открыть');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Заблокированные пользователи');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Пользовательская страница');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Управление сессиями');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'браузер');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Последнее посещение');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'Айпи адрес');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Выберите способ оплаты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Адрес');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'город');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'государственный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'застежка-молния');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Телефон');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Номер карты');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Ваш платеж был отклонен, пожалуйста, свяжитесь с банком или эмитентом карты и убедитесь, что у вас есть необходимые средства.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Кредитная карта');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Подтверждение оплаты, пожалуйста, подождите ..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Платеж отклонен, повторите попытку позже.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Банковский перевод');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Обзор для загрузки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Ваш запрос был успешно отправлен, мы сообщим вам, как только он будет одобрен');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Ваша банковская квитанция была отклонена!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Ваша банковская квитанция была подтверждена!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Пожалуйста, обновите свой аккаунт, чтобы загружать видео');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Формат продолжительности должен быть как 03:33');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Обратите внимание, что если вам не исполнилось 18 лет, вы не сможете получить доступ к этому сайту.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Цена подписки (сколько пользователи будут платить за подписку на ваш канал?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Доход от подписки');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Купите сейчас, ИЛИ разблокируйте весь контент {{USERNAME}} всего за {{PRICE}} месяц!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Подпишитесь на {{PRICE}} и разблокируйте все видео.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Видео покупки');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Límite de gasto por día');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'El proveedor de correo electrónico está en la lista negra y no está permitido, elija otro proveedor de correo electrónico.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'Tiene menos de 18 años, no puede acceder a este sitio durante {hora} hora (s).');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', '¿Tienes 18 años o más?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Procesamiento - esto puede tardar unos minutos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Bloquear');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'Desatascar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Usuarios bloqueados');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Pagina personalizada');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Gestionar sesiones');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'Navegador');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Ultima vez visto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'Dirección IP');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Elija un método de pago');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2 Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Dirección');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'Ciudad');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Estado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Cremallera');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Teléfono');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Número de tarjeta');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Su pago fue rechazado, póngase en contacto con su banco o con el emisor de la tarjeta y asegúrese de tener los fondos necesarios.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Tarjeta de crédito');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Confirmando su pago, por favor espere ..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Pago rechazado, inténtalo de nuevo más tarde.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Transferencia bancaria');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Navegar para subir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Su solicitud ha sido enviada exitosamente, le notificaremos una vez que sea aprobada.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Su recibo bancario ha sido rechazado!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Su recibo bancario ha sido aprobado!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Por favor actualice su cuenta para subir videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Formato de duración debe ser como 03:33');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Tenga en cuenta que si es menor de 18 años, no podrá acceder a este sitio.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Precio de suscripción (¿Cuánto pagarán los usuarios para suscribirse a tu canal?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Ingresos de suscripción');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', '¡Compre ahora, O desbloquee todo el contenido de {{USERNAME}} por solo {{PRICE}} al mes!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Suscríbete para {{PRICE}} y desbloquea todos los videos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Compras de video');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Günlük harcama limiti');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'E-posta sağlayıcı kara listeye alındı ve izin verilmedi, lütfen başka bir e-posta sağlayıcısı seçin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', '18 yaşından küçüksünüz, bu siteye {hour} saat boyunca erişemezsiniz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', '18 yaşında veya daha büyük müsünüz?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'İşlem - bu birkaç dakika sürebilir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Blok');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'engeli kaldırmak');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Engellenmiş kullanıcılar');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Özel sayfa');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Oturumları Yönet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'Tarayıcı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Son görülen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'IP adresi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Bir ödeme yöntemi seçin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Adres');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'Kent');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'Belirtmek, bildirmek');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Telefon');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Kart numarası');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Ödemeniz reddedildi, lütfen bankanıza veya kart düzenleyicinize başvurun ve gerekli paranın olduğundan emin olun.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Kredi kartı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Ödemenizi onaylayın, lütfen bekleyin ..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Ödeme reddedildi, lütfen daha sonra tekrar deneyin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Banka havalesi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Yüklemeye Göz At');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'İsteğiniz başarıyla gönderildi, onaylandıktan sonra sizi bilgilendireceğiz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Banka dekontunuz reddedildi!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Banka dekontunuz onaylandı!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Video yüklemek için lütfen hesabınızı yükseltin');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Süre biçimi, 03:33 gibi olmalıdır');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Lütfen 18 yaşın altındaysanız bu siteye erişemeyeceğinizi unutmayın.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Abonelik Fiyatı (Kanalınıza abone olmak için ne kadar kullanıcı ödeyecek?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Abonelik Kazançları');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Hemen satın alın VEYA bir ay boyunca {{PRICE}} için {{USERNAME}} içeriğinin tüm kilidini açın!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', '{{PRICE}} için abone olun ve tüm videoların kilidini açın.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Video alımları');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Spending limit per day');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'The email provider is blacklisted and not allowed, please choose another email provider.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'You are under 18 you can\'t access this site for {hour} hour(s).');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'Are you 18 years old or above?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Processing - this may take a few minutes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Block');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'Unblock');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Blocked Users');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Custom Page');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Manage Sessions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'Browser');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Last Seen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'IP Address');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Choose a payment method');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Address');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'City');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'State');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Phone');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Card Number');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Your payment was declined, please contact your bank or card issuer and make sure you have the required funds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Credit Card');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Confirming your payment, please wait..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Payment declined, please try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Bank transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Browse To Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Your request has been successfully sent, we will notify you once it\'s approved');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Your bank receipt has been declined!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Your bank receipt has been approved!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Please upgrade your account to upload videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Duration format must be like 03:33');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Please note that if you are under 18, you won\'t be able to access this site. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Subscription Price (How much users will pay to subscribe to your channel?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Subscription Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Buy now, OR unlock all content of {{USERNAME}} for just {{PRICE}} a month!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Subscribe for {{PRICE}} and unlock all the videos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Video purchases');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'ad_day_limit', 'Spending limit per day');
            $lang_update_queries[] = PT_UpdateLangs($value, 'email_provider_banned', 'The email provider is blacklisted and not allowed, please choose another email provider.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_text', 'You are under 18 you can\'t access this site for {hour} hour(s).');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_modal', 'Are you 18 years old or above?');
            $lang_update_queries[] = PT_UpdateLangs($value, 'porcessing_image', 'Processing - this may take a few minutes');
            $lang_update_queries[] = PT_UpdateLangs($value, 'block', 'Block');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unblock', 'Unblock');
            $lang_update_queries[] = PT_UpdateLangs($value, 'blocked_users', 'Blocked Users');
            $lang_update_queries[] = PT_UpdateLangs($value, 'custom_page', 'Custom Page');
            $lang_update_queries[] = PT_UpdateLangs($value, 'manage_sessions', 'Manage Sessions');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browser', 'Browser');
            $lang_update_queries[] = PT_UpdateLangs($value, 'last_seen', 'Last Seen');
            $lang_update_queries[] = PT_UpdateLangs($value, 'ip_address', 'IP Address');
            $lang_update_queries[] = PT_UpdateLangs($value, 'choose_payment_method', 'Choose a payment method');
            $lang_update_queries[] = PT_UpdateLangs($value, 'paypal', 'PayPal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_text', '2Checkout');
            $lang_update_queries[] = PT_UpdateLangs($value, 'address', 'Address');
            $lang_update_queries[] = PT_UpdateLangs($value, 'city', 'City');
            $lang_update_queries[] = PT_UpdateLangs($value, 'state', 'State');
            $lang_update_queries[] = PT_UpdateLangs($value, 'zip', 'Zip');
            $lang_update_queries[] = PT_UpdateLangs($value, 'phone_number', 'Phone');
            $lang_update_queries[] = PT_UpdateLangs($value, 'card_number', 'Card Number');
            $lang_update_queries[] = PT_UpdateLangs($value, 'checkout_declined', 'Your payment was declined, please contact your bank or card issuer and make sure you have the required funds.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'credit_card', 'Credit Card');
            $lang_update_queries[] = PT_UpdateLangs($value, 'c_payment', 'Confirming your payment, please wait..');
            $lang_update_queries[] = PT_UpdateLangs($value, 'payment_declined', 'Payment declined, please try again later.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer', 'Bank transfer');
            $lang_update_queries[] = PT_UpdateLangs($value, 'browse_to_upload', 'Browse To Upload');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_transfer_request', 'Your request has been successfully sent, we will notify you once it\'s approved');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_decline', 'Your bank receipt has been declined!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'bank_pro', 'Your bank receipt has been approved!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'upgrade_account', 'Please upgrade your account to upload videos');
            $lang_update_queries[] = PT_UpdateLangs($value, 'duration_fromat', 'Duration format must be like 03:33');
            $lang_update_queries[] = PT_UpdateLangs($value, 'age_block_extra', 'Please note that if you are under 18, you won\'t be able to access this site. ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscriber_price', 'Subscription Price (How much users will pay to subscribe to your channel?)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_earnings', 'Subscription Earnings');
            $lang_update_queries[] = PT_UpdateLangs($value, 'buy_or_subscribe', 'Buy now, OR unlock all content of {{USERNAME}} for just {{PRICE}} a month!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'subscribe_to_see', 'Subscribe for {{PRICE}} and unlock all the videos.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'video_purchase', 'Video purchases');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }
    $query = mysqli_query($sqlConnect, "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'bank_description', '" . htmlspecialchars_decode('<div class="bank_info"><div class="dt_settings_header bg_gradient"><div class="dt_settings_circle-1"></div><div class="dt_settings_circle-2"></div><div class="bank_info_innr"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M11.5,1L2,6V8H21V6M16,10V17H19V10M2,22H21V19H2M10,10V17H13V10M4,10V17H7V10H4Z"></path></svg><h4 class="bank_name">Garanti Bank</h4><div class="row"><div class="col col-md-12"><div class="bank_account"><p>4796824372433055</p><span class="help-block">Account number / IBAN</span></div></div><div class="col col-md-12"><div class="bank_account_holder"><p>Antoian Kordiyal</p><span class="help-block">Account name</span></div></div><div class="col col-md-6"><div class="bank_account_code"><p>TGBATRISXXX</p><span class="help-block">Routing code</span></div></div><div class="col col-md-6"><div class="bank_account_country"><p>United States</p><span class="help-block">Country</span></div></div></div></div></div></div>') . "')");
    $name  = md5(microtime()) . '_updated.php';
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
                     <h2 class="light">Update to v1.7 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                               <li>[Added] the ability to set a limit per day for ads. </li>
                               <li>[Added] the ability to block email provider in registeration.</li>
                               <li>[Added] +18 pop up, [enable/disable]</li>
                               <li>[Added] the ability to import videos from ok.ru (user end). </li>
                               <li>[Added] sort by month, week and year in top videos page. </li>
                               <li>[Added] gif system for videos, (a 4 second gif will show up when user hover on the video thumbnail).</li>
                               <li>[Added] block system, channels can block each other. </li>
                               <li>[Added] the ability to import videos to a sub category.</li>
                               <li>[Added] Digitalocean space support, you can upload videos to Digitalocean.</li>
                               <li>[Added] custom pages, admin can create custom pages. </li>
                               <li>[Added] Manage currencies from admin panel, you can add, edit, and delete any curreny.</li>
                               <li>[Added] Manage sessions, user can manage his sessions from settings.</li>
                               <li>[Added] 2Checkout payment method.</li>
                               <li>[Added] Stripe, and local bank payment method support. </li>
                               <li>[Added] subscription system for channels. User can subscribe to user channel, to view their selling videos. </li>
                               <li>[Fixed] 20+ important bugs. </li>
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
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'version', '1.7');",
    "ALTER TABLE `user_ads` ADD `day_limit` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `type`;",
    "ALTER TABLE `user_ads` ADD `day` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `day_limit`;",
    "ALTER TABLE `user_ads` ADD `day_spend` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `day`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'pop_up_18', 'off');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'time_18', '1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'ok_import', 'off');",
    "ALTER TABLE `videos` ADD `ok` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `facebook`;",
    "ALTER TABLE `videos` ADD INDEX(`ok`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'gif_system', 'on');",
    "ALTER TABLE `videos` ADD `gif` VARCHAR(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `demo`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'block_system', 'on');",
    "CREATE TABLE `block` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL DEFAULT '0',`blocked_id` int(11) NOT NULL DEFAULT '0',`time` varchar(50) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `block` ADD INDEX(`user_id`);",
    "ALTER TABLE `block` ADD INDEX(`blocked_id`);",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'spaces', 'on');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'space_name', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'spaces_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'spaces_secret', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'space_region', 'nyc3');",
    "CREATE TABLE `custom_pages` (`id` int(11) NOT NULL AUTO_INCREMENT,`page_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',`page_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',`page_content` text COLLATE utf8_unicode_ci,`page_type` int(11) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'currency_symbol_array', 'a:10:{s:3:\"USD\";s:1:\"$\";s:3:\"EUR\";s:3:\"€\";s:3:\"JPY\";s:2:\"¥\";s:3:\"TRY\";s:3:\"₺\";s:3:\"GBP\";s:2:\"£\";s:3:\"RUB\";s:6:\"руб\";s:3:\"PLN\";s:3:\"zł\";s:3:\"ILS\";s:3:\"₪\";s:3:\"BRL\";s:2:\"R$\";s:3:\"INR\";s:3:\"₹\";}');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'currency_array', 'a:10:{i:0;s:3:\"USD\";i:1;s:3:\"EUR\";i:2;s:3:\"JPY\";i:3;s:3:\"TRY\";i:4;s:3:\"GBP\";i:5;s:3:\"RUB\";i:6;s:3:\"PLN\";i:7;s:3:\"ILS\";i:8;s:3:\"BRL\";i:9;s:3:\"INR\";}');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'paypal_currency', 'USD');",
    "ALTER TABLE `sessions` ADD `platform_details` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `platform`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_currency', 'USD');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_mode', 'sandbox');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_seller_id', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_publishable_key', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'checkout_private_key', '');",
    "ALTER TABLE `users` ADD `phone_number` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `active_expire`;",
    "ALTER TABLE `users` ADD `address` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `phone_number`;",
    "ALTER TABLE `users` ADD `city` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `address`;",
    "ALTER TABLE `users` ADD `state` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `city`;",
    "ALTER TABLE `users` ADD `zip` INT(11) NOT NULL DEFAULT '0' AFTER `state`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'credit_card', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'stripe_currency', 'USD');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'stripe_secret', '');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'stripe_id', '');",
    "ALTER TABLE `config` CHANGE `value` `value` VARCHAR(20000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'bank_payment', 'no');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'bank_transfer_note', 'In order to confirm the bank transfer, you will need to upload a receipt or take a screenshot of your transfer within 1 day from your payment date. If a bank transfer is made but no receipt is uploaded within this period, your order will be cancelled. We will verify and confirm your receipt within 3 working days from the date you upload it.');",
    "CREATE TABLE `bank_receipts` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`user_id` int(11) unsigned NOT NULL DEFAULT '0',`description` tinytext NOT NULL,`price` varchar(50) NOT NULL DEFAULT '0',`mode` varchar(50) NOT NULL DEFAULT '',`approved` int(11) unsigned NOT NULL DEFAULT '0',`receipt_file` varchar(250) NOT NULL DEFAULT '',`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,`approved_at` int(11) unsigned NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "ALTER TABLE `bank_receipts` ADD `video_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'payed_subscribers', 'off');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'admin_com_subscribers', '2');",
    "ALTER TABLE `users` ADD `subscriber_price` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `zip`;",
    "ALTER TABLE `bank_receipts` ADD `profile_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`;",
    "UPDATE `langs` SET `english` = 'Video sales earnings' WHERE `langs`.`lang_key` = 'videos_earnings';",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ad_day_limit');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'email_provider_banned');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'age_block_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'age_block_modal');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'porcessing_image');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'block');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'unblock');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'blocked_users');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'custom_page');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'manage_sessions');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'browser');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'last_seen');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'ip_address');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'choose_payment_method');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'paypal');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'checkout_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'address');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'city');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'state');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'zip');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'phone_number');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'card_number');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'checkout_declined');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'credit_card');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'c_payment');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'payment_declined');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'bank_transfer');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'browse_to_upload');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'bank_transfer_request');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'bank_decline');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'bank_pro');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'upgrade_account');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'duration_fromat');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'age_block_extra');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscriber_price');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscribe_earnings');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'buy_or_subscribe');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'subscribe_to_see');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'video_purchase');",
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