<?php

namespace App\Model;

//require_once("model/Manager.php");

class ManageAccess extends Manager
{

    public $accounts = [];
    public $adSets = [];
    public $ads = [];
    public $access = [];
    public $IdAccess = [];
    public $IdUsed = false;

    public function addAccess($account_id, $access_id)
    {
        $sql = 'INSERT INTO access(access_id, account_id) 
                VALUES(?, ?)';

        $affectedLines = $this->executeStatement($sql, [$access_id, $account_id]);

        return $affectedLines;
    }

    public function IdAlreadyUsed($access_id)
    {
        $sql = 'SELECT * FROM access WHERE access_id = ?';
        $this->accounts = $this->getAll($sql, [$access_id]);

        if ($this->accounts == null) {
            $this->IdUsed = true;
        }
        return $this->IdUsed;
    }

    public function deleteAccess($access_id)
    {
        $sql = 'DELETE FROM access WHERE access_id = ?';

        $affectedLines = $this->executeStatement($sql, [$access_id]);

        return $affectedLines;
    }

    public function registerAccess($access_id, $access_email, $access_name, $access_firstname, $access_password, $auth_token)
    {
        $access_password = $str = password_hash($access_password, PASSWORD_BCRYPT);
        $sql = 'UPDATE access SET access_email = ?, access_name = ?, access_firstname = ?, access_password = ?, auth_token = ?
                WHERE access_id = ?';
        $req = $this->executeStatement($sql, [$access_email, $access_name, $access_firstname, $access_password, $auth_token, $access_id,]);

        return $req;
    }

    public function searchToken($token)
    {
        $sql = 'SELECT * FROM access WHERE auth_token=?';
        $this->access = $this->getOne($sql, [$token]);
        return $this->access;
    }


    public function confirmToken($token)
    {
        $sql = 'UPDATE access SET activated = 1 WHERE auth_token=?';
        $this->access = $this->executeStatement($sql, [$token]);
        return $this->access;
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