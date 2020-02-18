<?php

namespace App\Model;

use phpDocumentor\Reflection\Types\Integer;


class AdManager extends GetAPIData
{
    public $AdList = [];
    public $adData = [];
    public $optimization_goal = '';
    public $actions = []; // ['landing_page_view' : 78, 'link_click' : 1588]
    public $cost_per_action = [];
    public $fieldRes = [];
    public $hasData = false;

    /**
     * AdManager constructor.
     * @param $env
     */
    public function __construct($env)
    {
        parent::__construct($env);
    }

    /**
     * @param $account_id
     * @return array
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAdsfromAccount($account_id)
    {
        $this->AdList = [];

        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/ads',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            $data = $getDecodeBody['data'];

            foreach ($data as $value) {
                array_push($this->AdList, $value['id']);
            }

            return $this->AdList;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

    }

    /**
     * @param $adList_id
     * @return array with the Ads
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAdsfromAdList($adList_id)
    {
        $this->AdList = [];
        try {
            $response = $this->fb->get(
                '/' . $adList_id . '/ads',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            $data = $getDecodeBody['data'];

            foreach ($data as $value) {
                array_push($this->AdList, $value['id']);
            }

            return $this->AdList;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

    }

    /**
     * @param $adId
     * @return mixed
     * Gives the name of an Ad
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getName($adId)
    {
        try {
            $response = $this->fb->get(
                '/' . $adId . '?fields=name',
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
     * @param $adId
     * @return string
     * Give the optimization goal (advertising strategy) for an ad
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function optimGoal($adId)
    {
        try {
            $response = $this->fb->get(
                '/' . $adId . '?fields=optimization_goal',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            $this->optimization_goal = $getDecodeBody['optimization_goal'];
            return $this->optimization_goal;

        } catch (FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $adId
     * @param $fields
     * @return array
     * Give the statistical data for an Ad
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function DataFromFields($adId, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/' . $adId . '/insights?fields=' . $this->fieldsConc,
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

                $this->adData[$adId] = $this->fieldRes;
                return $this->adData;
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
     * @param $adSetId
     * @param $fields
     * @return array
     * Give the statistical data for the ad actions (depends on the optimization goal) during the past 30 days
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getDataActions($adSetId, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/' . $adSetId . '/insights?fields=' . $this->fieldsConc,
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
     * @param $adSetId
     * @param $fields
     * @return array
     * Gives the Cost of an ad set during the past 30 days
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getCost($adSetId, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/' . $adSetId . '/insights?fields=' . $this->fieldsConc,
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();
            $data = $getDecodeBody['data'][0]['cost_per_action_type'];

            foreach ($data as $value) {
                $cost_per_action_type = $value['action_type'];
//                $this->cost_per_action[$cost_per_action_type] = number_format($value['value'], 2);
                $this->cost_per_action[$cost_per_action_type] = $value['value'];
            }
//            $this->cost_per_action = number_format($this->cost_per_action, 2);
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
     * @param $adId
     * @param $adSetId
     * @return array
     * Give the "result" during the past 30 days, depends on the optimization goal
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAdResult($adId, $adSetId)
    {

        $this->optimGoal($adSetId);
        if ($this->optimization_goal == 'LEAD_GENERATION') {
            $action = 'lead';
            if (array_key_exists($action, $this->getDataActions($adId, ['actions']))) {
                $result = $this->getDataActions($adId, ['actions'])[$action];
                $cost_per_result = $this->getCost($adId, ['cost_per_action_type'])[$action];
            } else {
                $result = 0;
                $cost_per_result = 0;
            }
        } elseif ($this->optimization_goal == 'THRUPLAY') {
            $action = 'video_thruplay_watched_actions';
            $result = $this->DataFromFields($adId, [$action])[$adId][$action][0]['value'];
            $cost_per_action = 'cost_per_thruplay';
            $cost_per_result = $this->DataFromFields($adId, [$cost_per_action])[$adId][$cost_per_action][0]['value'];
        }
        return [$action, $result, $cost_per_result];
    }
}