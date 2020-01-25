<?php

namespace App\Model;

class Manager
{
    protected $db = '';
    protected $APP_HOST = '';

// PROJET 5
    Const DB_HOST = 'db5000279850.hosting-data.io';
    Const DB_NAME = 'dbs273161';
    Const DB_USERNAME = 'dbu387161';
    Const DB_PWD = 'Bddreportme1987!';

// PROJET 4
//    Const DB_HOST = 'db5000221607.hosting-data.io';
//    Const DB_NAME = 'dbs216354';
//    Const DB_USERNAME = 'dbu437341';
//    Const DB_PWD = 'Bddprojet4SC19dev!';

    public function __construct()
    {
        $this->APP_HOST = $_SERVER['SERVER_NAME'];

        switch ($this->APP_HOST) {
            case 'projet_5_test.test':
                $this->DB_HOST = 'localhost';
                $this->DB_NAME = 'analytics';
                $this->DB_USERNAME = 'root';
                $this->DB_PWD = '';
                break;
            case 'sc19dev.fr':
                $this->DB_HOST = 'db5000279850.hosting-data.io';
                $this->DB_NAME = 'dbs273161';
                $this->DB_USERNAME = 'dbu387161';
                $this->DB_PWD = 'Bddreportme1987!';
                break;
        }
        $this->db = $this->dbConnect();
    }

    protected function dbConnect()
    {
        try {
            $db = new \PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8', $this->DB_USERNAME, $this->DB_PWD);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//            $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            return $db;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    function executeStatement(string $sql, array $params)
    {
        $query = $this->db->prepare($sql);

        $query->execute($params);

        return $query;
    }

    function getAll(string $sql, array $params)
    {
        $query = $this->executeStatement($sql, $params);
        return $query->fetchAll();
    }

    function getOne(string $sql, array $params)
    {
        $query = $this->executeStatement($sql, $params);
        return $query->fetch();
    }

    function getColumn(string $sql, array $params)
    {
        $query = $this->executeStatement($sql, $params);
        return $query->fetchColumn();
    }
}