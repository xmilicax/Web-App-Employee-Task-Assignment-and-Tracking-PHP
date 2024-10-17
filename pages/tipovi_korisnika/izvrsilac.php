<?php

session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 3) {
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
    <title>Izvršilac - Panel</title>
    <link rel="icon" href="../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
    <h1>Dobrodošao, <?php echo $username; ?></h1>
    <h3>Vaša uloga je izvršilac.</h3>
    <a href="../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<nav>
    <ul>
        <li><a href="radnje_izvrsilac/spisak_zadataka_izvrsilac.php">Spisak zadataka</a></li>
        <li><a href="radnje_izvrsilac/filtriranje_izvrsilac.php">Filtriranje</a></li>
    </ul>
</nav>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>