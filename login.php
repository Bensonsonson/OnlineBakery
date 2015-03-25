<?php

require_once 'twigdoctrineloader.php';

use Bestellingen\Exceptions\userNotFoundException;
use Bestellingen\Exceptions\wrongPasswordException;
use Bestellingen\Service\UserService;

if (isset($_POST['submit'])) {
    if (!empty($_POST['paswoord'])) {
        $paswoord = $_POST['paswoord'];
        if (!empty($_POST['email'])) {
            if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
                $emailadres = $_POST['email'];
            } else {
                header('location:index.php?error=noEmail');
                exit(0);
            }
        } elseif (!empty($_COOKIE['emailadres'])) {
            $emailadres = $_COOKIE['emailadres'];
        } else {
            header('location:index.php?error=empty');
            exit(0);
        }
        try {
            $userId = UserService::login($emailadres, $paswoord);
            $oUser = UserService::getById($userId);
            $userVoornaam = $oUser->getVoornaam();
            setcookie('userId', $userId, time() + 1200);
            setcookie('voornaam', $userVoornaam, time() + 1200);
            setcookie('emailadres', $emailadres, time() + 86400);
            if ($oUser->getAdmin() == 1) {
                header('location:adminPanel.php');
                exit(0);
            } else {
                header('location:bestelmenu.php');
                exit(0);
            }
        } catch (Exception $e) {
            if ($e instanceof wrongPasswordException) {
                header('location:index.php?error=wrongPassword');
                exit(0);
            } elseif ($e instanceof userNotFoundException) {
                header('location:index.php?error=userNotFound');
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
} else {
    header('location:index.php');
    exit(0);
}



    