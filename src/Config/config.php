<?php

namespace App\Config;

use Pagerfanta\Pagerfanta;
use Pagerfanta\View\DefaultView;
use PDO;

class Config
{
    public $db = '';
    protected $APP_HOST = '';

    /**
     * Config constructor.
     * @param $env : get the $env variables for the DB connection
     *
     */
    public function __construct($env)
    {
        $this->APP_HOST = $_SERVER['SERVER_NAME'];
        $this->env = $env;
        switch ($this->APP_HOST) {
            case 'projet_5_test.test':
                $this->DB_HOST = $this->env['DB_HOST'];
                $this->DB_NAME = $this->env['DB_NAME'];
                $this->DB_USERNAME = $this->env['DB_USERNAME'];
                $this->DB_PWD = $this->env['DB_PWD'];
                break;
            case 'sc19dev.fr':
                $this->DB_HOST = $this->env['DB_HOST_WEB'];
                $this->DB_NAME = $this->env['DB_NAME_WEB'];
                $this->DB_USERNAME = $this->env['DB_USERNAME_WEB'];
                $this->DB_PWD = $this->env['DB_PWD_WEB'];
                break;
        }
        $this->db = $this->dbConnect();
    }

    /**
     * @return PDO
     */
    protected function dbConnect()
    {
        try {
            $db = new PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8', $this->DB_USERNAME, $this->DB_PWD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $db;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * @param int $perPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage)
    {
        $db = new PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8', $this->DB_USERNAME, $this->DB_PWD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $query = new PaginatedQuery($db, 'SELECT * FROM accounts', 'SELECT COUNT(*) FROM accounts');

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage);
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool|\PDOStatement
     */
    public function executeStatement(string $sql, array $params)
    {
        $query = $this->db->prepare($sql);

        $query->execute($params);

        return $query;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function getAll(string $sql, array $params)
    {
        $query = $this->executeStatement($sql, $params);
        return $query->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function getOne(string $sql, array $params)
    {
        $query = $this->executeStatement($sql, $params);
        return $query->fetch();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function getColumn(string $sql, array $params)
    {
        $query = $this->executeStatement($sql, $params);
        return $query->fetchColumn();
    }
}