<?php

//Alles in Service zetten ! 


use Bestellingen\Exceptions\noNewPaswoordSentException;
use Bestellingen\Exceptions\userNotFoundException;
use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';
$errormessage = "";

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch($error){
        case 'paswoordNotSent': $errormessage = 'No new paswoord was sent to your emailadres';
            break;
        case 'userNotFound' : $errormessage = 'No user registered to this emailaddress';
            break;
        case 'database': $errormessage = 'Error accessing database';
            break;
    }
}
if (isset($_POST['paswoordVergeten'])) {
    if(filter_var($_POST['paswoordVergeten'],FILTER_VALIDATE_EMAIL)){
        $emailadres = $_POST["paswoordVergeten"];
    }
    else{
        header('location:index.php?error=noEmail');
        exit(0);
    }
    try {
        UserService::getNewPaswoord($emailadres);
        header('location:index.php?message=paswoordSent');
        exit(0);
    } catch (Exception $e) {
        if($e instanceof noNewPaswoordSentException){
            header('location: paswoordVergeten.php?error=paswoordNotSent');
            exit(0);
        }
        elseif($e instanceof userNotFoundException){
            header('location: paswoordVergeten.php?error=userNotFound');
            exit(0);
        }
        else{
            header('location: paswoordVergeten.php?error=database');
            exit(0);
        }
    }
}

$view = $twig->render('paswoordVergeten.twig', array('errormessage' => $errormessage));
print($view);

