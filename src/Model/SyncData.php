<?php

namespace App\Model;

use App\Model\Manager;

class SyncData extends Manager
{
    public $accountList = [];
    public $adSetList = [];
    public $adList = [];
    public $registerAccount = false;
    public $registerAdSet = false;
    public $registerAd = false;

    /**
     * @return array
     * All the accounts in the database
     */
    public function getBddAccounts()
    {
        $sql = 'SELECT account_id FROM accounts';
        $res = $this->getAll($sql, []);
        foreach ($res as $value) {
            array_push($this->accountList, $value['account_id']);
        }
        return $this->accountList;

    }

    /**
     * @param $accountId
     * @return array
     * All the ad sets in the database
     */
    public function getBddAdSets($accountId)
    {
        $sql = 'SELECT adset_id	 FROM adsets WHERE account_id=?';
        $res = $this->getAll($sql, [$accountId]);
        foreach ($res as $value) {
            array_push($this->adSetList, $value['adset_id']);
        }
        return $this->adSetList;
    }

    /**
     * @param $accountId
     * @return array
     * All the ads in the database
     */
    public function getBddAds($accountId)
    {
        $sql = 'SELECT ad_id FROM ads WHERE account_id = ?';
        $res = $this->getAll($sql, [$accountId]);
        foreach ($res as $value) {
            array_push($this->adList, $value['ad_id']);
        }
        return $this->adList;
    }

    /**
     * @param $accountId
     * @param $allaccounts
     * Checks if the ad account exists in the database
     * @return bool
     */
    public function isregisteredAccount($accountId, $allaccounts)
    {
        if (is_int(array_search($accountId, $allaccounts))) {
            $this->registerAccount = true;
        } else {
            $this->registerAccount = false;
        }
        return $this->registerAccount;
    }

    /**
     * @param $adsetId
     * @param $alladsets
     * Checks if the ad set exists in the database
     * @return bool
     */
    public function isregisteredAdSet($adsetId, $alladsets)
    {
        if (is_int(array_search($adsetId, $alladsets))) {
            $this->registerAdSet = true;
        } else {
            $this->registerAdSet = false;
        }
        return $this->registerAdSet;
    }

    /**
     * @param $adId
     * @param $allads
     * Checks if the ad exists in the database
     * @return bool
     */
    public function isregisteredAd($adId, $allads)
    {
        if (is_int(array_search($adId, $allads))) {
            $this->registerAd = true;
        } else {
            $this->registerAd = false;
        }
        return $this->registerAd;
    }

    /**
     * @param $accountId
     * @param $values
     * Action : synchronize the account (create OR update)
     */
    public function syncAccount($accountId, $values)
    {
        if ($this->registerAccount == false) {
//            var_dump('creation nouvel ensemble de pub');
            $this->CreateAccount($accountId, $values);
        } else {
//            var_dump('mise à jour ensemble de pub existant');
            $this->UpdateAccount($accountId, $values);
        }
    }

    /**
     * @param $accountId
     * @param $values
     * Update the account data
     */
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

    /**
     * @param $accountId
     * @param $values
     * Update the account spent month by month between two date
     */
    public function UpdateJSONspend($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_spend = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    /**
     * @param $accountId
     * @param $values
     * Update the account spent day by day between two dates
     */
    public function UpdateJSONspendDay($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_spend_d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    public function UpdateJSONspendDay14($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_spend_14d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    /**
     * @param $accountId
     * @param $values
     * Update the account leads
     */
    public function UpdateJSONlead($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_lead = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }


    /**
     * @param $accountId
     * @param $values
     */
    public function UpdateJSONleadDay($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_lead_d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    public function UpdateJSONleadDay14($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_lead_14d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    /**
     * @param $accountId
     * @param $values
     * Update the cost per lead
     */
    public function UpdateJSONcostperlead($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_costperlead = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    /**
     * @param $accountId
     * @param $values
     */
    public function UpdateJSONcostperleadDay($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_costperlead_d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    public function UpdateJSONcostperleadDay14($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($values, $firstArr);
        $sql = 'UPDATE accounts SET     history_costperlead_14d = ?
                                        WHERE account_id= ?';
        $req = $this->executeStatement($sql, $values);
    }

    /**
     * @param $accountId
     * @param $values
     * Create a new account in the database
     */
    public function CreateAccount($accountId, $values)
    {
        $firstArr = [$accountId];
        $values = array_merge($firstArr, $values);
        $sql = 'INSERT INTO accounts(account_id, account_name,spend30d,
                                leads30d,cost_per_lead30d)
                                        VALUES(?, ?, ?, ?, ?)';
        $req = $this->executeStatement($sql, $values);
    }

    /**
     * @param $accountId
     * @param $adsetId
     * @param $values
     * Synchronizes the ad set (Create OR update)
     */
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

    /**
     * @param $adsetId
     * @param $values
     * Update the ad set main data
     */
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

    /**
     * @param $accountId
     * @param $adsetId
     * @param $values
     * Create a new ad set in the database
     */
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

    /**
     * @param $accountId
     * @param $adsetId
     * @param $adId
     * @param $values
     * Synchronizes the ad main data
     */
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

    /**
     * @param $adId
     * @param $values
     * Update the ad data
     */

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

    /**
     * @param $accountId
     * @param $adsetId
     * @param $adId
     * @param $values
     * Create a new ad in the database
     */
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



