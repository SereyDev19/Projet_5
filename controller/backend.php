<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/GetAPIData.php');
require_once('model/AdSetManager.php');
require_once('model/AdManager.php');
require_once('model/SyncData.php');
require_once('model/GetDBData.php');
require_once('model/CommentManager.php');
require_once('model/NotificationManager.php');
require_once('model/backend/UserSession.php');
require_once('model/backend/UserManager.php');
require_once('model/backend/FlashBag.php');

function adminVerification()
{
    $userManager = new SC19DEV\Blog\Model\UserManager();
    $userExists = $userManager->verifyUser($_POST['username'], $_POST['password']);

    $flashbag = new SC19DEV\Blog\Model\FlashBag();

    if (!$userManager->isCorrect) {
        adminLogin();
        $flashbag->add($userManager->message, 'error');
        $flashbag->flash();
        $flashbag->fetchMessages();
        exit();
    }

    $userSession = new SC19DEV\Blog\Model\UserSession();
    $userSession->registerUser($userManager->username, $userManager->user_id);

    $flashbag->add($userManager->message, 'success');
    $flashbag->flash();
    $flashbag->fetchMessages();

    adminGlobalReport();
}

function APIGlobalReport()
{
    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {
        $getAPIData = new \SC19DEV\Blog\Model\GetAPIData();
        $synData = new \SC19DEV\Blog\Model\SyncData();
        $getDBaccounts = new \SC19DEV\Blog\Model\GetDBData();
        //Get data from FB API
        $getAccounts = $getAPIData->getAccounts(10158484356634381); //my DEV ID
        $getAccountsId = $getAPIData->getAccountsId(10158484356634381);
//        $bddAccount = $getDBaccounts->getAccounts();

        foreach ($getAccountsId as $iterAccount) {
//            $iterAccount = substr($iterAccount, 4, strlen($iterAccount));
            $getAPIData = new \SC19DEV\Blog\Model\GetAPIData();
            $accountData = $getAPIData->getFromFields($iterAccount, ['spend']);

            if ($getAPIData->hasData) {
                // Make a TRY
                $adSet = new \SC19DEV\Blog\Model\AdSetManager();
                $adSetList = $adSet->getAdSets($iterAccount);
                $goal = '';
                foreach ($adSetList as $iterAdSet) {
                    if ($adSet->optimGoal($iterAdSet) == 'LEAD_GENERATION') {
                        $goal = 'LEAD_GENERATION';
                    }
                }
                if ($goal == 'LEAD_GENERATION') {
                    $lead = $getAPIData->getDataActions($iterAccount, ['actions'])['lead']; // lead
                    $cost_lead = $getAPIData->getCost($iterAccount, ['cost_per_action_type'])['lead']; // cost per lead
                } else {
                    $lead = -1;
                    $cost_lead = -1;
                }
                $name = $getAPIData->getName($iterAccount);
                $synData->isregisteredAccount($iterAccount, $getAccountsId);

                $synData->syncAccount($iterAccount, [
                    $name,
                    $accountData['spend'], //SPEND
                    $lead,
                    $cost_lead
                ]);
            }
        }

        //Get data from BD MYSQL
        $DBaccounts = $getDBaccounts->getAccounts();
    } else {
    }
}

function adminGlobalReport()
{
    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\Blog\Model\GetDBData();
        $DBaccounts = $getDBData->getAccounts();


        require('view/frontend/dashboard.php');
    } else {
        require('view/backend/login.php');
    }

}

function adminReportAccount($accountId)
{
    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\Blog\Model\GetDBData();
        $DBaccount = $getDBData->getAccount($accountId);

        require('view/frontend/reportAccount.php');
    }

}

function admindetailedReport($accountId)
{
    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {

        $getDBData = new \SC19DEV\Blog\Model\GetDBData();
        $adSets = $getDBData->getAccountAdSets($accountId);
        $account = $getDBData->getAccounts($accountId);

        $allAds = [];
        foreach ($adSets as $iterAdSet) {
            $ads = $getDBData->getAdSetsAds($iterAdSet['adset_id']);
            $allAds[$iterAdSet['adset_id']] = $ads;
//            array_push($allAds, $ads);
        }

        require('view/frontend/detailedReport.php');
    }
}

function APIReportAccount($accountId)
{
    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {
        $getAPIData = new \SC19DEV\Blog\Model\GetAPIData();

        $res = $getAPIData->getFromFields($accountId, ['spend']);
        $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
        $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
    }
}

function APIdetailedReport($accountId)
{

    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {

        $getAPIData = new \SC19DEV\Blog\Model\GetAPIData();
        $adSet = new \SC19DEV\Blog\Model\AdSetManager();
        $ad = new \SC19DEV\Blog\Model\AdManager();
        $bddAdSet = new \SC19DEV\Blog\Model\SyncData();
        $bddAd = new \SC19DEV\Blog\Model\SyncData();

        $res = $getAPIData->getFromFields($accountId, ['spend']);
        $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
        $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
        $adSetList = $adSet->getAdSets($accountId);

//        $adsList = $ad->getads($accountId);
        $registerAd = $bddAd->getBddAds($accountId);


        $registerAdSet = $bddAdSet->getBddAdSets($accountId);
        foreach ($adSetList as $iterAdSet) {

            $adSet = new \SC19DEV\Blog\Model\AdSetManager();
            $adSetData = $adSet->DataFromFields($iterAdSet, ['spend', 'cpm', 'clicks', 'cpc']);

            if ($adSet->hasData) {
                $goal = $adSet->optimGoal($iterAdSet);
                $name = $adSet->getName($iterAdSet);
                $bddAdSet->isregisteredAdSet($iterAdSet, $registerAdSet);
                $result = $adSet->getResult($iterAdSet);

                $bddAdSet->syncAdSet($accountId, $iterAdSet, [$goal, $name,
                    $adSetData[$iterAdSet]['spend'],
                    $adSetData[$iterAdSet]['cpm'],
                    $adSetData[$iterAdSet]['clicks'],
                    $adSetData[$iterAdSet]['cpc'],
                    $result[1],
                    $result[2],
                    1 //for the moment
                ]);

                $adsList = $ad->getAdsfromAdList($iterAdSet);

                foreach ($adsList as $iterAd) {
                    $ad = new \SC19DEV\Blog\Model\AdManager();
                    // $Goal is the same as the ad's adlist
                    $name = $ad->getName($iterAd);
                    $adData = $ad->DataFromFields($iterAd, ['spend', 'cpm', 'clicks', 'cpc']);
                    if ($ad->hasData) {
                        $bddAd->isregisteredAd($iterAd, $registerAd);
                        $result = $ad->getAdResult($iterAd, $iterAdSet);

                        $bddAd->syncAd($accountId, $iterAdSet, $iterAd, [$goal, $name,
                            $adData[$iterAd]['spend'],
                            $adData[$iterAd]['cpm'],
                            $adData[$iterAd]['clicks'],
                            $adData[$iterAd]['cpc'],
                            $result[1],
                            $result[2],
                            1 //for the moment
                        ]);
                    }
                }
            }
        }
    }
}

function adminLogout()
{
    $session = new SC19DEV\Blog\Model\Session();
    $session->stopSession();
    header("Location: index.php");
    exit;
}


function adminLogin()
{
    $userSession = new SC19DEV\Blog\Model\UserSession();
    if ($userSession->isLogged()) {
        require('view/frontend/dashboard.php');
    } else {
        require('view/backend/login.php');
    }
}