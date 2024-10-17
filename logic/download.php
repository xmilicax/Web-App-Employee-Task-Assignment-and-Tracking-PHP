<?php

session_start();

if (isset($_GET['file_path'])) {
    $file_path = '../' . $_GET['file_path'];

    if (file_exists($file_path)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));

        readfile($file_path);
        exit;
    } else {
        echo $file_path;
        echo filesize($file_path);
        echo (basename($file_path));
        echo "Greška. Fajl ne postoji.";
    }
} else {
    echo "Greška. Fajl ne postoji.";
}
?>
