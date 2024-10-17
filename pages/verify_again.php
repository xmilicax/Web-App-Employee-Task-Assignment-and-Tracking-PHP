<?php

session_start();

// provera da li je korisnik ulogovan
if (isset($_SESSION['username']) && ($_SESSION['status'] === 'Verifikovan')) {
    switch ($_SESSION['id_tip_korisnika']) {
        case 1:
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

$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'greska') {
        $poruka_greska = '<br>Došlo je do greške pri verifikaciji.<br>Pokušajte ponovo.<br><br>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikuj profil</title>
    <link rel="icon" href="../css/img/logo_krug.png">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="index.php" id="ikonica"><i class="fas fa-home"></i></a>
    <h1>Verifikuj profil</h1>
</header>
<form action="../logic/verifikacija_link_ponovo.php" method="post">
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="email"><b>E-mail adresa profila:</b></label>
    <input type="email" name="email" id="email" placeholder="Unesite e-mail adresu registrovanog profila" required>

    <input type="submit" value="Pronađi profil" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>