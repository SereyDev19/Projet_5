<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/GetAPIData.php');
require_once('model/AdSetManager.php');
require_once('model/AdManager.php');
require_once('model/SyncData.php');
require_once('model/GetDBData.php');
require_once('model/ManageAccess.php');
require_once('model/CommentManager.php');
require_once('model/NotificationManager.php');
require_once('model/backend/UserSession.php');
require_once('model/backend/UserManager.php');
require_once('model/backend/FlashBag.php');

function adminVerification()
{
    $userManager = new SC19DEV\App\Model\UserManager();
    $userExists = $userManager->verifyUser($_POST['email'], $_POST['password']);

    $flashbag = new SC19DEV\App\Model\FlashBag();

    if (!$userManager->isCorrect) {
        adminLogin();
        $flashbag->add($userManager->message, 'error');
        $flashbag->flash();
        $flashbag->fetchMessages();
        exit();
    }

    $userSession = new SC19DEV\App\Model\UserSession();
    $userSession->registerUser($userManager->username, $userManager->user_id);

    $flashbag->add($userManager->message, 'success');
    $flashbag->flash();
    $flashbag->fetchMessages();

    adminGlobalReport();
}

function adminSignIn()
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        require('view/frontend/dashboard.php');
    } else {
        require('view/backend/CreateAccount.php');
    }
}


function APIGlobalReport()
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getAPIData = new \SC19DEV\App\Model\GetAPIData();
        $synData = new \SC19DEV\App\Model\SyncData();
        $getDBaccounts = new \SC19DEV\App\Model\GetDBData();
        //Get data from FB API
        $getAccounts = $getAPIData->getAccounts(10158484356634381); //my DEV ID
        $getAccountsId = $getAPIData->getAccountsId(10158484356634381);
//        $bddAccount = $getDBaccounts->getAccounts();

        foreach ($getAccountsId as $iterAccount) {
//            $iterAccount = substr($iterAccount, 4, strlen($iterAccount));
            $getAPIData = new \SC19DEV\App\Model\GetAPIData();
            $accountData = $getAPIData->getFromFields($iterAccount, ['spend']);

            if ($getAPIData->hasData) {
                // Make a TRY
                $adSet = new \SC19DEV\App\Model\AdSetManager();
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
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\App\Model\GetDBData();
        $DBaccounts = $getDBData->getAccounts();


        require('view/frontend/dashboard.php');
    } else {
//        require('view/backend/login.php');
        require('view/backend/loginEmail.php');

    }

}

function adminReportAccount($accountId)
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\App\Model\GetDBData();
        $DBaccount = $getDBData->getAccount($accountId);

        require('view/frontend/reportAccount.php');
    }

}

function admindetailedReport($accountId)
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {

        $getDBData = new \SC19DEV\App\Model\GetDBData();
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
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getAPIData = new \SC19DEV\App\Model\GetAPIData();

        $res = $getAPIData->getFromFields($accountId, ['spend']);
        $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
        $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
    }
}

function APIdetailedReport($accountId)
{

    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {

        $getAPIData = new \SC19DEV\App\Model\GetAPIData();
        $adSet = new \SC19DEV\App\Model\AdSetManager();
        $ad = new \SC19DEV\App\Model\AdManager();
        $bddAdSet = new \SC19DEV\App\Model\SyncData();
        $bddAd = new \SC19DEV\App\Model\SyncData();

        $res = $getAPIData->getFromFields($accountId, ['spend']);
        $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
        $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
        $adSetList = $adSet->getAdSets($accountId);

//        $adsList = $ad->getads($accountId);
        $registerAd = $bddAd->getBddAds($accountId);


        $registerAdSet = $bddAdSet->getBddAdSets($accountId);
        foreach ($adSetList as $iterAdSet) {

            $adSet = new \SC19DEV\App\Model\AdSetManager();
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
                    $ad = new \SC19DEV\App\Model\AdManager();
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

function adminManageAccess()
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\App\Model\GetDBData();
        $AccessManager = new \SC19DEV\App\Model\ManageAccess();

        $DBaccounts = $getDBData->getAccounts();
        $allAccess = $AccessManager->getAccess();

        require('view/frontend/access.php');
    } else {
        require('view/backend/login.php');
    }
}

function adminAddAccess($account_id)
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        $getDBData = new \SC19DEV\App\Model\GetDBData();
        $DBaccounts = $getDBData->getAccounts();
        $AccessManager = new \SC19DEV\App\Model\ManageAccess();
        $var = random_int(1e6, 1e9 - 1);
        $AccessManager->addAccess($account_id, $var);

        adminManageAccess();

    } else {
        require('view/backend/login.php');
    }
}

function adminRegisterNewAccess($params)
{
    $userManager = new SC19DEV\App\Model\UserManager();
//    $userExists = $userManager->verifyUser($_POST['username'], $_POST['password']);

    $flashbag = new SC19DEV\App\Model\FlashBag();

    $getDBData = new \SC19DEV\App\Model\GetDBData();
    $DBaccounts = $getDBData->getAccounts();
    $AccessManager = new \SC19DEV\App\Model\ManageAccess();
    $AccessManager->getAccess();

    $access_id = $params['access_id'];
    $access_email = $params['access_email'];
    $access_name = $params['access_name'];
    $access_firstname = $params['access_firstname'];
    $access_password = $params['access_password'];

    $IdExists = $userManager->verifyAccessId($access_id);

    if (!$userManager->isId) { //If no Id founded
        adminSignIn(); // Other function
        $flashbag->add($userManager->message, 'error');
        $flashbag->flash();
        $flashbag->fetchMessages();
        exit();
    }

    $userSession = new SC19DEV\App\Model\UserSession();
    $userSession->registerUser($userManager->username, $userManager->user_id);

    $flashbag->add($userManager->message, 'success');
    $flashbag->flash();
    $flashbag->fetchMessages();

    $AccessManager->registerAccess($access_id, $access_email, $access_name, $access_firstname, $access_password);

    //Creer une Page de bienvenue
    $toto = $getDBData->getAccessAccountsId($access_id);
    var_dump($toto);
    $newAccessAccount = $getDBData->getAccountsFromList($toto);
    var_dump($newAccessAccount);

}

function adminLogout()
{
    $session = new SC19DEV\App\Model\Session();
    $session->stopSession();
    header("Location: index.php");
    exit;
}


function adminLogin()
{
    $userSession = new SC19DEV\App\Model\UserSession();
    if ($userSession->isLogged()) {
        require('view/frontend/dashboard.php');
    } else {
//        require('view/backend/login.php');
        require('view/backend/loginEmail.php');

    }
}