<?php

require_once '../database/Korisnik.php';
require_once '../vendor/autoload.php';
require_once '../mejl.php';


try {
    $email = $_POST['email'];
    $token = Korisnik::vrati_token($email);

    sendEmail($email, $token);

    header("Location: ../pages/login.php?status=uspesno_link");
    exit();
} catch (Exception $e) {
    header("Location: ../pages/verify_again.php?status=greska");
    exit();
}