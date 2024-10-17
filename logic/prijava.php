<?php

if (!isset($_POST['email'])) {
    header('Location: ../pages/register.php');
    exit();
}

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

require_once __DIR__ . '/../database/Korisnik.php';

$korisnik = Korisnik::prijava($email, $password);

if ($korisnik === null) {
    header('Location: ../pages/login.php?status=greska');
    exit();
}

$_SESSION['korisnik_id'] = $korisnik->id;
$_SESSION['username'] = $korisnik->username;
$_SESSION['id_tip_korisnika'] = $korisnik->id_tip_korisnika;
$_SESSION['ime_i_prezime'] = $korisnik->ime_i_prezime;
$_SESSION['status'] = $korisnik->status;

$tip_korisnika = Korisnik::vrati_tip_korisnika($korisnik->id_tip_korisnika);

if ($tip_korisnika === null) {
    header('Location: ../pages/tipovi_korisnika/greska.php');
    exit();
}

if ($korisnik->status != 'Verifikovan') {
    header('Location: ../pages/login.php?status=not_verified');
    exit();
}

switch ($tip_korisnika->id) {
    case 1:
        header('Location: ../pages/tipovi_korisnika/administrator.php');
        exit();
    case 2:
        header('Location: ../pages/tipovi_korisnika/rukovodilac_odeljenja.php');
        exit();
    case 3:
        header('Location: ../pages/tipovi_korisnika/izvrsilac.php');
        exit();
    default:
        header('Location: ../pages/tipovi_korisnika/greska.php');
        exit();
}


