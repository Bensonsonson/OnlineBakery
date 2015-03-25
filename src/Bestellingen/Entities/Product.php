<?php

namespace Bestellingen\Entities;

class Product{
    private static $idMap = array();
    
    private $id;
    private $naam;
    private $prijs;
    
    private function __construct($id,$naam,$prijs) {
        $this->id=$id;
        $this->naam=$naam;
        $this->prijs=$prijs;
    }
    public static function create($id,$naam,$prijs){
        if(!isset(self::$idMap[$id])){
            self::$idMap[$id] = new Product($id, $naam, $prijs);
        }
        return self::$idMap[$id];
    }
    static function getIdMap() {
        return self::$idMap;
    }

    function getId() {
        return $this->id;
    }

    function getNaam() {
        return $this->naam;
    }

    function getPrijs() {
        return $this->prijs;
    }

    static function setIdMap($idMap) {
        self::$idMap = $idMap;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNaam($naam) {
        $this->naam = $naam;
    }

    function setPrijs($prijs) {
        $this->prijs = $prijs;
    }

}
