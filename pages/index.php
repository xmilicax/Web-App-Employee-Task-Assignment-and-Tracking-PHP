<?php

session_start();

// provera da li je korisnik ulogovan
if (isset($_SESSION['username']) && ($_SESSION['status'] === 'Verifikovan')) {
    switch ($_SESSION['id_tip_korisnika']) {
        case '1':
            header('Location: tipovi_korisnika/administrator.php');
            exit();
        case 2:
            header('Location: tipovi_korisnika/rukovodilac_odeljenja.php');
            exit();
        case 3:
            header('Location: tipovi_korisnika/izvrsilac.php');
            exit();
        default:
            header('Location: tipovi_korisnika/greska.php');
            exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna</title>
    <link rel="icon" href="../css/img/logo_krug.png">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
         <h1>Početna</h1>
    </header>
    <form>
        <a href="login.php" class="button">Prijava</a>
        <br>
        <a href="register.php" class="button">Registracija</a>
    </form>
    <footer>
        Milica Lazić I011-41/2020<br>Copyright © 2024
    </footer>
</body>
</html>