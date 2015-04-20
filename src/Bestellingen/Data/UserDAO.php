<?php

namespace Bestellingen\Data;

use Bestellingen\Entities\User;
use PDO;

class UserDAO {

    //create
    public function registerUser($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $paswoord) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'INSERT INTO bakkerij_users (naam,voornaam,straat,huisnummer,postcode,woonplaats,emailadres,paswoord)
                VALUES (:naam,:voornaam,:straat,:huisnummer,:postcode,:woonplaats,:emailadres,:paswoord)';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':naam', $naam);
        $sth->bindParam(':voornaam', $voornaam);
        $sth->bindParam(':straat', $straat);
        $sth->bindParam(':huisnummer', $huisnummer);
        $sth->bindParam(':postcode', $postcode);
        $sth->bindParam(':woonplaats', $woonplaats);
        $sth->bindParam(':emailadres', $emailadres);
        $sth->bindParam(':paswoord', $paswoord);
        $sth->execute();
        $dbh = null;
    }

    //read
    public function getById($id) { //controle bestaande gebruiker in service
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT * FROM bakkerij_users WHERE id=:id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            $row = $resultSet->fetch();
            if ($row) {
                $oUser = User::create($row['id'], $row['naam'], $row['voornaam'], $row['straat'], $row['huisnummer'], $row['postcode'], $row['woonplaats'], $row['emailadres'], $row['paswoord'], $row['blocked'], $row['admin']);
                $dbh = null;
                return $oUser;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getByEmailadres($emailadres) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT * FROM bakkerij_users WHERE emailadres=:emailadres';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':emailadres', $emailadres);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            $row = $resultSet->fetch();
            if ($row) {
                $oUser = User::create($row['id'], $row['naam'], $row['voornaam'], $row['straat'], $row['huisnummer'], $row['postcode'], $row['woonplaats'], $row['emailadres'], $row['paswoord'], $row['blocked'], $row['admin']);
                $dbh = null;
                return $oUser;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getAll() {
        $userList = array();
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT * FROM bakkerij_users';
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            foreach ($resultSet as $row) {
                $oUser = User::create($row['id'], $row['naam'], $row['voornaam'], $row['straat'], $row['huisnummer'], $row['postcode'], $row['woonplaats'], $row['emailadres'], $row['paswoord'], $row['blocked'], $row['admin']);
                array_push($userList, $oUser);
            }
            $dbh = null;
            return $userList;
        } else {
            return FALSE;
        }
    }

    //update
    public function changePaswoord($emailadres, $paswoord) { //controle juiste gebruiker in service + geupdate user returnen in service of doormailen
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET paswoord = :paswoord WHERE emailadres = :emailadres';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':emailadres', $emailadres);
        $sth->bindParam(':paswoord', $paswoord);
        $sth->execute();
        $dbh = null;
    }

    public function setNewPaswoord($emailadres, $newPaswoord) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET paswoord = :newPaswoord WHERE emailadres = :emailadres';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':emailadres', $emailadres);
        $sth->bindParam(':newPaswoord', $newPaswoord);
        $sth->execute();
        $dbh = null;
    }

    public function updateNaam($userId, $newNaam) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET naam = :newNaam WHERE id = :userId';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userId', $userId);
        $sth->bindParam(':newNaam', $newNaam);
        $sth->execute();
        $dbh = null;
    }

    public function updateVoornaam($userId, $newVoornaam) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET voornaam = :newVoornaam WHERE id = :userId';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userId', $userId);
        $sth->bindParam(':newVoornaam', $newVoornaam);
        $sth->execute();
        $dbh = null;
    }

    public function updateStraat($userId, $newStraat) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET straat = :newStraat WHERE id = :userId';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userId', $userId);
        $sth->bindParam(':newStraat', $newStraat);
        $sth->execute();
        $dbh = null;
    }

    public function updateHuisnummer($userId, $newHuisnummer) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET huisnummer = :newHuisnummer WHERE id = :userId';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userId', $userId);
        $sth->bindParam(':newHuisnummer', $newHuisnummer);
        $sth->execute();
        $dbh = null;
    }

    public function updatePostcode($userId, $newPostcode) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET postcode = :newPostcode WHERE id = :userId';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userId', $userId);
        $sth->bindParam(':newPostcode', $newPostcode);
        $sth->execute();
        $dbh = null;
    }

    public function updateWoonplaats($userId, $newWoonplaats) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET woonplaats = :newWoonplaats WHERE id = :userId';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':userId', $userId);
        $sth->bindParam(':newWoonplaats', $newWoonplaats);
        $sth->execute();
        $dbh = null;
    }

    //in adminService?
    public function blockById($id) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE bakkerij_users SET blocked = 1 WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $dbh = null;
    }

    //delete
    public function deleteById($id) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'DELETE FROM bakkerij_users WHERE id = :id';
        $sth->bindParam(':id', $id);
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $dbh = null;
    }

}
