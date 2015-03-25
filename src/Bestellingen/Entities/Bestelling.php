<?php

namespace Bestellingen\Entities;

class Bestelling{
    private static $idMap = array();
    
    private $id;
    private $oUser;
    private $datum;
    
    private function __construct($id,$oUser,$datum) {
        $this->id=$id;
        $this->oUser=$oUser;
        $this->datum=$datum;
    }
    
    public static function create($id,$oUser,$datum){
        if(!isset(self::$idMap[$id])){
            self::$idMap[$id] = new Bestelling($id, $oUser, $datum);
        }
        return self::$idMap[$id];
    }
    static function getIdMap() {
        return self::$idMap;
    }

    function getId() {
        return $this->id;
    }

    function getOUser() {
        return $this->oUser;
    }

    function getDatum() {
        return $this->datum;
    }

    static function setIdMap($idMap) {
        self::$idMap = $idMap;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setOUser($oUser) {
        $this->oUser = $oUser;
    }

    function setDatum($datum) {
        $this->datum = $datum;
    }


}

