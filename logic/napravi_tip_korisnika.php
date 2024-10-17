<?php

require_once __DIR__ . '/../database/Korisnik.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naziv = $_POST['naziv'];

    try {
        Korisnik::napravi_tip_korisnika($naziv);
        header("Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_tip_korisnika.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_tip_korisnika.php?status=greska");
        exit();
    }

}