<?php

session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 2) {
    header('Location: ../login.php?status=restricted_access');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rukovodilac odeljenja - Panel</title>
    <link rel="icon" href="../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
    <h1>Dobrodošao, <?php echo $username; ?></h1>
    <h3>Vaša uloga je rukovodilac odeljenja.</h3>
    <a href="../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<nav>
    <ul>
        <li class="dropdown">
            <a href="#">Grupe</a>
            <div class="dropdown-content">
                <a href="radnje_ruk_odlj/napravi_grupu_zadataka.php">Napravi grupu</a> <br>
                <a href="radnje_ruk_odlj/izmeni_grupu_zadataka.php">Izmeni grupu</a> <br>
                <a href="radnje_ruk_odlj/izbrisi_grupu_zadataka.php">Izbriši grupu</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Zadaci</a>
            <div class="dropdown-content">
                <a href="radnje_ruk_odlj/napravi_zadatak.php">Napravi zadatak</a> <br>
                <a href="radnje_ruk_odlj/izmeni_zadatak.php">Izmeni zadatak</a> <br>
                <a href="radnje_ruk_odlj/izbrisi_zadatak.php">Izbriši zadatak</a> <br>
            </div>
        </li>
        <li class="dropdown">
            <a href="radnje_ruk_odlj/spisak_zadataka_rukovodilac.php">Lista zadataka</a>
        </li>
        <li class="dropdown">
            <a href="radnje_ruk_odlj/filtriraj_rukovodilac.php">Pretraži zadatke</a>
        </li>
    </ul>
</nav>

<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>