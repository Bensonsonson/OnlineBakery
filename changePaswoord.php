<?php

use Bestellingen\Exceptions\userNotFoundException;
use Bestellingen\Exceptions\wrongPasswordException;
use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

session_start();

$voornaam = '';
$errormessage = '';
$message = '';

if (!isset($_COOKIE['userId'])) {
        header('location: index.php?message=reLogin');
    exit(0);

}

if (isset($_COOKIE['voornaam'])) {
    $voornaam = $_COOKIE['voornaam'];
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'userNotFound': $errormessage = 'User not found';
            break;
        case 'wrongOldPaswoord': $errormessage = 'Wrong old paswoord entered';
            break;
        case 'empty' : $errormessage = 'Fill in all the fields';
            break;
        case 'noEmail': $errormessage = 'No valid emailaddress';
            break;
        default: $errormessage = 'Something went wrong';
    }
}

if (isset($_POST["submit"])) {
    if (!empty($_POST['emailadres']) && !empty($_POST['oldPaswoord']) && !empty($_POST['newPaswoord'])) {
        if(filter_var($_POST['emailadres'],FILTER_VALIDATE_EMAIL)){
        $emailadres = $_POST['emailadres'];}
        else{
            header('location:changePaswoord.php?error=noEmail');
            exit(0);
        }
        $oldPaswoord = $_POST['oldPaswoord'];
        $newPaswoord = $_POST['newPaswoord'];
        try {
            UserService::changePaswoord($emailadres, $oldPaswoord, $newPaswoord);
            header('location:editProfile.php?message=paswoordChanged');
            exit(0);
        } catch (Exception $e) {
            if ($e instanceof wrongPasswordException) {
                header('location:changePaswoord.php?error=wrongOldPaswoord');
                exit(0);
            }
            if ($e instanceof userNotFoundException) {
                header('location:changePaswoord.php?error=userNotFound');
                exit(0);
            }
            header('location:changePaswoord.php?error');
            exit(0);
        }
    }
    else{
        header('location:changePaswoord.php?error=empty');
        exit(0);
    }
}

$emailadres = $_SESSION['emailadres'];

$view = $twig->render('changePaswoord.twig', array('voornaam'=>$voornaam, 'emailadres'=>$emailadres, 'message'=>$message, 'errormessage'=>$errormessage));
print($view);
