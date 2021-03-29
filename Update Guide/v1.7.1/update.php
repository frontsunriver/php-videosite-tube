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
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'هل أنت متأكد أنك تريد إلغاء الاشتراك؟ هذا الإجراء لا يمكن التراجع.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'لا يتم اعتماد تنسيق الملف');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'تقرير حقوق الطبع والنشر');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'خلق اتخاذ DMCA أسفل إشعار');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'يرجى وصف طلبك بعناية وبقدر ما يمكن، لاحظ أن طلبات DMCA كاذبة يمكن أن يؤدي إلى إنهاء الحساب.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'لدي اعتقاد راسخ بأن استخدام من الطبع والنشر المذكورة أعلاه غير مخول من قبل صاحب حق المؤلف أو وكيله أو القانون');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'أؤكد أنني صاحب حق المؤلف أو مرخص لي بالتصرف نيابة عن صاحب الحق الحصري الذي يزعم انتهاكه.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'يرجى تحديد مربعات الاختيار أدناه إذا كنت تملك حقوق التأليف والنشر.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'صورتك الشخصية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'جواز السفر / بطاقة الهوية');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'تفاصيل إضافية حول نفسك (اختياري)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'لا يمكنك تقديم طلب تسييل حتى تم قبول الطلب السابق / رفض.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'تمت الموافقة على طلب تسييل الخاص بك!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'تم رفض طلب تسييل الخاص بك!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'غير مثبت عليه');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'تم إرسال رسالة تأكيد بالبريد الإلكتروني.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'رمز خاطئ');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'تهانينا، يتم التحقق من بريدك الإلكتروني.');
        } else if ($value == 'dutch') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Weet je zeker dat je je wilt afmelden? Deze actie kan niet ongedaan maken.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'Bestandsformaat wordt niet ondersteund');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'rapport Copyright');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Maak DMCA take down kennisgeving');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Beschrijf uw verzoek zorgvuldig en zoveel als je kunt, er rekening mee dat valse DMCA verzoeken kunnen leiden tot beëindiging van het account.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'Ik heb een goed vertrouwen geloven dat het gebruik van het auteursrechtelijk beschermde werk hiervoor geen toestemming is verleend door de auteursrechthebbende, diens vertegenwoordiger of de wet');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'Ik bevestig dat ik de eigenaar van het auteursrecht of bevoegd ben te handelen namens de eigenaar van een exclusief recht dat de vermeende inbreuk.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'Selecteer de vakjes hieronder als u het copyright bezit.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Uw Personal Photo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Paspoort / ID-kaart');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Aanvullende informatie over jezelf (optioneel)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'U kunt inkomsten geen verzoek indienen tot de vorige aanvraag is geaccepteerd / verworpen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Je verzoek is goedgekeurd!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Je verzoek is afgewezen!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'geverifieerde');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'Een bevestigings e-mail is verzonden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Verkeerde code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Gefeliciteerd, uw e-mail geverifieerd.');
        } else if ($value == 'french') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Êtes-vous sûr de vouloir résilier votre abonnement? Cette action ne peut pas être annuler.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'Format de fichier non pris en charge');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'rapport droit d\'auteur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Créer DMCA abattre avis');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'S\'il vous plaît décrire votre demande avec soin et autant que vous le pouvez, notez que les fausses demandes DMCA peuvent conduire à la résiliation du compte.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'J\'ai une bonne foi que l\'utilisation de l\'œuvre protégée décrite ci-dessus ne sont pas autorisée par le titulaire du droit d\'auteur, son agent ou la loi');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'Je confirme que je suis le propriétaire du droit d\'auteur ou autorisé à agir au nom du propriétaire d\'un droit exclusif qui aurait été violé.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'S\'il vous plaît cocher les cases ci-dessous si vous possédez le droit d\'auteur.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Votre Photo personnelle');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Passeport / carte d\'identité');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Des détails supplémentaires au sujet de votre auto (en option)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'Vous ne pouvez pas soumettre la demande de monétisation jusqu\'à ce que la demande précédente a été acceptée / refusée.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Votre demande de monétisation a été approuvée!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Votre demande de monétisation a été refusée!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'Non vérifié');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'Un e-mail de confirmation a été envoyé.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Mauvais code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Félicitations, votre e-mail est vérifiée.');
        } else if ($value == 'german') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Sind Sie sicher, dass Sie sich abmelden wollen? Diese Aktion kann nicht rückgängig gemacht werden.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'Datei-Format wird nicht unterstützt');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'Bericht Urheberrecht');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Erstellen DMCA take down Ankündigung');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Bitte beschreiben Sie Ihre Anfrage sorgfältig und so viel Sie können, beachten Sie, dass falsche DMCA-Anfragen zur Kündigung des Kontos führen kann.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'Ich habe einen guten Glauben, die oben beschrieben der urheberrechtlich geschützten Arbeit verwenden wird nicht vom Inhaber des Urheberrechts, dessen Agenten oder per Gesetz');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'Ich bestätige, dass ich der Inhaber des Urheberrechts bin oder bin, im Namen des Inhabers eines exklusiven Rechts zu handeln, das angeblich verletzt wird.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'Bitte wählen Sie die Kontrollkästchen unten, wenn Sie das Urheberrecht besitzen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Ihr persönliches Foto');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Reisepass / Personalausweis');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Weitere Einzelheiten über sich selbst (Optional)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'Sie können nicht Monetisierung Anfrage, bis die vorherige Anfrage wurde akzeptiert / abgelehnt einreichen.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Ihre Monetisierung Anfrage wurde genehmigt!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Ihre Monetisierung Anfrage wurde abgelehnt!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'Ungeprüft');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'Eine Bestätigungs-Mail wurde abgeschickt.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Falscher Code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Gratulation, Ihre E-Mail bestätigt.');
        } else if ($value == 'russian') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Вы уверены, что хотите отказаться от подписки? Это действие не может быть отмена.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'Формат файла не поддерживается');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'Отчет Copyright');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Создание DMCA снимать уведомления');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Пожалуйста, опишите вашу просьбу тщательно и столько, сколько вы можете, обратите внимание, что ложные DMCA запросы могут привести к блокировке аккаунта.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'У меня есть добросовестное предположение, что использование защищенных авторским правом работ, описанных выше, не разрешено владельцем авторского права, его агентом или законом');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'Я подтверждаю, что я являюсь владельцем авторского права или имею право действовать от имени владельца исключительного права, которое предположительно было нарушено.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'Пожалуйста, отметьте флажки ниже, если вы являетесь владельцем авторских прав.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Ваша Фотография');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Паспорт / удостоверение личности');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Дополнительные сведения о вашей собственной личности (необязательно)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'Вы не можете отправить запрос о монетизации, пока предыдущий запрос не был принят / отклонен.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Ваша заявка на монетизацию была одобрена!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Ваш запрос монетизация отклонен!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'непроверенный');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'Подтверждение по электронной почте было отправлено.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Неверный код');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Поздравляем, ваша электронная почта проверяется.');
        } else if ($value == 'spanish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', '¿Seguro que desea darse de baja? Esta acción no se puede deshacer.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'Formato de archivo no es compatible');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'informe de Derechos de autor');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Crear DMCA acabar aviso');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Por favor describa su solicitud con cuidado y lo más que puede, tenga en cuenta que las solicitudes DMCA falsas pueden dar lugar a la cancelación de cuenta.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'Tengo una buena fe que el uso de la obra con derechos de autor descrito anteriormente no está autorizado por el propietario del copyright, su agente o la ley');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'Confirmo que soy el propietario del copyright o estoy autorizado a actuar en nombre del propietario de un derecho exclusivo que presuntamente se ha infringido.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'Por favor, seleccione las casillas de verificación a continuación si es el propietario del derecho de autor.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Su foto personal');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Pasaporte / tarjeta de ID');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Detalles adicionales acerca de su auto (opcional)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'No se puede enviar la solicitud de monetización hasta que la solicitud anterior ha sido aceptado / rechazado.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Su solicitud de monetización ha sido aceptado!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Su solicitud ha sido rechazada monetización!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'Inconfirmado');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'Un correo electrónico de confirmación ha sido enviado.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Codigo erroneo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Felicitaciones, su correo electrónico se verifica.');
        } else if ($value == 'turkish') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Eğer aboneliğinizi iptal etmek istediğinizden emin misiniz? Bu eylem geri alınamaz.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'Dosya biçimi desteklenmiyor');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'Hakkı bildir');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'haber aşağı çekmek DMCA Oluştur');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Eğer yanlış DMCA istekleri hesabın kapatılmasına yol unutmayınız gibi dikkatle ve kadar isteğinizi anlatın.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'Telif hakkı sahibi, temsilcisi veya yasalar tarafından izin verilmediğine Yukarıda açıklanan telif hakkı eserin kullanmak bir samimiyetle inanıyorum');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'Ben telif hakkı sahibi olduğuma veya ihlal edildiği iddia edilen münhasır hakkın sahibi adına hareket etmeye yetkili doğruluyorum.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'telif hakkına sahip olmadığını aşağıdaki onay kutularını seçin.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Kişisel Fotoğraf');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Pasaport / kimlik kartı');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'sizin kendi hakkında ek ayrıntılar (İsteğe bağlı)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'Bir önceki isteği kabul edilinceye kadar para kazanma isteği gönderemezsiniz / reddetmiştir.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Para kazanma isteğiniz onaylandı!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Para kazanma isteği reddedildi!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'doğrulanmamış');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'Bir onay e-postası gönderildi.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Yanlış kod');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Tebrikler, e-posta doğrulandı.');
        } else if ($value == 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Are you sure you want to unsubscribe? This action can\'t be undo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'File format is not supported');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'Report Copyright');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Create DMCA take down notice');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Please describe your request carefully and as much as you can, note that false DMCA requests can lead to account termination.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'I have a good faith belief that use of the copyrighted work described above is not authorized by the copyright owner, its agent or the law');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'I confirm that I am the copyright owner or am authorised to act on behalf of the owner of an exclusive right that is allegedly infringed.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'Please select the checkboxs below if you own the copyright.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Your Personal Photo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Passport / ID card');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Additional details about your self (Optional)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'You can not submit monetization request until the previous request has been accepted / rejected.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Your monetization request has been approved!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Your monetization request has been declined!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'Unverified');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'A confirmation email has been sent.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Wrong code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Congratulations, your email is verified. ');
        } else if ($value != 'english') {
            $lang_update_queries[] = PT_UpdateLangs($value, 'unsubscribe_from_channel', 'Are you sure you want to unsubscribe? This action can\'t be undo.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'file_not_supported', 'File format is not supported');
            $lang_update_queries[] = PT_UpdateLangs($value, 'report_copyright', 'Report Copyright');
            $lang_update_queries[] = PT_UpdateLangs($value, 'create_notice', 'Create DMCA take down notice');
            $lang_update_queries[] = PT_UpdateLangs($value, 'describe_notice', 'Please describe your request carefully and as much as you can, note that false DMCA requests can lead to account termination.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_1_text', 'I have a good faith belief that use of the copyrighted work described above is not authorized by the copyright owner, its agent or the law');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_2_text', 'I confirm that I am the copyright owner or am authorised to act on behalf of the owner of an exclusive right that is allegedly infringed.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirm_check_text', 'Please select the checkboxs below if you own the copyright.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'personal_photo', 'Your Personal Photo');
            $lang_update_queries[] = PT_UpdateLangs($value, 'passport_id', 'Passport / ID card');
            $lang_update_queries[] = PT_UpdateLangs($value, 'additional_details', 'Additional details about your self (Optional)');
            $lang_update_queries[] = PT_UpdateLangs($value, 'submit_monetization_request_error', 'You can not submit monetization request until the previous request has been accepted / rejected.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_accept', 'Your monetization request has been approved!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'monetization_decline', 'Your monetization request has been declined!');
            $lang_update_queries[] = PT_UpdateLangs($value, 'unverified', 'Unverified');
            $lang_update_queries[] = PT_UpdateLangs($value, 'confirmation_message_email_sent', 'A confirmation email has been sent.');
            $lang_update_queries[] = PT_UpdateLangs($value, 'wrong_code', 'Wrong code');
            $lang_update_queries[] = PT_UpdateLangs($value, 'new_email_verified', 'Congratulations, your email is verified. ');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($mysqli, $query);
        }
    }
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
                     <h2 class="light">Update to v1.7.1 </span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                               <li>[Added] ability to add fake views, likes, in the admin panel for specific videos. </li>
                               <li>[Added] ability to enable/disable monetization for specific videos. [enable/disable]</li>
                               <li>[Added] ability to apply for disable enable from admin monetization (form) [enable/disable]</li>
                               <li>[Added] the ability to send take down notice for specific video. [enable/disable] </li>
                               <li>[Added] when someone access site first time a popup was added to select specific language. </li>
                               <li>[Added] 5+ more APIs. </li>
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
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'version', '1.7.1');",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'lang_modal', 'off');",
    "ALTER TABLE `videos` ADD `monetization` INT(11) NOT NULL DEFAULT '1' AFTER `rating`;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'report_copyright', 'on');",
    "CREATE TABLE `copyright_report` (`id` int(11) NOT NULL AUTO_INCREMENT,`video_id` int(11) NOT NULL DEFAULT '0',`user_id` int(11) NOT NULL DEFAULT '0',`text` varchar(300) NOT NULL DEFAULT '',`time` varchar(50) NOT NULL DEFAULT '',PRIMARY KEY (`id`),KEY `video_id` (`video_id`),KEY `user_id` (`user_id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "INSERT INTO `config` (`id`, `name`, `value`) VALUES (NULL, 'user_mon_approve', 'off');",
    "CREATE TABLE `monetization_requests` (`id` int(11) NOT NULL AUTO_INCREMENT,`user_id` int(11) NOT NULL DEFAULT '0',`name` varchar(100) NOT NULL DEFAULT '',`message` varchar(600) NOT NULL DEFAULT '',`personal_photo` varchar(300) NOT NULL DEFAULT '',`id_photo` varchar(300) NOT NULL DEFAULT '',`time` varchar(50) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `monetization_requests` ADD INDEX(`user_id`);",
    "ALTER TABLE `users` ADD `monetization` INT(11) NOT NULL DEFAULT '0' AFTER `subscriber_price`;",
    "ALTER TABLE `users` ADD `new_email` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `monetization`;",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'unsubscribe_from_channel');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'file_not_supported');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'report_copyright');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'create_notice');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'describe_notice');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'confirm_1_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'confirm_2_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'confirm_check_text');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'personal_photo');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'passport_id');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'additional_details');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'submit_monetization_request_error');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'monetization_accept');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'monetization_decline');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'unverified');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'confirmation_message_email_sent');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'wrong_code');",
    "INSERT INTO `langs` (`id`, `lang_key`) VALUES (NULL, 'new_email_verified');",
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