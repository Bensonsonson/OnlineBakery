<?php

require_once 'twigdoctrineloader.php';

//use
session_start();

//totaalprijs hier al in session steken?

if (isset($_GET['id'])) {
    $productid = $_GET['id'];
    if (isset($_SESSION['winkelmandje'][$productid])) {
        if ($_SESSION['winkelmandje'][$productid] > 1)
            $_SESSION['winkelmandje'][$productid] -= 1;
        else {
            unset($_SESSION['winkelmandje'][$productid]);
        }
    }
}
header('location:bestelmenu.php');
exit(0);
