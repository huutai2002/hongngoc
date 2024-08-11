<?php
if ($_FILES['file']['name']) {
    $targetDir = "img/";
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $targetDir . $fileName;
    
    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        echo $fileName;
    } else {
        echo 'error';
    }
}
?>
