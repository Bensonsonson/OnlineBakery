<?php

namespace Bestellingen\Data;

use Bestellingen\Entities\Bestelling;
use Bestellingen\Entities\User;
use PDO;

class BestellingDAO {

    //create
    public function newBestelling($userid, $datum) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'INSERT INTO bakkerij_bestellingen (userid, datum) VALUES (:userid, :datum)';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userid', $userid);
        $sth->bindParam(':datum', $datum);
        $sth->execute();
        $lastInsertId = $dbh->lastInsertId();
        $dbh = null;
        return $lastInsertId;
    }

    //read
    public function getByUserIdenDatum($userid, $datum) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT bakkerij_users.id as userid, naam, voornaam, straat, huisnummer, postcode, woonplaats, 
                emailadres, paswoord, blocked, admin, bakkerij_bestellingen.id as bestellingid, datum 
                FROM bakkerij_users, bakkerij_bestellingen
                WHERE bakkerij_users.id = bakkerij_bestellingen.userid 
                AND bakkerij_bestellingen.userid = :userid AND datum = :datum'; 
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userid', $userid);
        $sth->bindParam(':datum', $datum);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            $row = $resultSet->fetch();
            if ($row) {
                $oUser = User::create($row['userid'], $row['naam'], $row['voornaam'], $row['straat'], $row['huisnummer'], $row['postcode'], $row['woonplaats'], $row['emailadres'], $row['paswoord'], $row['blocked'], $row['admin']);
                $oBestelling = Bestelling::create($row['bestellingid'], $oUser, $row['datum']);
                $dbh = null;
                return $oBestelling;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getByUserId($userid) {
        $bestellinglijst = array();
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT bakkerij_users.id as userid, naam, voornaam, straat, huisnummer, postcode, woonplaats, emailadres,
                paswoord, blocked, admin, bakkerij_bestellingen.id as bestellingid, datum 
                FROM bakkerij_users, bakkerij_bestellingen 
                WHERE bakkerij_users.id = bakkerij_bestellingen.userid 
                AND bakkerij_bestellingen.userid = :userid
                ORDER BY datum ASC';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userid', $userid);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            foreach ($resultSet as $row) {
                $oUser = User::create($row['userid'], $row['naam'], $row['voornaam'], $row['straat'], $row['huisnummer'], $row['postcode'], $row['woonplaats'], $row['emailadres'], $row['paswoord'], $row['blocked'], $row['admin']);
                $oBestelling = Bestelling::create($row['bestellingid'], $oUser, $row['datum']);
                array_push($bestellinglijst, $oBestelling);
            }
            $dbh = null;
            return $bestellinglijst;
        } else {
            return FALSE;
        }
    }

    //update
    public function updateDatumById($id, $datum) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_bestelregels SET datum = :datum WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->bindParam(':datum', $datum);
        $sth->execute();
        $dbh = null;
    }

    //delete
    public function deleteById($id) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'DELETE FROM bakkerij_bestellingen WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $dbh = null;
    }

}
