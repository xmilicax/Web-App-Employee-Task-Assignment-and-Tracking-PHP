<?php

require_once __DIR__ . '/../database/Korisnik.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naziv = $_POST['naziv'];

    try {
        Korisnik::dodaj_grupu_zadataka($naziv);
        header("Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/napravi_grupu_zadataka.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/napravi_grupu_zadataka.php?status=greska");
        exit();
    }

}