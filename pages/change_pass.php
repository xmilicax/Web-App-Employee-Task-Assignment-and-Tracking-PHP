<?php

session_start();

//čuvamo token u skladištu kako bi ta vrednost postojala nakon prosleđivanja na izmena_lozinke.php
$token_pass = $_GET['token'] ?? null;
if ($token_pass === null) {
    //vraćamo na stranicu za generisanje tokena
    header('Location: recover.php?status=greska');
    exit();
}

$_SESSION['token_pass'] = $token_pass;

$poruka_uspesno = '';
$poruka_greska = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'greska') {
        $poruka_greska = '<br>Došlo je do greške.<br>Pokušajte ponovo.<br><br>';
    } else if ($_GET['status'] == 'pass_mismatch') {
        $poruka_greska = '<br>Lozinke se ne poklapaju.<br>Pokušajte ponovo.<br><br>';
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
    <a href="index.php" ><i class="fas fa-home"></i></a>
    <h1>Promena lozinke</h1>
</header>
<form action="../logic/izmena_lozinke.php" method="POST">
    <p id="status_uspesno"><?= $poruka_uspesno ?></p>
    <p id="status_greska"><?= $poruka_greska ?></p>

    <label for="password"><b>Nova lozinka:</b></label>
    <input type="password" name="new_password" id="new_password" placeholder="Unesite novu lozinku" required>

    <label for="password_repeat"><b>Ponovljena nova lozinka:</b></label>
    <input type="password" name="new_password_repeat" id="new_password_repeat" placeholder="Unesite ponovljenu novu lozinku"required>

    <input type="submit" value="Promeni šifru" class="button">
</form>
<footer>
    Milica Lazić I011-41/2020<br>Copyright © 2024
</footer>
</body>
</html>