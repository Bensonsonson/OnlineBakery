<?php

use Bestellingen\Service\Service;

require_once 'twigdoctrineloader.php';

if (!isset($_COOKIE['userId'])) {
    header('location:reLogin.php');
    exit(0);
}

$bestellinglijst = Service::getAllBestellingen();

$view = $twig->render('adminBestellinglijst.twig', array('bestellinglijst' => $bestellinglijst));
print($view);
