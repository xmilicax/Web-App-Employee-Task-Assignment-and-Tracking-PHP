<?php
session_start();

// provera da li je korisnik ulogovan
if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php?status=expired_session');
    exit();
}

if ($_SESSION['id_tip_korisnika'] != 1) {
    header('Location: ../login.php?error=restricted_access');
    $errorMessage = 'Sesija je istekla. Molimo ulogujte se ponovo.';
    exit();
}

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'uspesno') {
        $poruka_uspesno = '<br>Tip korisnika je uspešno kreiran.<br><br>';
    } else if ($_GET['status'] == 'greska') {
        $poruka_greska = '<br>Došlo je do greške pri kreiranju tipa korisnika. Pokušajte ponovo.<br><br>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Napravi tip korisnika</title>
    <link rel="icon" href="../../../css/img/logo_krug.png">
    <link rel="stylesheet" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header class="header1">
    <a href="../administrator.php" class="ikonica"><i class="fas fa-home"></i></a>
    <h1>Napravi tip korisnika</h1>
    <a href="../../../logic/logout.php" class="ikonica"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></a>
</header>
<form action="../../../logic/napravi_tip_korisnika.php" method="POST">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <input type="text" name="naziv" placeholder="Unesite naziv tipa korisnika">
    <input type="submit" value="Napravi tipa korisnika" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>
