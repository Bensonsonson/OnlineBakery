<?php

require_once 'twigdoctrineloader.php';

session_start();

//totaalprijs hier al in session steken?

if(isset($_GET['id'])){
    $productid = $_GET['id'];
    if(isset($_SESSION['winkelmandje'][$productid])){
        $_SESSION['winkelmandje'][$productid] += 1;
    }
    else{
        $_SESSION['winkelmandje'][$productid] = 1;
    }
}
header('location:bestelmenu.php');
exit(0);