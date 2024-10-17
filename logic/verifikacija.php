<?php

session_start();

require_once '../database/Korisnik.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    Korisnik::verifikacija($token);
    header('Location: ../pages/login.php?status=verified');
    exit();
} else {
    header('Location: ../pages/verify_again.php?status=not_verified');
    exit();
}
