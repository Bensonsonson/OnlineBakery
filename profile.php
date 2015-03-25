<?php

use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

$message = '';
$errormessage = '';

if (!isset($_COOKIE['userId'])) {
    header('location:reLogin.php');
    exit(0);
}

$userId = $_COOKIE['userId'];
$oUser = UserService::getById($userId);
$voornaam = $oUser->getVoornaam();

$view = $twig->render('profile.twig', array('user' => $oUser, 'voornaam' => $voornaam, 'message' => $message));
print($view);
