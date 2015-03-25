<?php

namespace Bestellingen\Service;

use Bestellingen\Data\UserDAO;
use Bestellingen\Exceptions\existingUserException;
use Bestellingen\Exceptions\noNewPaswoordSentException;
use Bestellingen\Exceptions\noRegistrationException;
use Bestellingen\Exceptions\userNotFoundException;
use Bestellingen\Exceptions\wrongPasswordException;

class UserService {

    //----------------------------Bundelfuncties---------------------------//
    public function register($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres) {
        $oUser = self::getByEmailadres($emailadres);
        if ($oUser) {
            throw new existingUserException();
        } else {
            $paswoord = '';
            $paswoordLength = 6;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            for ($i = 0; $i < $paswoordLength; $i++) {
                $paswoord .= $characters[rand(0, $charactersLength - 1)];
            }
            $hashedPaswoord = sha1($paswoord);
            $to = $emailadres;
            $subject = "Bakkerij login paswoord";
            $message = "Dit is jouw paswoord om in te loggen :" . $paswoord . " ";
            $header = "From:bakkerijben@bakkerijbenmail.com \r\n";
            $mailsent = mail($to, $subject, $message, $header);
            if ($mailsent) {
                self::registerUser($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $hashedPaswoord);
            } else {
                throw new noRegistrationException();
            }
        }
    }

    public function login($emailadres, $paswoord) {
        $oUser = self::getByEmailadres($emailadres);
        if ($oUser) {
            $userId = $oUser->getId();
            //paswoord checken
            $hashedPaswoord = $oUser->getPaswoord();
            if (sha1($paswoord) == $hashedPaswoord) {
                return $userId;
            } else {
                throw new wrongPasswordException();
            }
        } else {
            throw new userNotFoundException();
        }
    }

    public function getNewPaswoord($emailadres) {
        $oUser = self::getByEmailadres($emailadres);
        if ($oUser) {
            $newPaswoord = '';
            $paswoordLength = 6;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            for ($i = 0; $i < $paswoordLength; $i++) {
                $newPaswoord .= $characters[rand(0, $charactersLength - 1)];
            }
            $hashedPaswoord = sha1($newPaswoord);
            $to = $emailadres;
            $subject = "Bakkerij login paswoord";
            $message = "Dit is jouw paswoord om in te loggen :" . $newPaswoord . " ";
            $header = "From:bakkerijben@bakkerijbenmail.com \r\n";
            $mailsent = mail($to, $subject, $message, $header);
            if ($mailsent) {
                self::setNewPaswoord($emailadres, $hashedPaswoord);
            } else {
                throw new noNewPaswoordSentException();
            }
        } else {
            throw new userNotFoundException();
        }
    }

    //-------------------------DAO Functies----------------------------//
    //create
    public function registerUser($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $paswoord) {
        UserDAO::registerUser($naam, $voornaam, $straat, $huisnummer, $postcode, $woonplaats, $emailadres, $paswoord);
    }

    //read
    public function getById($userId) {
        $oUser = UserDAO::getById($userId);
        return $oUser;
    }

    public function getByEmailadres($emailadres) {
        $oUser = UserDAO::getByEmailadres($emailadres);
        return $oUser;
    }
    
    public function getAll(){
        $userList = UserDAO::getAll();
        return $userList;
    }

    //update    
    public function changePaswoord($emailadres, $oldPaswoord, $newPaswoord) { 
        $oUser = self::getByEmailadres($emailadres);
        if ($oUser) {
            $hashedPaswoord = $oUser->getPaswoord();
            $hashedOldPaswoord = sha1($oldPaswoord);
            if ($hashedOldPaswoord == $hashedPaswoord) {
                $hashedNewPaswoord = sha1($newPaswoord);
                UserDAO::changePaswoord($emailadres, $hashedNewPaswoord);
            } else {
                throw new wrongPasswordException();
            }
        } else {
            throw new userNotFoundException();
        }
    }

    public function setNewPaswoord($emailadres, $newPaswoord) {
        UserDAO::setNewPaswoord($emailadres, $newPaswoord);
    }

    public function blockById($id) {
        UserDAO::blockById($id);
    }

    public function updateNaam($userId, $newNaam) {
        UserDAO::updateNaam($userId,$newNaam);
    }

    public function updateVoornaam($userId, $newVoornaam) {
        UserDAO::updateVoornaam($userId,$newVoornaam);
    }

    public function updateStraat($userId, $newStraat) {
        UserDAO::updateStraat($userId,$newStraat);
    }

    public function updateHuisnummer($userId, $newHuisnummer) {
        UserDAO::updateHuisnummer($userId,$newHuisnummer);
    }

    public function updatePostcode($userId, $newPostcode) {
        UserDAO::updatePostcode($userId,$newPostcode);
    }

    public function updateWoonplaats($userId, $newWoonplaats) {
        UserDAO::updateWoonplaats($userId,$newWoonplaats);
    }

    //delete
    public function deleteById($id) {
        UserDAO::deleteById($id);
    }

}
