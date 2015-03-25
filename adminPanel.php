<?php

use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

$message = '';
$errormessage = '';
$userVoornaam = $_COOKIE['voornaam'];

if (!isset($_COOKIE['userId'])) {
    header('location:reLogin.php');
    exit(0);
}

if(isset($_GET['message'])){
    $getMessage = $_GET['message'];
    switch($getMessage){
        case 'blocked': $message = 'User successfully blocked';
            break;
    }
}

if(isset($_GET['error'])){
    $error = $_GET['error'];
    switch($error){
        case 'database': $errormessage = 'User not blocked. Something went wrong';
            break;
    }
}

$userList = UserService::getAll();

$view = $twig->render('adminPanel.twig', array('errormessage' => $errormessage, 'message' => $message, 
                        'voornaam' => $userVoornaam, 'userlist'=>$userList));
print($view);
