<?php

namespace SC19DEV\Blog\Model;
require_once("model/Manager.php");

class GetDBData extends Manager
{

    public $accounts = [];
    public $adSets = [];
    public $ads = [];

    public function getAccounts()
    {
        $sql = 'SELECT * FROM accounts';
        $this->accounts = $this->getAll($sql, []);
        return $this->accounts;
    }

    public function getAccount($accountId)
    {
        $sql = 'SELECT * FROM accounts WHERE account_id = ?';
        $this->accounts = $this->getAll($sql, [$accountId])[0];
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