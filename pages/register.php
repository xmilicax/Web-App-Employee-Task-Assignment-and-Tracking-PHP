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

$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'username_iskoriscen') {
        $poruka_greska = 'Username je već iskorišćen.';
    } else if ($_GET['status'] == 'email_iskoriscen') {
        $poruka_greska = 'Email je već iskorišćen.';
    } else if ($_GET['status'] == 'empty') {
        $poruka_greska = 'Sva obavezna polja moraju biti ispunjena.';
    } else if ($_GET['status'] == 'pass_mismatch') {
        $poruka_greska = 'Lozinke se ne poklapaju.';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = 'Došlo je do greške.<br>Pokušajte ponovo.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="icon" href="../css/img/logo_krug.png">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="index.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Registracija</h1>
</header>
<form action="../logic/registracija.php" method="post" class="form-group">
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="username">Korisničko ime:</label>
    <input type="text" name="username" id="username" placeholder="Unesite korisničko ime" required>

    <label for="password">Lozinka:</label>
    <input type="password" name="password" id="password" placeholder="Unesite password" required>

    <label for="password_repeat">Ponovljena lozinka:</label>
    <input type="password" name="password_repeat" id="password" placeholder="Unesite ponovljenu lozinku"required>

    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" placeholder="Unesite e-mail" required>

    <label for="ime_prezime">Ime i prezime:</label>
    <input type="text" name="ime_prezime" id="ime_prezime" placeholder="Unesite ime i prezime" required>

    <label for="broj_telefona">Telefon (opciono):</label>
    <input type="text" name="broj_telefona" id="broj_telefona" placeholder="Unesite telefon">

    <label for="datum_rodjenja">Datum rođenja (opciono):</label>
    <input type="date" name="datum_rodjenja" id="datum_rodjenja">

    <br>
    <input type="submit" name="register" class="button" value="Registruj se">
    <br>

    <div class="form-links">
        <p>Već si registrovan?</p>
        <a href="login.php">Prijavi se</a>
    </div>
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>