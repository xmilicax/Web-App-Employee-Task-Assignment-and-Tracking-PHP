<?php

session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 1) {
    header('Location: ../login.php?error=expired_login');
    $errorMessage = 'Sesija je istekla. Molimo ulogujte se ponovo.';
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - Panel</title>
    <link rel="icon" href="../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
    <h1>Dobrodošao, <?php echo $username; ?></h1>
    <h3>Vaša uloga je administrator.</h3>
    <a href="../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<nav>
    <ul>
        <li class="dropdown">
            <a href="#">Tipovi korisnika</a>
            <div class="dropdown-content">
                <a href="radnje_administrator/napravi_tip_korisnika.php">Napravi novi tip</a> <br>
                <a href="radnje_administrator/izmeni_tip_korisnika.php">Izmeni tip</a> <br>
                <a href="radnje_administrator/spisak_tipova_korisnika.php" >Spisak tipova</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Korisnik</a>
            <div class="dropdown-content">
                <a href="radnje_administrator/napravi_korisnika.php">Napravi novog korisnika</a> <br>
                <a href="radnje_administrator/izmeni_korisnika.php">Izmeni korisnika</a> <br>
                <a href="radnje_administrator/spisak_korisnika.php">Spisak svih korisnika</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Grupe radnih zadataka</a>
            <div class="dropdown-content">
                <a href="radnje_administrator/napravi_grupu_zadataka.php">Napravi grupu</a> <br>
                <a href="radnje_administrator/izmeni_grupu_zadataka.php">Izmeni grupu</a> <br>
                <a href="radnje_administrator/spisak_grupa_zadataka.php">Spisak svih grupa</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Radni zadatak</a>
            <div class="dropdown-content">
                <a href="radnje_administrator/napravi_zadatak.php">Napravi zadatak</a> <br>
                <a href="radnje_administrator/izmeni_zadatak.php">Izmeni zadatak</a> <br>
                <a href="radnje_administrator/spisak_zadataka.php">Spisak svih zadataka</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Komentar</a>
            <div class="dropdown-content">
                <a href="radnje_administrator/izmeni_komentar.php">Izmeni komentar</a>
                <a href="radnje_administrator/spisak_komentara.php">Spisak svih komentara</a>
            </div>
        </li>
    </ul>
</nav>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>