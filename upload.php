<?php
session_start();
$ds          = DIRECTORY_SEPARATOR;

$storeFolder = 'uploads';

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    $targetFile =  $targetPath. session_id(). $_FILES['file']['name'] ;
    $_SESSION['file'] = $targetFile;
    move_uploaded_file($tempFile,$targetFile);
}
echo json_encode($_SESSION['file'])  ;
?>
