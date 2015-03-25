<?php

namespace Bestellingen\Entities;

class Bestelregel {

    private static $idMap = array();
    private $id;
    private $oBestelling;
    private $oProduct;
    private $aantal;

    private function __construct($id, $oBestelling, $oProduct, $aantal) {
        $this->id = $id;
        $this->oBestelling = $oBestelling;
        $this->oProduct = $oProduct;
        $this->aantal = $aantal;
    }

    public static function create($id, $oBestelling, $oProduct, $aantal) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Bestelregel($id, $oBestelling, $oProduct, $aantal);
        }
        return self::$idMap[$id];
    }

    static function getIdMap() {
        return self::$idMap;
    }

    function getId() {
        return $this->id;
    }

    function getOBestelling() {
        return $this->oBestelling;
    }

    function getOProduct() {
        return $this->oProduct;
    }

    function getAantal() {
        return $this->aantal;
    }

    static function setIdMap($idMap) {
        self::$idMap = $idMap;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setOBestelling($oBestelling) {
        $this->oBestelling = $oBestelling;
    }

    function setOProduct($oProduct) {
        $this->oProduct = $oProduct;
    }

    function setAantal($aantal) {
        $this->aantal = $aantal;
    }

}
