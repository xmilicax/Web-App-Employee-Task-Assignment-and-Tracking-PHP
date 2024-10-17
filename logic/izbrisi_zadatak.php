<?php

require_once __DIR__ . '/../database/Zadatak.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['dropdown'];

    try {
        Zadatak::izbrisi_zadatak($id);
        header("Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/izbrisi_zadatak.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/tipovi_korisnika/radnje_ruk_odlj/izbrisi_zadatak.php?status=greska");
        exit();
    }
}
