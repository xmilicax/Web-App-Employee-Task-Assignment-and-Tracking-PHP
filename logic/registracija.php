<?php

session_start();

// Tip korisnika je automatski ID 3, jer samo izvršioci mogu da se registruju
$id_tip_korisnika = 3;
$username = $_POST['username'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
$email = $_POST['email'];
$ime_prezime = $_POST['ime_prezime'];
$broj_telefona = $_POST['broj_telefona']  ?: null;
$datum_rodjenja = $_POST['datum_rodjenja']  ?: null;
$token = bin2hex(random_bytes(32));

// Provera da li su sva potrebna polja popunjena
if (empty($username) || empty($password) || empty($password_repeat) || empty($email) || empty($ime_prezime)) {
    header('Location: ../pages/register.php?status=empty');
    exit();
}

// Provera da li se lozinke poklapaju
if ($password !== $password_repeat) {
    header('Location: ../pages/register.php?status=pass_mismatch');
    exit();
}

require_once '../database/Korisnik.php';
require_once '../vendor/autoload.php';
require_once '../mejl.php';

// Provera da li korisničko ime već postoji
if (Korisnik::provera_username($username)) {
    header('Location: ../pages/register.php?status=username_iskoriscen');
    exit();
}

// Provera da li email već postoji
if (Korisnik::provera_email($email)) {
    header('Location: ../pages/register.php?status=email_iskoriscen');
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {
    $id = Korisnik::registracija(
        $username,
        hash('sha512', $password),
        $email,
        $ime_prezime,
        $id_tip_korisnika,
        $broj_telefona,
        $datum_rodjenja,
        $token
    );

    sendEmail($email, $token);

    header("Location: ../pages/login.php?status=uspesno");
    exit();
} catch (Exception $e) {
    header("Location: ../pages/register.php?status=greska");
    exit();
}