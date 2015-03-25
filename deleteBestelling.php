<?php

use Bestellingen\Service\Service;

require_once 'twigdoctrineloader.php';

if (isset($_GET['id'])) {
    $bestellingId = $_GET['id'];
    if (isset($_GET['datum'])) {
        $afhaaldatum = $_GET['datum'];
        $huidigeDatum = date('Y-m-d');
        if ($huidigeDatum < $afhaaldatum) {
            try {
                Service::deleteBestellingById($bestellingId);
                header('location:alleBestellingen.php?message=deleted');
                exit(0);
            } catch (Exception $e) {
                header('location:alleBestellingen.php?error=notDeleted');
                exit(0);
            }
        } else {
            header('location: alleBestellingen.php?error=telaat');
            exit(0);
        }
    }
} else {
    header('location:bestellingOverzicht.php');
    exit(0);
}