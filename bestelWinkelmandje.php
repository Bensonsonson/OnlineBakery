<?php

use Bestellingen\Service\Service;

require_once 'twigdoctrineloader.php';

session_start();

if(!isset($_POST['afhaaldatum'])){
    header('location:bestellingOverzicht.php?error=geenDatum');
    exit(0);
}
if (isset($_SESSION['winkelmandje'])) {
    $winkelmandje = $_SESSION['winkelmandje'];
    $userId = $_COOKIE['userId'];///////////////////////////////////nog vervangen door $_cookie user
    $afhaaldatum = $_POST['afhaaldatum']; /////////////////////nog vervangen door SELECT option waarde -> in session steken?
    try {
        Service::bestelWinkelmandje($winkelmandje, $userId, $afhaaldatum);
        session_destroy();
        header('location:alleBestellingen.php?message=geplaatst');
        exit(0);
    } catch (Exception $e) {
        if($e instanceof alreadyOrdered){
            header('location:bestellingOverzicht.php?error=alreadyOrdered');
            exit(0);
        }else{
            header('location:bestellingOverzicht.php?error=notOrdered');
            exit(0);
        }
    }
} else {
    header('location:bestelmenu.php?message=vulWinkelmandje');
    exit(0);
}
