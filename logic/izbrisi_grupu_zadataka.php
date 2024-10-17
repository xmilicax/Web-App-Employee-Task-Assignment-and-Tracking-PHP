<?php

require_once __DIR__ . '/../database/Zadatak.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['dropdown'];

    try {
        Korisnik::izbrisi_grupu_zadataka($id);
        header("Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/izbrisi_grupu_zadataka.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/izbrisi_grupu_zadataka.php?status=greska");
        exit();
    }
}