<?php

require_once __DIR__ . '/../database/Korisnik.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['dropdown'];
    $naziv = $_POST['naziv'];

    try {
        Korisnik::izmeni_grupu_zadataka($id, $naziv);
        header( "Location:../pages/tipovi_korisnika/radnje_ruk_odlj/izmeni_grupu_zadataka.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header( "Location:../pages/tipovi_korisnika/radnje_ruk_odlj/izmeni_grupu_zadataka.php?status=greska");
        exit();
    }

}