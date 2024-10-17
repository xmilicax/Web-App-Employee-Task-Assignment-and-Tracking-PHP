<?php

session_start();
session_destroy();
header('Location: http://localhost/ppp2_projekat1/pages/index.php');
exit();