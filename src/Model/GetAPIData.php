<?php

namespace App\Model;

use App\Config\Config;
class GetAPIData extends Config
{
    protected $fb = '';

    public $fieldsConc = '';
    public $fieldRes = [];
    public $actions = [];
    public $cost_per_action = [];
    public $accounts = [];
    public $AccountList = [];
    public $hasData = false;


    const accessToken = 'EAANlTRfocxkBAPkhsZBZA2yLbqILNZCeGtJJEUyCppsLIx8m9gyVYjmypXBTBpnKW8uVLzYZA4O9uv0vN7sTqvVGZCfvXGdG43TpZBNJH5cSurRtgEHOlJbSY40jWZAbbJD7hTVDnJALEp9XdfRB7ojGidZCVsf0WRVr6IgYHzq9oZAfuNPI7n3N7ZB2fNTGDsQrsZD';
    const app_secret = '1792d172e69dee746210a4ec6456a76c';
    const app_id = '955806718128921';
    const version = 'v5.0';

    public function __construct()
    {
        $this->fb = new \Facebook\Facebook([
            'app_id' => self::app_id,
            'app_secret' => self::app_secret,
            'default_graph_version' => self::version,
        ]);
    }

    public function setFields($fields)
    {
        $this->fieldsConc = '';
        foreach ($fields as $field) {
            $this->fieldsConc .= strval($field) . ',';
        }
        $this->fieldsConc = substr($this->fieldsConc, 0, -1);
    }

    public function getAccounts($userId)
    {
        try {
            $response = $this->fb->get(
                '/' . $userId . '/adaccounts',
                self::accessToken
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

    public function getAccountsId($userId)
    {
        try {
            $response = $this->fb->get(
                '/' . $userId . '/adaccounts',
                self::accessToken
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

    public function getName($accountId)
    {
        try {
            $response = $this->fb->get(
                '/act_' . $accountId . '?fields=name',
                self::accessToken
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

    public function getAccountData($account_id, $data)
    {
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '?fields=' . $data,
                self::accessToken
            );
            $getDecodeBody = $response->getDecodedBody();
            return $getDecodeBody[$data]; //Account name

//            foreach ($fields as $field) {
////                var_dump($getDecodeBody['data'][0][$field]);
//                $this->fieldRes[$field] = $getDecodeBody['data'][0][$field];
//            }
//            return $this->fieldRes;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function getFromFields($account_id, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?fields=' . $this->fieldsConc,
                self::accessToken
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

    public function getFromFieldsDate($account_id, $fields, $start, $end)
    {
        $this->setFields($fields);
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?time_range={\'since\':\'' . $start . '\',\'until\':\'' . $end . '\'}&
                fields=' . $this->fieldsConc,
//                'act_331859797400599/insights?time_range={\'since\':\'2019-10-17\',\'until\':\'2019-12-17\'}&fields=spend',
                self::accessToken
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


    public function getDataActions($account_id, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?fields=' . $this->fieldsConc,
                self::accessToken
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

    public function getDataActionsDates($account_id, $fields, $start, $end)
    {

        $this->setFields($fields);
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?time_range={\'since\':\'' . $start . '\',\'until\':\'' . $end . '\'}&fields=' . $this->fieldsConc,
                self::accessToken
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

    public function getCost($account_id, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?fields=' . $this->fieldsConc,
                self::accessToken
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
    public function getCostDates($account_id, $fields,$start,$end)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/insights?time_range={\'since\':\'' . $start . '\',\'until\':\'' . $end . '\'}&fields=' . $this->fieldsConc,
                self::accessToken
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