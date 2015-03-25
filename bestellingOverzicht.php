<?php

use Bestellingen\Service\Service;
use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

session_start();

$message = '';
$errormessage = '';

if (!isset($_COOKIE['userId'])) {
    header('location:reLogin.php');
    exit(0);
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'alreadyOrdered': $errormessage = 'You already ordered for this date';
            break;
        case 'notOrdered' : $errormessage = 'Error ordering bestelling';
            break;
        case 'geenDatum' : $errormessage = 'Select afhaaldatum';
            break;
        default: $errormessage = 'Something went wrong!';
    }
}

if (isset($_SESSION['winkelmandje']) && !empty($_SESSION['winkelmandje'])) {
    $sessionWinkelmandje = $_SESSION['winkelmandje'];
    $userId = $_COOKIE['userId'];
    try {
        $stdOverzicht = Service::getBestellingoverzicht($sessionWinkelmandje, $userId);
        if (empty($stdOverzicht->vrijeDatums)) {
            header('location:alleBestellingen.php?message=maxBesteld');
            exit(0);
        }
    } catch (Exception $e) {
        $errormessage = 'Unable to get overzicht from database';
    }
} else {
    header('location:bestelmenu.php?message=emptyWinkelmandje');
    exit(0);
}


$userVoornaam = $_COOKIE['voornaam'];
$userId = $_COOKIE['userId'];
$oUser = UserService::getById($userId);

$view = $twig->render('bestellingOverzicht.twig', array('errormessage' => $errormessage, 'stdOverzicht' => $stdOverzicht, 'voornaam' => $userVoornaam));
print($view);


