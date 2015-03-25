<?php

require_once 'twigdoctrineloader.php';

if(!isset($_COOKIE['emailadres'])){
    header('location:index.php?message=reLogin');
    exit(0);
}

$emailadres = $_COOKIE['emailadres'];

$view = $twig->render('reLogin.twig', array('emailadres'=>$emailadres));
print($view);

