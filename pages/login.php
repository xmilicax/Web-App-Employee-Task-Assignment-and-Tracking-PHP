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
    $poruka = '';

    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 'uspesno':
                $poruka_uspesno = '<br>Uspešno ste se registrovali.<br>
            Neophodno je da verifikujete profil pomoću linka koji Vam je poslat na unetu e-mail adresu.<br><br>';
                break;
            case 'uspesno_link':
                $poruka_uspesno = '<br>Link za verifikaciju je ponovo poslat na uneti mejl.<br><br>';
                break;
            case 'greska':
                $poruka_greska = '<br>Pogrešan e-mail i/ili lozinka.<br> Pokušajte ponovo.<br><br>';
                break;
            case 'expired_session':
                $poruka_greska = '<br>Sesija je istekla.<br>Molimo ulogujte se ponovo.<br><br>';
                break;
            case 'restricted_access':
                $poruka_greska = '<br>Stranica koju želite da posetite nije namenjena<br>
            Vašoj ulozi. Molimo prijavite se na profil<br>
            koji ima tu mogućnost.<br><br>';
                break;
            case 'verified':
                $poruka_uspesno = '<br>Uspešno ste verifikovali profil.<br><br>';
                break;
            case 'not_verified':
                $poruka_greska = '<br>Niste verifikovali profil.<br>Molimo verifikujte profil pomoću linka koji je<br>
            poslat na Vašu e-mail adresu.<br><br>';
                $poruka = 'Ne možete da pronađete e-mail? <a href="verify_again.php">
            Ponovo pošalji link za verifikaciju.</a><br><br>';
                break;
            case 'sent':
                $poruka_uspesno = '<br>Link za verifikaciju je poslat na unetu e-mail adresu.<br><br>';
                break;
            case 'promenjena_lozinka':
                $poruka_uspesno = '<br>Lozinka je uspešno promenjena.<br><br>';
                break;
            default:
                $poruka_greska = '<br>Došlo je do nepoznate greške.<br><br>';
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link rel="icon" href="../css/img/logo_krug.png">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="index.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Prijava</h1>
</header>
<form action="../logic/prijava.php" method="post">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>
    <p class="form-links"><?= $poruka ?></p>

    <label for="email"><b>E-mail:</b></label>
    <input type="email" name="email" id="email" placeholder="Unesite e-mail adresu" required>

    <label for="password"><b>Lozinka:</b></label>
    <input type="password" name="password" id="password" placeholder="Unesite lozinku" required>

    <input type="submit" name="login" value="Login" class="button">
    <br>
    <div class="form-links">
        <p>Zaboravio/la si lozinku?</p>
        <a href="recover.php">Promeni lozinku</a>
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