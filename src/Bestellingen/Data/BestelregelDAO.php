<?php

namespace Bestellingen\Data;

use Bestellingen\Entities\Bestelling;
use Bestellingen\Entities\Bestelregel;
use Bestellingen\Entities\Product;
use Bestellingen\Entities\User;
use PDO;

class BestelregelDAO {

    //create
    public function newBestelregel($bestellingid, $productid, $aantal) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'INSERT INTO bestelregels (bestellingid, productid, aantal) VALUES(:bestellingid,:productid,:aantal)';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':bestellingid', $bestellingid);
        $sth->bindParam(':productid', $productid);
        $sth->bindParam(':aantal', $aantal);
        $sth->execute();
        $dbh = null;
    }

    //read
    public function getById($id) {
        
    }

    public function getByBestellingId($bestellingid) { //opzoeking via id, weergave via objecten!!!
        $bestellijst = array();
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT users.id as userid, users.naam as naam, voornaam, straat, huisnummer, postcode, woonplaats,
                emailadres, paswoord, blocked, admin, bestellingen.id as bestellingid, datum, bestelregels.id as bestelregelid,
                aantal, producten.id as productid, producten.naam as productnaam, prijs
                FROM users, bestellingen, bestelregels, producten
                WHERE users.id = bestellingen.userid AND bestellingen.id = bestelregels.bestellingid AND producten.id = bestelregels.productid
                AND bestelregels.bestellingid = :bestellingid';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':bestellingid', $bestellingid);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            foreach ($resultSet as $row) {
                //alle objecten aanmaken nodig om bestelregel te maken
                $oUser = User::create($row['userid'], $row['naam'], $row['voornaam'], $row['straat'], $row['huisnummer'], $row['postcode'], $row['woonplaats'], $row['emailadres'], $row['paswoord'], $row['blocked'],$row['admin']);
                $oBestelling = Bestelling::create($row['bestellingid'], $oUser, $row['datum']);
                $oProduct = Product::create($row['productid'], $row['productnaam'], $row['prijs']);
                $oBestelregel = Bestelregel::create($row['bestelregelid'], $oBestelling, $oProduct, $row['aantal']);
                array_push($bestellijst, $oBestelregel);
            }
            $dbh = null;
            return $bestellijst;
        } else {
            return FALSE;
        }
    }

    //update - enkel aantal update nodig?
    public function updateAantalById($id, $aantal) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bestelregels SET aantal = :aantal WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->bindParam(':aantal', $aantal);
        $sth->execute();
        $dbh = null;
    }

    //delete
    public function deleteById($id) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'DELETE FROM bestelregels WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $dbh = null;
    }

}
