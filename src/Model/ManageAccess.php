<?php

namespace App\Model;

use App\Model\Manager;

class ManageAccess extends Manager
{

    public $accounts = [];
    public $adSets = [];
    public $ads = [];
    public $access = [];
    public $IdAccess = [];
    public $IdUsed = false;
    public $activated = false;

    /**
     * @param $account_id
     * @param $access_id
     * Add an access with a new access id into the database for an account
     * @return bool|\PDOStatement
     */
    public function addAccess($account_id, $access_id)
    {
        $sql = 'INSERT INTO access(access_id, account_id) 
                VALUES(?, ?)';

        $affectedLines = $this->executeStatement($sql, [$access_id, $account_id]);

        return $affectedLines;
    }

    /**
     * @param $access_id
     * @return bool
     * Checks if the access id is already used
     */
    public function IdAlreadyUsed($access_id)
    {
        $sql = 'SELECT * FROM access WHERE access_id = ?';
        $this->accounts = $this->getAll($sql, [$access_id]);

        if ($this->accounts == null) {
            $this->IdUsed = true;
        }
        return $this->IdUsed;
    }

    /**
     * @param $access_email
     * @return bool
     * Checks if an email already exists in the database
     */
    public function isActivated($access_email)
    {
        $sql = 'SELECT activated FROM access WHERE access_email = ?';
        $this->value = $this->getOne($sql, [$access_email]);
        if ($this->value['activated'] == 1) {
            $this->activated = true;
        }
        return $this->activated;
    }

    /**
     * @param $access_id
     * @return bool|\PDOStatement
     * Delete an access
     */
    public function deleteAccess($access_id)
    {
        $sql = 'DELETE FROM access WHERE access_id = ?';

        $affectedLines = $this->executeStatement($sql, [$access_id]);

        return $affectedLines;
    }

    /**
     * @param $access_id
     * @param $access_email
     * @param $access_name
     * @param $access_firstname
     * @param $access_password
     * @param $auth_token
     * @return bool|\PDOStatement
     * Register the access with all the other data that the user has sent through the sign in form
     */
    public function registerAccess($access_id, $access_email, $access_name, $access_firstname, $access_password, $auth_token)
    {
        $sql = 'UPDATE access SET access_email = ?, access_name = ?, access_firstname = ?, access_password = ?, auth_token = ?
                WHERE access_id = ?';
        $req = $this->executeStatement($sql, [$access_email, $access_name, $access_firstname, $access_password, $auth_token, $access_id,]);

        return $req;
    }

    /**
     * @param $token
     * @return array|mixed
     * Looks for a token in the database
     */
    public function searchToken($token)
    {
        $sql = 'SELECT * FROM access where auth_token=?';
        $this->access = $this->getOne($sql, [$token]);

        return $this->access;
    }

    /**
     * @param $token
     * @return array|bool|\PDOStatement
     * Switch the activated status to 1 if the registration is all clear up
     */
    public function confirmToken($token)
    {
        $sql = 'UPDATE access SET activated = 1 WHERE auth_token=?';
        $this->access = $this->executeStatement($sql, [$token]);
        return $this->access;
    }

    /**
     * @return array
     * All the access in the database
     */
    public function getAccess()
    {
        $sql = 'SELECT * FROM access';
        $this->accounts = $this->getAll($sql, []);
        foreach ($this->accounts as $iterAccount) {
            array_push($this->IdAccess, $iterAccount['access_id']);
        }
        return $this->accounts;
    }

    /**
     * @param $accountId
     * @return array
     */
    public function getAccountAdSets($accountId)
    {
        $sql = 'SELECT * FROM adsets WHERE account_id=?';
        $this->adSets = $this->getAll($sql, [$accountId]);
        return $this->adSets;
    }

    /**
     * @param $adSetId
     * @return array
     */
    public function getAdSetsAds($adSetId)
    {
        $sql = 'SELECT * FROM ads WHERE adset_id=?';
        $this->ads = $this->getAll($sql, [$adSetId]);
        return $this->ads;
    }
}