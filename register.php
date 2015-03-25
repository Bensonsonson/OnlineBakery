<?php

require_once 'twigdoctrineloader.php';

use Bestellingen\Exceptions\existingUserException;
use Bestellingen\Exceptions\noRegistrationException;
use Bestellingen\Service\UserService;

if (!empty($_POST['registeremail']) && !empty($_POST['naam']) && !empty($_POST['voornaam']) && !empty($_POST['straat']) && !empty($_POST['huisnummer']) && !empty($_POST['postcode']) && !empty($_POST['woonplaats'])) {
    if (filter_var($_POST['registeremail'],FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['registeremail'];
    }
    else{
        header('location:index.php?error=noEmail');
        exit(0);
    }
    $naam = $_POST['naam'];
    $voornaam = $_POST['voornaam'];
    $straat = $_POST['straat'];
    $huisnummer = $_POST['huisnummer'];
    if(filter_var($_POST['postcode'],FILTER_VALIDATE_INT)){
    $postcode = $_POST['postcode'];}
    else{
        header('location:index.php?error=noInt');
        exit(0);
    }
    $woonplaats = $_POST['woonplaats'];
    try {
        UserService::register($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $email);
        header('location:index.php?message=emailsent');
        exit(0);
    } catch (Exception $e) {           //Op deze manier geen exception over het hoofd zien
        if ($e instanceof existingUserException) {
            header('location:index.php?error=existingUser');
            exit(0);
        } elseif ($e instanceof noRegistrationException) {
            header('location:index.php?error=noRegistration');
            exit(0);
        } else {
            header('location:index.php?error=database');
            exit(0);
        }
    }
} else {
    header('location:index.php?error=empty');
    exit(0);
}