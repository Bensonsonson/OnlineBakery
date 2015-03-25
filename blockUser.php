<?php

use Bestellingen\Service\UserService;

require_once 'twigdoctrineloader.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    try {
        UserService::blockById($userId);
        header('location:adminPanel.php?message=blocked');
        exit(0);
    } catch (Exception $e) {
        header('location:adminPanel.php?error=database');
        exit(0);
    }
}
else{
    header('location:adminPanel.php');
    exit(0);
}

