<?php

namespace Bestellingen\Data;

use Bestellingen\Entities\Product;
use PDO;

class ProductDAO {

    //create
    public function newProduct($naam, $prijs) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'INSERT INTO producten (naam,prijs) VALUES(:naam,:prijs)';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':naam', $naam);
        $sth->bindParam(':prijs', $prijs);
        $sth->execute();
        $dbh = null;
    }

    //read
    public function getById($id) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT * FROM producten WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            $row = $resultSet->fetch();
            if ($row) {
                $oProduct = Product::create($row['id'], $row['naam'], $row['prijs']);
                $dbh = null;
                return $oProduct;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getAll() {
        $productenlijst = array();
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'SELECT * FROM producten';
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $resultSet = $sth;
        if ($resultSet) {
            foreach ($resultSet as $row) {
                $oProduct = Product::create($row['id'], $row['naam'], $row['prijs']);
                array_push($productenlijst, $oProduct);
            }
            $dbh = null;
            return $productenlijst;
        } else {
            return FALSE;
        }
    }

    //update
    public function updateById($id, $naam, $prijs) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'UPDATE producten SET naam = :naam, prijs = :prijs WHERE id = :id';
        $sth->bindParam(':id', $id);
        $sth->bindParam(':naam', $naam);
        $sth->bindParam(':prijs', $prijs);
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $dbh = null;
    }

    //delete
    public function deleteById($id) {
        $dbh = new PDO(DBConfig::$DB_Connstring, DBConfig::$DB_Username, DBConfig::$DB_Password);
        $sql = 'DELETE FROM producten WHERE id = :id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        $dbh = null;
    }

}
