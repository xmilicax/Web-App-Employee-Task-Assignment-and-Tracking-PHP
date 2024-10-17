<?php

session_start();

require_once '../database/Korisnik.php';

$new_password = $_POST['new_password'];
$new_password_repeat = $_POST['new_password_repeat'];
$token_pass = $_SESSION['token_pass'];

if ($new_password !== $new_password_repeat) {
    header('Location: ../pages/change_pass.php?status=pass_mismatch');
    exit();
}

if (!(Korisnik::proveri_token_pass($token_pass))) {
    header('Location: ../pages/change_pass.php?status=istekao_token');
    exit();
}

$email = Korisnik::vrati_email_pass($token_pass);

if ($email !== null) {
    Korisnik::izmena_lozinke($email, $new_password);
    header('Location: ../pages/login.php?status=promenjena_lozinka');
    exit();
} else {
    header('Location: ../pages/change_pass.php?status=greska');
    exit();
}