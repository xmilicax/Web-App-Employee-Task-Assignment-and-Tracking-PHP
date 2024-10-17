<?php

require_once __DIR__ . '/../database/Korisnik.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['dropdown'];
    $username = $_POST['username'];
    $password = hash('sha512', $_POST['password']);
    $email = $_POST['email'];
    $ime_prezime = $_POST['ime_prezime'];
    $id_tip_korisnika = $_POST['dropdown2'];
    $broj_telefona = $_POST['broj_telefona'] ?: null;
    $datum_rodjenja = $_POST['datum_rodjenja'] ?: null;
    $status = $_POST['status'];

    try {
        Korisnik::izmeni_korisnika($id, $username, $password, $email, $ime_prezime, $id_tip_korisnika, $broj_telefona, $datum_rodjenja, $status);
        header( "Location:../pages/tipovi_korisnika/radnje_administrator/izmeni_korisnika.php?status=uspesno");
        exit();
    } catch (Exception $e) {
        header( "Location:../pages/tipovi_korisnika/radnje_administrator/izmeni_korisnika.php?status=greska");
        exit();
    }

}