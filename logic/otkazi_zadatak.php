<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

require_once __DIR__ . '/../database/Zadatak.php';

try {
    $id_zadatka = $_GET['id'] ?? null;
    Zadatak::otkazi_zadatak($id_zadatka);

    header("Location: ../pages/tipovi_korisnika/radnje_izvrsilac/spisak_zadataka_izvrsilac.php?status=uspesno");
    exit();
} catch (Exception $e) {
    header("Location: ../pages/tipovi_korisnika/radnje_izvrsilac/spisak_zadataka_izvrsilac.php?status=greska");
    exit();
}