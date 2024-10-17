<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require 'vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    function sendEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        $token = 'http://localhost/ppp2_projekat1/logic/verifikacija.php?token=' . urlencode($token);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME');
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        //Recipients
        $mail->setFrom(getenv('SMTP_USERNAME'), 'PPP2 Projekat');
        $mail->addAddress($email);               //Name is optional

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Verifikacija profila za PPP2 projekat';
        $mail->Body = "Potvrdite Vaš profil klikom na <a href='$token'>link</a>. ";
        $mail->send();
    }

    function reset_pass($email, $token_pass)
    {
        $mail = new PHPMailer(true);
        $token_pass = 'http://localhost/ppp2_projekat1/pages/change_pass.php?token=' . urlencode($token_pass);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME');
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        //Recipients
        $mail->setFrom(getenv('SMTP_USERNAME'), 'PPP2 Projekat');
        $mail->addAddress($email);               //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Promena lozinke za PPP2 projekat';
        $mail->Body = "Promenite lozinku klikom na <a href='$token_pass'>link</a>. ";
        $mail->send();
    }