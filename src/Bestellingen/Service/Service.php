<?php

namespace Bestellingen\Service;

use Bestellingen\Data\BestellingDAO;
use Bestellingen\Data\BestelregelDAO;
use Bestellingen\Data\ProductDAO;
use Bestellingen\Exceptions\alreadyOrderedException;
use stdClass;

class Service {

    //----------------Bundelfuncties----------------------------------------------------------------//
    public function getWinkelmandje($sessionWinkelmandje) {
        $winkelmandje = array();
        foreach ($sessionWinkelmandje as $productid => $aantal) {
            $oProduct = self::getProductById($productid);
            $stdWinkelmandjeLijn = new stdClass();
            $stdWinkelmandjeLijn->oProduct = $oProduct;
            $stdWinkelmandjeLijn->aantal = $aantal;
            array_push($winkelmandje, $stdWinkelmandjeLijn);
        }
        return $winkelmandje;
    }

    public function getAllBestellingen($userId) { //alles ophalen, user, bestellingobject, bestelregelobjecten, broodjes
        $stdOverzicht = new stdClass();
        $oUser = UserService::getById($userId);
        $stdOverzicht->user = $oUser;
        $stdOverzicht->bestellingLijst = array();
        $bestellingLijst = self::getBestellinglijstByUserId($userId);
        foreach ($bestellingLijst as $oBestelling) {
            $stdBestelling = new stdClass();
            $stdBestelling->oBestelling = $oBestelling;
            $stdBestelling->producten = array();
            $bestellingId = $oBestelling->getId();
            $bestelregelLijst = self::getBestelregelsByBestellingId($bestellingId);
            foreach ($bestelregelLijst as $oBestelregel) {
                $stdProduct = new stdClass();
                $oProduct = $oBestelregel->getOProduct();
                $stdProduct->oProduct = $oProduct;
                $stdProduct->aantal = $oBestelregel->getAantal();
                //stdProduct in productenlijst stoppen
                $stdBestelling->producten[] = $stdProduct;
            }
            //stdBestelling in bestellinglijst stoppen
            $stdOverzicht->bestellingLijst[] = $stdBestelling;
        }
        return $stdOverzicht;
    }

    public function getBestellingoverzicht($sessionWinkelmandje, $userId) {
        $stdOverzicht = new stdClass();
        $stdOverzicht->winkelmandjeLijnen = self::getWinkelmandje($sessionWinkelmandje);
        $stdOverzicht->oUser = UserService::getById($userId);
        $stdOverzicht->vrijeDatums = array();
        for ($i = 1; $i < 4; $i++) {
            $afhaaldatum = date('Y-m-d', strtotime(' +' . $i . ' day'));
            $oBestelling = self::getBestellingByUserIdenDatum($userId, $afhaaldatum); //deze functie testen!!!!
            if (!$oBestelling) {
                $stdOverzicht->vrijeDatums[] = $afhaaldatum;
            }
        }
        return $stdOverzicht;
    }

    public function bestelWinkelmandje($sessionWinkelmandje, $userId, $afhaaldatum) {
        $oBestelling = self::getBestellingByUserIdenDatum($userId, $afhaaldatum);
        if ($oBestelling) {
            throw new alreadyOrderedException();
        } else {
            $lastInsertIdBestelling = self::newBestelling($userId, $afhaaldatum);
            foreach ($sessionWinkelmandje as $productId => $aantal) {
                self::newBestelregel($lastInsertIdBestelling, $productId, $aantal);
            }
        }
    }

    //---------------DAO functies-------------------------------------------------------------------//
    //________BESTELLING___________//
    //create
    public function newBestelling($userid, $datum) {
        $lastInsertId = BestellingDAO::newBestelling($userid, $datum);
        return $lastInsertId;
    }

    //read
    public function getBestellingByUserIdenDatum($userid, $datum) {
        $oBestelling = BestellingDAO::getByUserIdenDatum($userid, $datum);
        return $oBestelling;
    }

    public function getBestellinglijstByUserId($userid) { //geeft bestellingobjecten terug -> bestelregels ontbreken
        $bestellinglijst = BestellingDAO::getByUserId($userid);
        return $bestellinglijst;
    }

    //update
    public function updateBestellingDatumById($id, $datum) {
        BestellingDAO::updateDatumById($id, $datum);
    }

    //delete
    public function deleteBestellingById($id) {
        BestellingDAO::deleteById($id);
    }

    //________BESTELREGEL___________//
    //create
    public function newBestelregel($bestellingid, $productid, $aantal) {
        BestelregelDAO::newBestelregel($bestellingid, $productid, $aantal);
    }

    //read
    public function getBestelregelsByBestellingId($bestellingid) { //opzoeking via id, weergave via objecten!!!
        $bestelregellijst = BestelregelDAO::getByBestellingId($bestellingid);
        return $bestelregellijst;
    }

    //update - enkel aantal update nodig?
    public function updateBestelregelAantalById($id, $aantal) {
        BestelregelDAO::updateAantalById($id, $aantal);
    }

    //delete
    public function deleteBestelregelById($id) {
        BestelregelDAO::deleteById($id);
    }

    //________PRODUCT___________//
    //create
    public function newProduct($naam, $prijs) {
        ProductDAO::newProduct($naam, $prijs);
    }

    //read
    public function getProductById($id) {
        $oProduct = ProductDAO::getById($id);
        return $oProduct;
    }

    public function getAllProducten() {
        $productenlijst = ProductDAO::getAll();
        return $productenlijst;
    }

    //update
    public function updateProductById($id, $naam, $prijs) {
        ProductDAO::updateById($id, $naam, $prijs);
    }

    //delete
    public function deleteProductById($id) {
        ProductDAO::deleteById($id);
    }

}
