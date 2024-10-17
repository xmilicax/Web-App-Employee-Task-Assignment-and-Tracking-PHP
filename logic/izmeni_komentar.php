<?php

require_once __DIR__ . '/../database/Komentar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['dropdown'];
    $sadrzaj = $_POST['sadrzaj'];

    try {
        Komentar::izmeni_komentar($id, $sadrzaj);
        header( "Location:../pages/tipovi_korisnika/radnje_administrator/izmeni_komentar.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header( "Location:../pages/tipovi_korisnika/radnje_administrator/izmeni_komentar.php?status=greska");
        exit();
    }

}