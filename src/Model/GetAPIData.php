<?php

namespace App\Model;

use App\Model\Manager;
use Facebook\Facebook;

class GetAPIData extends Manager
{
    protected $fb = '';

    public $fieldsConc = '';
    public $fieldRes = [];
    public $actions = [];
    public $cost_per_action = [];
    public $accounts = [];
    public $AccountList = [];
    public $hasData = false;

    /**
     * GetAPIData constructor.
     * @param $env
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function __construct($env)
    {
        $this->env = $env;
        $this->fb = new \Facebook\Facebook([
            'app_id' => $this->env['app_id'],
            'app_secret' => $this->env['app_secret'],
            'default_graph_version' => $this->env['version'],
        ]);
    }

    /**
     * @param $fields
     * Set the fields array from the GET parameters
     */
    public function setFields($fields)
    {
        $this->fieldsConc = '';
        foreach ($fields as $field) {
            $this->fieldsConc .= strval($field) . ',';
        }
        $this->fieldsConc = substr($this->fieldsConc, 0, -1);
    }

    /**
     * @param $userId
     * @return array
     * Give the account(s) allowed for a user Id
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAccounts($userId)
    {
        try {
            $response = $this->fb->get(
                '/' . $userId . '/adaccounts',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            foreach ($getDecodeBody['data'] as $data) {
                $name = $this->getAccountData($data['account_id'], 'name');
                $this->accounts[$data['account_id']] = $name;
            }
            return $this->accounts;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $userId
     * @return array
     * Give the account(s) id permitted for the userId
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAccountsId($userId)
    {
        try {
            $response = $this->fb->get(
                '/' . $userId . '/adaccounts',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            $data = $getDecodeBody['data'];

            foreach ($data as $value) {
                array_push($this->AccountList, substr($value['id'], 4, strlen($value['id'])));
            }
            return $this->AccountList;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $accountId
     * @return mixed
     * Give the name of the account it
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getName($accountId)
    {
        try {
            $response = $this->fb->get(
                '/act_' . $accountId . '?fields=name',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            return $getDecodeBody['name'];

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $data
     * @return mixed
     * Give the statistical data for an account during the past 30 days
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAccountData($account_id, $data)
    {
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '?fields=' . $data,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            return $getDecodeBody[$data]; //Account name

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $fields
     * @return array
     * Give the statistical data from the past 30 days
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getFromFields($account_id, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?fields=' . $this->fieldsConc,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            if (empty($getDecodeBody['data'][0])) {
                $this->hasData = false;
            } else {
                $this->hasData = true;
                foreach ($fields as $field) {
                    $this->fieldRes[$field] = $getDecodeBody['data'][0][$field];
                }
                return $this->fieldRes;
            }

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $fields
     * @param $start
     * @param $end
     * @return array
     * Give the results between two dates, month by month
     * @throws \Facebook\Exceptions\FacebookSDKException
     */

    public function getFromFieldsDate($account_id, $fields, $start, $end)
    {
        $this->setFields($fields);
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?time_range={\'since\':\'' . $start . '\',\'until\':\'' . $end . '\'}&
                fields=' . $this->fieldsConc,
//                'act_331859797400599/insights?time_range={\'since\':\'2019-10-17\',\'until\':\'2019-12-17\'}&fields=spend',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            if (empty($getDecodeBody['data'][0])) {
                $this->hasData = false;
            } else {
                $this->hasData = true;
                foreach ($fields as $field) {
                    $this->fieldRes[$field] = $getDecodeBody['data'][0][$field];
                }
                return $this->fieldRes;
            }

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $fields
     * @return array
     * Give the data related to the action defined by optimization goal
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getDataActions($account_id, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?fields=' . $this->fieldsConc,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            $data = $getDecodeBody['data'][0]['actions'];

            foreach ($data as $value) {
                $action_type = $value['action_type'];
                $this->actions[$action_type] = $value['value'];
            }
            return $this->actions;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $fields
     * @param $start
     * @param $end
     * @return array
     * Give the data related to the action defined by the optimization goal, between two dates, month by month
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getDataActionsDates($account_id, $fields, $start, $end)
    {

        $this->setFields($fields);
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?time_range={\'since\':\'' . $start . '\',\'until\':\'' . $end . '\'}&fields=' . $this->fieldsConc,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            $data = $getDecodeBody['data'][0]['actions'];

            foreach ($data as $value) {
                $action_type = $value['action_type'];
                $this->actions[$action_type] = $value['value'];
            }
            return $this->actions;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $fields
     * @return array
     * Give the cost for an account during the 30 past days
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getCost($account_id, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?fields=' . $this->fieldsConc,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            $data = $getDecodeBody['data'][0]['cost_per_action_type'];

            foreach ($data as $value) {
                $cost_per_action_type = $value['action_type'];
//                $this->cost_per_action[$cost_per_action_type] = number_format($value['value'], 2);
                $this->cost_per_action[$cost_per_action_type] = $value['value'];
            }
            return $this->cost_per_action;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $account_id
     * @param $fields
     * @param $start
     * @param $end
     * @return array
     * Give the cost between two dates, month by month
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getCostDates($account_id, $fields, $start, $end)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?time_range={\'since\':\'' . $start . '\',\'until\':\'' . $end . '\'}&fields=' . $this->fieldsConc,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            $data = $getDecodeBody['data'][0]['cost_per_action_type'];

            foreach ($data as $value) {
                $cost_per_action_type = $value['action_type'];
//                $this->cost_per_action[$cost_per_action_type] = number_format($value['value'], 2);
                $this->cost_per_action[$cost_per_action_type] = $value['value'];
            }
            return $this->cost_per_action;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}