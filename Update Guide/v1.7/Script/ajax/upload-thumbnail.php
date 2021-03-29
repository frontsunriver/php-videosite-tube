<?php
if (IS_LOGGED == false || $pt->config->upload_system != 'on') {
    $data = array('status' => 400, 'error' => 'Not logged in');
    echo json_encode($data);
    exit();
}

$thumbnail = 'upload/photos/thumbnail.jpg';
if (!empty($_FILES['thumbnail']['tmp_name'])) {
    $file_info   = array(
        'file' => $_FILES['thumbnail']['tmp_name'],
        'size' => $_FILES['thumbnail']['size'],
        'name' => $_FILES['thumbnail']['name'],
        'type' => $_FILES['thumbnail']['type'],
        'crop' => array(
            'width' => 1076,
            'height' => 604
        )
    );
    $pt->config->s3_upload = 'off';
    $pt->config->ftp_upload = 'off';
    $pt->config->spaces = 'off';
    $file_upload = PT_ShareFile($file_info);
    if (!empty($file_upload['filename'])) {
        $thumbnail = PT_Secure($file_upload['filename'], 0);
        $_SESSION['ffempg_uploads'][] = $thumbnail;
        $data = array('status' => 200, 'thumbnail' => $thumbnail);
    }
}
?>