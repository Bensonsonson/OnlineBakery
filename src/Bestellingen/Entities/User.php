<?php

namespace Bestellingen\Entities;

class User {

    private static $idMap = array();
    private $id;
    private $naam;
    private $voornaam;
    private $straat;
    private $huisnummer;
    private $postcode;
    private $woonplaats;
    private $emailadres;
    private $paswoord;
    private $blocked;
    private $admin;

    private function __construct($id, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $paswoord, $blocked, $admin) {
        $this->id = $id;
        $this->naam = $naam;
        $this->voornaam = $voornaam;
        $this->straat = $straat;
        $this->huisnummer = $huisnummer;
        $this->postcode = $postcode;
        $this->woonplaats = $woonplaats;
        $this->emailadres = $emailadres;
        $this->paswoord = $paswoord;
        $this->blocked = $blocked;
        $this->admin = $admin;
    }
    
    public static function create($id, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $paswoord, $blocked, $admin){
        if(!isset(self::$idMap[$id])){
            self::$idMap[$id] = new User($id, $naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $paswoord, $blocked, $admin);
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

    function getVoornaam() {
        return $this->voornaam;
    }

    function getStraat() {
        return $this->straat;
    }

    function getHuisnummer() {
        return $this->huisnummer;
    }

    function getPostcode() {
        return $this->postcode;
    }

    function getWoonplaats() {
        return $this->woonplaats;
    }

    function getEmailadres() {
        return $this->emailadres;
    }

    function getPaswoord() {
        return $this->paswoord;
    }

    function getBlocked() {
        return $this->blocked;
    }

    function getAdmin() {
        return $this->admin;
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

    function setVoornaam($voornaam) {
        $this->voornaam = $voornaam;
    }

    function setStraat($straat) {
        $this->straat = $straat;
    }

    function setHuisnummer($huisnummer) {
        $this->huisnummer = $huisnummer;
    }

    function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    function setWoonplaats($woonplaats) {
        $this->woonplaats = $woonplaats;
    }

    function setEmailadres($emailadres) {
        $this->emailadres = $emailadres;
    }

    function setPaswoord($paswoord) {
        $this->paswoord = $paswoord;
    }

    function setBlocked($blocked) {
        $this->blocked = $blocked;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }


}
