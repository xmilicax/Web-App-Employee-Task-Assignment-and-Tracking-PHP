<?php

require_once __DIR__ . '/../database/Korisnik.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['dropdown'];
    $naziv = $_POST['naziv'];

    try {
        Korisnik::izmeni_tip_korisnika($id, $naziv);
        header("Location: ../pages/tipovi_korisnika/radnje_administrator/izmeni_tip_korisnika.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/tipovi_korisnika/radnje_administrator/izmeni_tip_korisnika.php?status=greska");
        exit();
    }

}