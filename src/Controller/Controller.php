<?php

namespace App\Controller;

use App\Model\backend\Session;
use App\Model\backend\UserSession;
use App\Model\backend\UserManager;
use App\Model\backend\FlashBag;

class Controller
{
    public $level_Access = 0;
    public $access_id = '';

    public function __construct()
    {
//        var_dump('Instanciation Controller');
        $userSession = new UserSession();
        $userSession->isLogged();

        $this->level_Access = $userSession->levelAccess;
        $this->access_id = $userSession->userId;
    }

    public function Verification()
    {
        $userManager = new UserManager();
        $userExists = $userManager->verifyUser($_POST['email'], $_POST['password']);

        $flashbag = new FlashBag();

        if (!$userManager->isCorrect) {
            $this->Login();
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        $userSession = new UserSession();
        $userSession->registerUser($userManager->username, $userManager->user_id, $userManager->access_level);

        $flashbag->add($userManager->message, 'success');
        $flashbag->flash();
        $flashbag->fetchMessages();

        $this->GlobalReport();
    }

    public function SignIn()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            require('view/frontend/dashboard.php');
        } else {
            require('view/backend/CreateAccount.php');
        }
    }

    public function Login()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            require('view/frontend/dashboard.php');
        } else {
            require('view/backend/loginEmail.php');

        }
    }

    public function Logout()
    {
        $session = new Session();
        $session->stopSession();
        header("Location: index.php");
        exit;
    }

    public function GlobalReport()
    {
        if ($this->level_Access == 0) {
            $FrontController = new FrontController();
            $FrontController->FrontGlobalReport($this->access_id);
        } else {
            $BackController = new BackController();
            $BackController->adminGlobalReport();
        }
    }

    function DetailedReport($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {

            $getDBData = new \App\Model\GetDBData();
            $adSets = $getDBData->getAccountAdSets($accountId);
            $account = $getDBData->getAccounts($accountId);

            $allAds = [];
            foreach ($adSets as $iterAdSet) {
                $ads = $getDBData->getAdSetsAds($iterAdSet['adset_id']);
                $allAds[$iterAdSet['adset_id']] = $ads;
            }

            require('view/frontend/detailedReport.php');
        }
    }

    function ReportAccount($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $DBaccount = $getDBData->getAccount($accountId);

            require('view/frontend/reportAccount.php');
        }

    }

    public function ManageAccess()
    {
        if ($this->level_Access == 0) {
// Does not happen
        } else {
            $BackController = new BackController();
            $BackController->adminManageAccess();
        }
    }

    public function RegisterNewAccess($params)
    {
        $userManager = new UserManager();

        $flashbag = new FlashBag();

        $getDBData = new \App\Model\GetDBData();
        $DBaccounts = $getDBData->getAccounts();
        $AccessManager = new \App\Model\ManageAccess();
        $AccessManager->getAccess();

        $access_id = $params['access_id'];
        $access_email = $params['access_email'];
        $access_name = $params['access_name'];
        $access_firstname = $params['access_firstname'];
        $access_password = $params['access_password'];

        $IdExists = $userManager->verifyAccessId($access_id);
        $AccountCreated = $userManager->passwordDefined($access_id);

        if ($userManager->alreadyDefined) {
            $this->SignIn(); // Other function
//            adminSignIn(); // Other function
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        if (!$userManager->isId) { //If no Id founded
            $this->SignIn(); // Other function
//            adminSignIn(); // Other function
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        $userSession = new UserSession();
        $userSession->registerUser($userManager->username, $userManager->user_id,$userManager->access_level);

        $flashbag->add($userManager->message, 'success');
        $flashbag->flash();
        $flashbag->fetchMessages();

        $AccessManager->registerAccess($access_id, $access_email, $access_name, $access_firstname, $access_password);

        //Creer une Page de bienvenue
        $toto = $getDBData->getAccessAccountsId($access_id);
        $newAccessAccount = $getDBData->getAccountsFromList($toto);
        $DBaccounts = $newAccessAccount;

        require('view/frontend/dashboard.php');

    }

    public function APIGlobalReport()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getAPIData = new \App\Model\GetAPIData();
            $synData = new \App\Model\SyncData();
            $getDBaccounts = new \App\Model\GetDBData();
            //Get data from FB API
            $getAccounts = $getAPIData->getAccounts(10158484356634381); //my DEV ID
            $getAccountsId = $getAPIData->getAccountsId(10158484356634381);

            foreach ($getAccountsId as $iterAccount) {
                $getAPIData = new \App\Model\GetAPIData();
                $accountData = $getAPIData->getFromFields($iterAccount, ['spend']);

                if ($getAPIData->hasData) {
                    // Make a TRY
                    $adSet = new \App\Model\AdSetManager();
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

    public function APIReportAccount($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getAPIData = new \App\Model\GetAPIData();

            $res = $getAPIData->getFromFields($accountId, ['spend']);
            $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
            $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
        }
    }

    public function APIdetailedReport($accountId)
    {

        $userSession = new UserSession();
        if ($userSession->isLogged()) {

            $getAPIData = new \App\Model\GetAPIData();
            $adSet = new \App\Model\AdSetManager();
            $ad = new \App\Model\AdManager();
            $bddAdSet = new \App\Model\SyncData();
            $bddAd = new \App\Model\SyncData();

            $res = $getAPIData->getFromFields($accountId, ['spend']);
            $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
            $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
            $adSetList = $adSet->getAdSets($accountId);

            $registerAd = $bddAd->getBddAds($accountId);


            $registerAdSet = $bddAdSet->getBddAdSets($accountId);
            foreach ($adSetList as $iterAdSet) {

                $adSet = new \App\Model\AdSetManager();
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
                        $ad = new \App\Model\AdManager();
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
}