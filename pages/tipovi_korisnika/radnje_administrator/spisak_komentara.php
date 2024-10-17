<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

// Check user type
if ($_SESSION['id_tip_korisnika'] != 1) {
    header('Location: ../../login.php?status=restricted_access');
    exit();
}

require_once __DIR__ . '/../../../database/Korisnik.php';
require_once __DIR__ . '/../../../database/Komentar.php';
require_once __DIR__ . '/../../../database/Zadatak.php';

$komentari = Komentar::vrati_komentare();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spisak komentara</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Spisak komentara</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<div class="container">
    <table id="tasksTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Zadatak</th>
            <th>Korisnik</th>
            <th>Sadržaj</th>
            <th>Kreirano</th>
            <th>Izmenjeno</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($komentari as $komentar): ?>
            <tr>
                <td><?= $komentar->id ?></td>
                <td><?= Zadatak::vrati_naslov($komentar->id_zadatka) ?></td>
                <td><?= Korisnik::vrati_ime_korisnika($komentar->id_korisnika) ?></td>
                <td><?= $komentar->sadrzaj ?></td>
                <td><?= $komentar->kreirano ?></td>
                <td><?= $komentar->izmenjeno ?? '/' ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>