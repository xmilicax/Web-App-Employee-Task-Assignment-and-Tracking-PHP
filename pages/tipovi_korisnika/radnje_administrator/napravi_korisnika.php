<?php

session_start();

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

$tipovi_korisnika = Korisnik::vrati_tipove_korisnika();

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'username_iskoriscen') {
        $poruka_greska = '<br>Username je već iskorišćen.<br><br>';
    } else if ($_GET['status'] == 'email_iskoriscen') {
        $poruka_greska = '<br>Email je već iskorišćen.<br><br>';
    } else if ($_GET['status'] == 'empty') {
        $poruka_greska = '<br>Sva obavezna polja moraju biti ispunjena.<br><br>';
    } else if ($_GET['status'] == 'pass_mismatch') {
        $poruka_greska = '<br>Lozinke se ne poklapaju.<br><br>';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = '<br>Došlo je do greške.<br>Pokušajte ponovo.<br><br>';
    }else if ($_GET['status'] == 'uspesno') {
        $poruka_uspesno = '<br>Uspešno kreiran korisnik.<br><br>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Napravi korisnika</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Napravi korisnika</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<form action="../../../logic/napravi_korisnika.php" method="post" class="form-group">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="username">Korisničko ime:</label>
    <input type="text" name="username" id="username" placeholder="Unesite korisničko ime" required>

    <label for="password">Lozinka:</label>
    <input type="password" name="password" id="password" placeholder="Unesite password" required>

    <label for="password_repeat">Ponovljena lozinka:</label>
    <input type="password" name="password_repeat" id="password" placeholder="Unesite ponovljenu lozinku" required>

    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" placeholder="Unesite e-mail" required>

    <label for="ime_prezime">Ime i prezime:</label>
    <input type="text" name="ime_prezime" id="ime_prezime" placeholder="Unesite ime i prezime" required>

    <label for="ime_prezime">Tip korisnika:</label>
    <select name="dropdown" id="id_grupe" required>
        <?php foreach ($tipovi_korisnika as $tip_korisnika): ?>
            <option value="<?= $tip_korisnika->id ?>"><?= $tip_korisnika->naziv ?></option>
        <?php endforeach; ?>
    </select>

    <label for="broj_telefona">Telefon (opciono):</label>
    <input type="text" name="broj_telefona" id="broj_telefona" placeholder="Unesite telefon">

    <label for="datum_rodjenja">Datum rođenja (opciono):</label>
    <input type="date" name="datum_rodjenja" id="datum_rodjenja">

    <br>
    <input type="submit" name="register" class="button" value="Napravi korisnika">

</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>