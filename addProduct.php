<?php

require_once 'twigdoctrineloader.php';

use Bestellingen\Service\Service;

session_start();

//totaalprijs hier al in session steken?

if (isset($_POST['id'])) {
    $productid = $_POST['id'];
    if (isset($_SESSION['winkelmandje'][$productid])) {
        $_SESSION['winkelmandje'][$productid] += 1;
        echo 'existing';
    } else {
        $_SESSION['winkelmandje'][$productid] = 1;
        echo 'new';
    }

} else {
    echo 'failed';
}