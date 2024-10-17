<?php

require_once '../database/Korisnik.php';
require_once '../vendor/autoload.php';
require_once '../mejl.php';


try {
    $email = $_POST['email'];
    $token_pass = Korisnik::vrati_token_pass($email);
    $_SESSION['token_pass'] = $token_pass;

    reset_pass($email, $token_pass);

    header("Location: ../pages/recover.php?status=uspesno");
    exit();
} catch (Exception $e) {
    header("Location: ../pages/recover.php?status=greska");
    exit();
}