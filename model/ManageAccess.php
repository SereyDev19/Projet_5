<?php

namespace SC19DEV\App\Model;
require_once("model/Manager.php");

class ManageAccess extends Manager
{

    public $accounts = [];
    public $adSets = [];
    public $ads = [];
    public $access = [];
    public $IdAccess = [];

    public function addAccess($account_id, $access_id)
    {
        $sql = 'INSERT INTO access(access_id, account_id) 
                VALUES(?, ?)';

        $affectedLines = $this->executeStatement($sql, [$access_id, $account_id]);

        return $affectedLines;
    }

    public function registerAccess($access_id, $access_email, $access_name, $access_firstname, $access_password)
    {
        $sql = 'UPDATE access SET access_email = ?, access_name = ?, access_firstname = ?, access_password = ?
                WHERE access_id = ?';
        $req = $this->executeStatement($sql, [$access_email, $access_name, $access_firstname, $access_password, $access_id]);

        return $req;
    }

    public function getAccess()
    {
        $sql = 'SELECT * FROM access';
        $this->accounts = $this->getAll($sql, []);
        foreach ($this->accounts as $iterAccount) {
            array_push($this->IdAccess, $iterAccount['access_id']);
        }
        return $this->accounts;
    }

    public function getAccountAdSets($accountId)
    {
        $sql = 'SELECT * FROM adsets WHERE account_id=?';
        $this->adSets = $this->getAll($sql, [$accountId]);
        return $this->adSets;
    }

    public function getAdSetsAds($adSetId)
    {
        $sql = 'SELECT * FROM ads WHERE adset_id=?';
        $this->ads = $this->getAll($sql, [$adSetId]);
        return $this->ads;
    }
}