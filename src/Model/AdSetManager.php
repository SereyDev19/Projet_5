<?php

namespace App\Model;

use phpDocumentor\Reflection\Types\Integer;


class AdSetManager extends GetAPIData
{
    public $AdSetList = [];
    public $adsetData = [];
    public $optimization_goal = '';
    public $actions = []; // ['landing_page_view' : 78, 'link_click' : 1588]
    public $cost_per_action = [];
    public $fieldRes = [];
    public $hasData = false;

    /**
     * AdSetManager constructor.
     * @param $env
     */
    public function __construct($env)
    {
        parent::__construct($env);
    }

    /**
     * @param $account_id
     * @return array
     * Give the ad sets of an account
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getAdSets($account_id)
    {
        try {
            $response = $this->fb->get(
                '/act_' . $account_id . '/adsets',
                $this->env['accessToken']
            );
            $getDecodeBody = $response->getDecodedBody();

            $data = $getDecodeBody['data'];

            foreach ($data as $value) {
                array_push($this->AdSetList, $value['id']);
            }

            return $this->AdSetList;

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
     * @return mixed
     * Give the name of an ad set
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getName($adSetId)
    {
        try {
            $response = $this->fb->get(
                '/' . $adSetId . '?fields=name',
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
     * @param $adSetId
     * @return string
     * Give the optimization goal of an ad set
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function optimGoal($adSetId)
    {
        try {
            $response = $this->fb->get(
                '/' . $adSetId . '?fields=optimization_goal',
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
     * @param $adSetId
     * @param $fields
     * @return array
     * Give the statistical data during the 30 past days
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function DataFromFields($adSetId, $fields)
    {
        $this->setFields($fields);

        try {
            $response = $this->fb->get(
                '/' . $adSetId . '/insights?fields=' . $this->fieldsConc,
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

                $this->adsetData[$adSetId] = $this->fieldRes;
                return $this->adsetData;
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
     * Give the statistical data for the actions during the 30 past days
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
     * Cost during the past 30 days
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
     * @param $adSetId
     * @return array
     * Give a result for the 30 past day (depends on the optimization goal)
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getResult($adSetId)
    {

        $this->optimGoal($adSetId);
//        var_dump('optimization goal', $this->optimization_goal);
        if ($this->optimization_goal == 'LEAD_GENERATION') {
            $action = 'lead';
            if (array_key_exists($action, $this->getDataActions($adSetId, ['actions']))) {
                $result = $this->getDataActions($adSetId, ['actions'])[$action];
                $cost_per_result = $this->getCost($adSetId, ['cost_per_action_type'])[$action];
            } else {
                $result = 0;
                $cost_per_result = 0;
            }
        } elseif ($this->optimization_goal == 'THRUPLAY') {
            $action = 'video_thruplay_watched_actions';
            $result = $this->DataFromFields($adSetId, [$action])[$adSetId][$action][0]['value'];
            $cost_per_action = 'cost_per_thruplay';
            $cost_per_result = $this->DataFromFields($adSetId, [$cost_per_action])[$adSetId][$cost_per_action][0]['value'];
        }

        return [$action, $result, $cost_per_result];
    }
}