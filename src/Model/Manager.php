<?php

namespace App\Model;

class Manager
{
    protected $db = '';

    Const DB_HOST = 'localhost';
    Const DB_NAME = 'analytics';
    Const DB_USERNAME = 'root';
    Const DB_PWD = '';

//    Const DB_HOST = 'db5000221607.hosting-data.io';
//    Const DB_NAME = 'dbs216354';
//    Const DB_USERNAME = 'dbu437341';
//    Const DB_PWD = 'Bddprojet4SC19dev!';

    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    protected function dbConnect()
    {
        try {
            $db = new \PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8', self::DB_USERNAME, self::DB_PWD);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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