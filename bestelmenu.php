<?php

use Bestellingen\Service\Service;
use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

session_start();

$message = '';
$errormessage = '';
$winkelmandje = array();
$admin = '';

if (!isset($_COOKIE['userId'])) {
    header('location:reLogin.php');
    exit(0);
} else {
    $id = $_COOKIE['userId'];
    $oUser = UserService::getById($id);
    $blocked = $oUser->getBlocked();
    if ($blocked == 1) {
        header('location:alleBestellingen.php?error=blocked');
        exit(0);
    }
}

if (isset($_GET['message'])) {
    $getMessage = $_GET['message'];
    switch ($getMessage) {
        case 'emptyWinkelmandje': $message = 'Empty winkelmandje. Geen bestelling overzicht mogelijk';
            break;
    }
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'emptyList': $errormessage = 'Productenlijst leeg';
            break;
        case 'WMdatabase': $errormessage = 'Error getting winkelmandje from database';
            break;
        case 'PLdatabase': $errormessage = 'Error getting productenlijst from database';
            break;
        default: $errormessage = 'Something went wrong!';
    }
}

if (isset($_SESSION['winkelmandje'])) {
    try {
        $winkelmandje = Service::getWinkelmandje($_SESSION['winkelmandje']);
    } catch (Exception $e) {
        header('location:bestelmenu.php?error=WMdatabase');
        exit(0);
    }
}

try {
    $productenlijst = Service::getAllProducten();
} catch (Exception $e) {
    if ($e instanceof emptyListException) {
        header('location:bestelmenu.php?error=emptyList');
        exit(0);
    } else {
        header('location:bestelmenu.php?error=PLdatabase');
        exit(0);
    }
}

$userVoornaam = $_COOKIE['voornaam'];

$view = $twig->render('bestelmenu.twig', array('errormessage' => $errormessage,
    'message' => $message,
    'productenlijst' => $productenlijst,
    'winkelmandje' => $winkelmandje,
    'voornaam' => $userVoornaam
        ));
print($view);

