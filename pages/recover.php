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

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'uspesno':
            $poruka_uspesno = '<br>Na e-mail adresu poslat je link za resetovanje lozinke.<br>
                               Ukoliko niste dobili poruku, proverite da li ste dobro<br>uneli e-mail adresu.<br><br>';
            break;
        case 'greska':
            $poruka_greska = '<br>Došlo je do greške pri slanju mejla.<br>Pokušajte ponovo.<br><br>';
            break;
        case 'istekao_token':
            $poruka_greska = '<br>Token je istekao.<br>Molimo generišite novi ponovnim unosom.<br><br>';
            break;
        default:
            $poruka_greska = '<br>Došlo je do nepoznate greške.<br>Pokušajte ponovo.<br><br>';
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pronađi profil</title>
    <link rel="icon" href="../css/img/logo_krug.png">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="index.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Pronađi profil</h1>
</header>
<form action="../logic/pass_reset_email.php" method="POST">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="email"><b>Unesi e-mail adresu tvog profila.</b></label>
    <input type="email" name="email" id="email" required>

    <input type="submit" value="Pronađi profil" class="button">
    <br>
    <div class="form-links">
        <p>Znaš lozinku?</p>
        <a href="login.php">Prijavi se</a>
        <br>
        <p>Nemaš profil?</p>
        <a href="register.php">Registruj se</a>
    </div>
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>