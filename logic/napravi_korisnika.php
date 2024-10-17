<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
$email = $_POST['email'];
$ime_prezime = $_POST['ime_prezime'];
$id_tip_korisnika = $_POST['dropdown'];
$broj_telefona = $_POST['broj_telefona'] ?: null;
$datum_rodjenja = $_POST['datum_rodjenja'] ?: null;
$status = "Verifikovan";

// Provera da li su sva potrebna polja popunjena
if (empty($username) || empty($password) || empty($password_repeat) || empty($email) || empty($ime_prezime)) {
    header('Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_korisnika.php?status=empty');
    exit();
}

// Provera da li se lozinke poklapaju
if ($password !== $password_repeat) {
    header('Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_korisnika.php?status=pass_mismatch');
    exit();
}

require_once '../database/Korisnik.php';

// Provera da li korisničko ime već postoji
if (Korisnik::provera_username($username)) {
    header('Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_korisnika.php?status=username_iskoriscen');
    exit();
}

// Provera da li email već postoji
if (Korisnik::provera_email($email)) {
    header('Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_korisnika.php?status=email_iskoriscen');
    exit();
}

try {
    $id = Korisnik::registracija_admin(
        $username,
        hash('sha512', $password),
        $email,
        $ime_prezime,
        $id_tip_korisnika,
        $broj_telefona,
        $datum_rodjenja,
        $status
    );

    header("Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_korisnika.php?status=uspesno");
    exit();
} catch (Exception $e) {
    header("Location: ../pages/tipovi_korisnika/radnje_administrator/napravi_korisnika.php?status=greska");
    exit();
}