<?php

use Bestellingen\Service\Service;

require_once 'twigdoctrineloader.php';

$message = '';
$errormessage = '';

if (!isset($_COOKIE['userId'])) {
    header('location:reLogin.php');
    exit(0);
}

if (isset($_GET['message'])) {
    $getMessage = $_GET['message'];
    switch ($getMessage) {
        case 'deleted': $message = 'Bestelling was annuled';
            break;
        case 'geplaatst': $message = 'Bestelling successfully geplaatst';
            break;
        case 'maxBesteld' : $message = 'Maximum aantal bestellingen geplaatst';
            break;
    }
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'notDeleted' : $errormessage = 'Bestelling was not deleted';
            break;
        case 'telaat' : $errormessage = 'Te laat om bestelling te annuleren (ten laatste 1 dag voor afhaaldatum)';
            break;
        case 'blocked': $errormessage = "You are blocked. Can't make any more bestellingen";
            break;
        default: $errormessage = 'Something went wrong!';
    }
}

$userId = $_COOKIE['userId'];
$userVoornaam = $_COOKIE['voornaam'];
$stdAlleBestellingen = Service::getAllBestellingen($userId);

$view = $twig->render('alleBestellingen.twig', array('message' => $message, 'errormessage' => $errormessage, 'stdAlleBestellingen' => $stdAlleBestellingen, 'voornaam'=>$userVoornaam));
print($view);

