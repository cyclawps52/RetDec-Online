<?php
if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $filePath = '/var/www/html/uploads/'.$fileName;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($filePath);
        exit;
    }else{
		echo "<script type='text/javascript'>alert('Error downloading decompiled code file.');</script>";
		echo "<script type='text/javascript'>window.location.replace(\"index.html\");</script>";
		exit;
    }
}

?>
