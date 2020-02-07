<?php

namespace App\Model;

use App\Config\Config;

class GetDBData extends Config
{

    public $accounts = [];
    public $adSets = [];
    public $ads = [];
    public $accountsId = [];

    /**
     * @return array
     * All the accounts in the database
     */
    public function getAccounts()
    {
        $this->accounts = [];
        $sql = 'SELECT * FROM accounts';
        $this->accounts = $this->getAll($sql, []);
        return $this->accounts;
    }

    /**
     *
     */
    public function getLetters()
    {
        $this->letters = [];
        $sql = 'SELECT first_letter FROM glossary';
        $this->accounts = $this->getAll($sql, []);
        foreach ($this->accounts as $item) {
            array_push($this->letters, $item['first_letter']);

        }
        return array_unique($this->letters);
    }

    /**
     * @return array|mixed
     */
    public function getNumber($letter)
    {
        $this->accounts = [];
        $sql = 'SELECT COUNT(*) FROM glossary WHERE first_letter=?';
        $this->accounts = $this->getColumn($sql, [$letter]);
        return $this->accounts;
    }

    /**
     * @param $starting_limit
     * @param $limit
     * @return array
     */
    public function getLimitAccounts($letter, $starting_limit, $limit)
    {

        $sql = 'SELECT * FROM glossary WHERE first_letter = ? ORDER BY id DESC LIMIT ' . $starting_limit . ', ' . $limit;
        $this->results = $this->getAll($sql, [$letter]);

        return $this->results;
    }

    /**
     * @param $forAccessId
     * @return array|mixed
     * Give the accounts id that the user (id) is allowed to access to
     */
    public function getAccessAccountsId($forAccessId)
    {
        $sql = 'SELECT account_id FROM access where access_id = ?';
        $this->accountsId = $this->getOne($sql, [$forAccessId]);
//        unset($this->accountsId['account_id']);
        return $this->accountsId;
    }

    /**
     * @param $accountId
     * Returns the account from its id
     * @return array|mixed
     */
    public function getAccount($accountId)
    {
        $sql = 'SELECT * FROM accounts WHERE account_id = ?';
        $this->accounts = $this->getOne($sql, [$accountId]);
        return $this->accounts;
    }

    /**
     * @param array $accountIdList
     * @return array
     * All the accounts data from a list of account id
     */
    public function getAccountsFromList(array $accountIdList)
    {
        $this->accounts = [];
        foreach ($accountIdList as $accountId) {
            $sql = 'SELECT * FROM accounts WHERE account_id = ?';
            array_push($this->accounts, $this->getAll($sql, [$accountId])[0]);
//            array_push($this->accounts, $this->getAll($sql, [$accountId]));

        }
        return $this->accounts;
    }

    /**
     * @param $accountId
     * @return array
     * Account ad sets related to an account id
     */
    public function getAccountAdSets($accountId)
    {
        $sql = 'SELECT * FROM adsets WHERE account_id =?';
        $this->adSets = $this->getAll($sql, [$accountId]);
        return $this->adSets;
    }

    /**
     * @param $adSetId
     * @return array
     * Ads related to an ad set
     */
    public function getAdSetsAds($adSetId)
    {
        $sql = 'SELECT * FROM ads WHERE adset_id =?';
        $this->ads = $this->getAll($sql, [$adSetId]);
        return $this->ads;
    }
}