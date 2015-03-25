<?php

use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

session_start();

$message = '';
$errormessage = '';


if (!isset($_COOKIE['userId'])) {
    header('location: reLogin.php');
    exit(0);
}
$userId = $_COOKIE['userId'];

if (isset($_GET['message'])) {
    $getMessage = $_GET['message'];
    switch ($getMessage) {
        case 'updated' : $message = 'Profile updated';
            break;
        case 'paswoordChanged' : $message = 'Paswoord successfully changed';
            break;
    }
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'notUpdated': $errormessage = 'Profile not updated';
            break;
        case 'noInt':$errormessage = 'Postcode must be integer';
            break;
        default: $errormessage = 'Something went wrong';
    }
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['naam'])) {
        $newNaam = $_POST['naam'];
        UserService::updateNaam($userId, $newNaam);
    }
    if (!empty($_POST['voornaam'])) {
        $newVoornaam = $_POST['voornaam'];
        UserService::updateVoornaam($userId, $newVoornaam);
    }
    if (!empty($_POST['straat'])) {
        $newStraat = $_POST['straat'];
        UserService::updateStraat($userId, $newStraat);
    }
    if (!empty($_POST['huisnummer'])) {
        $newHuisnummer = $_POST['huisnummer'];
        UserService::updateHuisnummer($userId, $newHuisnummer);
    }
    if (!empty($_POST['postcode'])) {
    if(filter_var($_POST['postcode'],FILTER_VALIDATE_INT)){
        $newPostcode = $_POST['postcode'];
        UserService::updatePostcode($userId, $newPostcode);
    }else{
        header('location:editProfile.php?error=noInt');
        exit(0);
    }
    }
    if (!empty($_POST['woonplaats'])) {
        $newWoonplaats = $_POST['woonplaats'];
        UserService::updateWoonplaats($userId, $newWoonplaats);
    }
    header('location:editProfile.php?message=updated');
    exit(0);
}

$oUser = UserService::getById($userId);
$voornaam = $oUser->getVoornaam();
$_SESSION['emailadres'] = $oUser->getEmailadres();

$view = $twig->render('editProfile.twig', array('voornaam' => $voornaam, 'user' => $oUser, 'errormessage' => $errormessage, 'message' => $message));
print($view);

