<?php

namespace App\Model;

class SyncData extends Manager
{
    public $accountList = [];
    public $adSetList = [];
    public $adList = [];
    public $registerAccount = false;
    public $registerAdSet = false;
    public $registerAd = false;

    public function getBddAccounts()
    {
        $sql = 'SELECT account_id FROM accounts';
        $res = $this->getAll($sql, []);
        foreach ($res as $value) {
            array_push($this->accountList, $value['account_id']);
        }
        return $this->accountList;

    }

    public function getBddAdSets($accountId)
    {
        $sql = 'SELECT adset_id	 FROM adsets WHERE account_id=?';
        $res = $this->getAll($sql, [$accountId]);
        foreach ($res as $value) {
            array_push($this->adSetList, $value['adset_id']);
        }
        return $this->adSetList;
    }

    public function getBddAds($accountId)
    {
        $sql = 'SELECT ad_id FROM ads WHERE account_id = ?';
        $res = $this->getAll($sql, [$accountId]);
        foreach ($res as $value) {
            array_push($this->adList, $value['ad_id']);
        }
        return $this->adList;
    }

    public function isregisteredAccount($accountId, $allaccounts)
    {
        if (is_int(array_search($accountId, $allaccounts))) {
            $this->registerAccount = true;
        } else {
            $this->registerAccount = false;
        }
        return $this->registerAccount;
    }

    public function isregisteredAdSet($adsetId, $alladsets)
    {
        if (is_int(array_search($adsetId, $alladsets))) {
            $this->registerAdSet = true;
        } else {
            $this->registerAdSet = false;
        }
        return $this->registerAdSet;
    }

    public function isregisteredAd($adId, $allads)
    {
        if (is_int(array_search($adId, $allads))) {
            $this->registerAd = true;
        } else {
            $this->registerAd = false;
        }
        return $this->registerAd;
    }

    public function syncAccount($accountId, $values)
    {
        var_dump('synchronisation des données de comptes');
        if ($this->registerAccount == false) {
//            var_dump('creation nouvel ensemble de pub');
            $this->CreateAccount($accountId, $values);
        } else {
//            var_dump('mise à jour ensemble de pub existant');
            $this->UpdateAccount($accountId, $values);
        }
    }

    public function UpdateAccount($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     account_name = ?,
                                        spend30d = ?,
                                        leads30d = ?,
                                        cost_per_lead30d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    public function CreateAccount($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($firstArr, $values);
        $sql = 'INSERT INTO accounts(account_id, account_name,spend30d,
                                leads30d,cost_per_lead30d)
                                        VALUES(?, ?, ?, ?, ?)';
        $req = $this->executeStatement($sql, $values);
    }

    public function syncAdSet($accountId, $adsetId, $values)
    {
        if ($this->registerAdSet == false) {
//            var_dump('creation nouvel ensemble de pub');
            $this->CreateAdSet($accountId, $adsetId, $values);
        } else {
//            var_dump('mise à jour ensemble de pub existant');
            $this->UpdateAdSet($adsetId, $values);
        }
    }

    public function UpdateAdSet($adsetId, $values)
    {
        $firstArr = [$adsetId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE adsets SET optimization_goal = ?,
                                        adset_name = ?,
                                        spend30d = ?,
                                        cpm30d	= ?,
                                        clicks30d = ?,
                                        cost_per_click30d = ?,
                                        leads30d = ?,
                                        cost_per_lead30d = ?,
                                        sell_rate30d = ?
                                        WHERE adset_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    public function CreateAdSet($accountId, $adsetId, $values)
    {
        $firstArr = [$accountId, $adsetId];
        $values = array_merge($firstArr, $values);
        $sql = 'INSERT INTO adsets(account_id, adset_id, optimization_goal, adset_name, 
                                spend30d,cpm30d,clicks30d,cost_per_click30d,
                                leads30d,cost_per_lead30d,sell_rate30d)
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $req = $this->executeStatement($sql, $values);
    }

    public function syncAd($accountId, $adsetId, $adId, $values)
    {
        if ($this->registerAd == false) {
//            var_dump('creation nouvel ensemble de pub');
            $this->CreateAd($accountId, $adsetId, $adId, $values);
        } else {
//            var_dump('mise à jour ensemble de pub existant');
            $this->UpdateAd($adId, $values);
        }
    }

    public function UpdateAd($adId, $values)
    {
        $firstArr = [$adId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE ads SET optimization_goal = ?,
                                        ad_name = ?,
                                        spend30d = ?,
                                        cpm30d	= ?,
                                        clicks30d = ?,
                                        cost_per_click30d = ?,
                                        leads30d = ?,
                                        cost_per_lead30d = ?,
                                        sell_rate30d = ?
                                        WHERE adset_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    public function CreateAd($accountId, $adsetId, $adId, $values)
    {
        $firstArr = [$accountId, $adsetId, $adId];
        $values = array_merge($firstArr, $values);
        $sql = 'INSERT INTO ads(account_id, adset_id, ad_id, optimization_goal, ad_name, 
                                spend30d,cpm30d,clicks30d,cost_per_click30d,
                                leads30d,cost_per_lead30d,sell_rate30d)
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $req = $this->executeStatement($sql, $values);
    }
}



