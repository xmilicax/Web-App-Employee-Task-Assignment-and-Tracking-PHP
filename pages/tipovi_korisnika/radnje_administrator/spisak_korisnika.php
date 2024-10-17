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

$korisnici = Korisnik::svi_korisnici();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spisak korisnika</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Spisak korisnika</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<div class="container">
    <table id="tasksTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>E-mail</th>
            <th>Ime i prezime</th>
            <th>Tip korisnika</th>
            <th>Broj telefona</th>
            <th>Datum rođenja</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($korisnici as $korisnik): ?>
            <tr>
                <td><?= $korisnik->id ?></td>
                <td><?= $korisnik->username ?></td>
                <td><?= $korisnik->email ?></td>
                <td><?= $korisnik->ime_prezime ?></td>
                <td><?= Korisnik::vrati_tip_korisnika2($korisnik->id_tip_korisnika) ?></td>
                <td><?= $korisnik->broj_telefona ?? '/' ?></td>
                <td><?= $korisnik->datum_rodjenja ?? '/' ?></td>
                <td><?= $korisnik->status ?></td>
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