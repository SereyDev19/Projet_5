<?php

namespace App\Controller;

use App\Model\backend\Session;
use App\Model\backend\UserSession;
use App\Model\backend\UserManager;
use App\Model\backend\FlashBag;
use App\Model\GetMonths;
use App\Helper;
use App\Model\ManageAccess;
use Twig_Loader_Filesystem;
use Twig_Environment;

class Controller
{
    public $level_Access = 0;
    public $access_id = '';

    public function __construct()
    {
        $userSession = new UserSession();
        $userSession->isLogged();

        $this->level_Access = $userSession->levelAccess;
        $this->access_id = $userSession->userId;

        $this->loader = new Twig_Loader_Filesystem('C:\laragon\www\Projet_5_Test\templates');
        $this->twig = new Twig_Environment($this->loader, [
            'cache' => false
        ]);
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
        $userSession->isLogged();
        $this->access_id = $userSession->userId;
        $this->level_Access = $userManager->access_level;

        $flashbag->add($userManager->message, 'success');
        $flashbag->flash();
        $flashbag->fetchMessages();

//        $this->GlobalReport();
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
//            echo $twig->render('loginEmail.twig');
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

    public function ReportAccount($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $DBaccount = $getDBData->getAccount($accountId);
            $historySpend = json_decode($DBaccount['history_spend'], true);
            $historylead = json_decode($DBaccount['history_lead'], true);
            $historycostperlead = json_decode($DBaccount['history_costperlead'], true);

            $datesSpend = array_keys($historySpend);
            $dateslead = array_keys($historylead);
            $datescostperlead = array_keys($historycostperlead);

            $valuesSpend = [];
            $valuesLead = [];
            $valuesCostperlead = [];
            foreach ($historySpend as $data) {
                array_push($valuesSpend, $data['spend']);
            }
            foreach ($historylead as $data) {
                array_push($valuesLead, $data);
            }
            foreach ($historycostperlead as $data) {
                array_push($valuesCostperlead, $data);
            }
//            var_dump($dates);
//            var_dump($values);
//            $history = $DBaccount['history_spend'];
//            var_dump($history);
//            foreach ($history as $data){
//                var_dump($data);
//            }

            require('view/frontend/reportAccount.php');
        }

    }

    public function testAJAX($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $DBaccount = $getDBData->getAccount($accountId);

            $historySpend = json_decode($DBaccount['history_spend'], true);
            $historylead = json_decode($DBaccount['history_lead'], true);
            $historycostperlead = json_decode($DBaccount['history_costperlead'], true);

            $allData['history_spend'] = $historySpend;
            $allData['history_lead'] = $historylead;
            $allData['history_costperlead'] = $historycostperlead;
            echo json_encode($allData);
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

    public function newExportData($account_Id)
    {
        $userSession = new UserSession();

        if ($userSession->isLogged()) {

            $getDBData = new \App\Model\GetDBData();
            $DBaccounts = $getDBData->getAccount($account_Id);
            $list = array(array('Nom', 'Depenses 30 derniers jours', 'Leads 30 derniers jours', 'Cout par lead 30 derniers jours'),
                array($DBaccounts['account_name'], $DBaccounts['spend30d'], $DBaccounts['leads30d'], $DBaccounts['cost_per_lead30d']));

            $filename = "export.csv";
            $delimiter = ";";
            header('Content-Type: application/csv');
//            header('Content-Disposition: attachment; filename="' . $filename . '";');
            header('Content-Disposition: attachment;filename="' . $filename . '";');
            # Disable caching - HTTP 1.1
            header("Cache-Control: no-cache, no-store, must-revalidate");
            # Disable caching - HTTP 1.0
            header("Pragma: no-cache");
            # Disable caching - Proxies
            header("Expires: 0");

            // open the "output" stream
            // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
            $f = fopen('php://output', 'w');
//            $f = fopen($filename, 'w');
            ob_start();

            foreach ($list as $line) {
                fputcsv($f, $line, $delimiter);
            }
            $string = ob_get_clean();
            exit($string);

            fclose($f);

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
        $confirm_password = $params['confirm_password'];

        //Check errors in typing password x2
        if ($userManager->errorDefiningPassword($access_password, $confirm_password)) {
            $this->SignIn();
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        $IdExists = $userManager->verifyAccessId($access_id);
        $AccountCreated = $userManager->passwordDefined($access_id);
        var_dump($userManager->verifyEmail($access_email));
        if ($userManager->verifyEmail($access_email)) {
            $this->SignIn();

            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        if ($userManager->alreadyDefined) {
            $this->SignIn();
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        if (!$userManager->isId) { //If no Id founded
            $this->SignIn();
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

        //Generate a random string.
        $token = openssl_random_pseudo_bytes(56);

        //Convert the binary data into hexadecimal representation.
        $access_token = bin2hex($token);

        $AccessManager->registerAccess($access_id, $access_email, $access_name, $access_firstname, $access_password, $access_token);


        //Send email with confirmation link

        require('src/Controller/Mailer.php');
        sendMailerTest('serey.chhim@gmail.com', $access_token);

//        require('view/frontend/confirmSignInProcess.php');
        echo $this->twig->render('confirmSignInProcess.twig', ['access_email' => $access_email]);

    }

    public function click2validate($token)
    {
        $accessManager = new ManageAccess();
        $access = $accessManager->searchToken($token);
        $flashbag = new FlashBag();

        if ($access == false) {
            $flashbag->add('token non reconnu', 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        };

        if ($access['activated'] == 1) {
            $flashbag->add('e-mail : ' . $access['access_email'] . ' déjà confirmé!', 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        };

        $accessManager->confirmToken($token);

        echo $this->twig->render('click2validate.twig', ['firstname' => $access['access_firstname']]);
    }

    public function APIGlobalReportDates($account_Id, $start, $end)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
//            die();
            $getAPIData = new \App\Model\GetAPIData();
            $synData = new \App\Model\SyncData();
            $getDBaccounts = new \App\Model\GetDBData();
            //Get data from FB API
//            $getAccounts = $getAPIData->getAccounts(10158484356634381); //my DEV ID
//            $getAccountsId = $getAPIData->getAccountsId(10158484356634381);
            $getMonths = new GetMonths();

            $diff = $getMonths->intervalDate($start, $end);
            $historyData = [];
            foreach ($diff as $currentDate) {
                $bounds = $getMonths->DateBounds($currentDate);
                $compare = $getMonths->isSooner($bounds[1], $end);

                if ($compare < 0) {
                    $historyData[$bounds[0]] = $getAPIData->getFromFieldsDate($account_Id, ['spend'], $bounds[0], $bounds[1]);
                } else {
                    $historyData[$bounds[0]] = $getAPIData->getFromFieldsDate($account_Id, ['spend'], $bounds[0], $end);
                }
            }
            $historyData = json_encode($historyData);
            $synData->UpdateJSONspend($account_Id, [$historyData]);


//            foreach ($getAccountsId as $iterAccount) {
            $getAPIData = new \App\Model\GetAPIData();
//                $accountData = $getAPIData->getFromFields($iterAccount, ['spend']);
            $getAPIData->getFromFields($account_Id, ['spend']);
            if ($getAPIData->hasData) {
                // Make a TRY
                $adSet = new \App\Model\AdSetManager();
                $adSetList = $adSet->getAdSets($account_Id);
                $goal = '';
                foreach ($adSetList as $iterAdSet) {
                    if ($adSet->optimGoal($iterAdSet) == 'LEAD_GENERATION') {
                        $goal = 'LEAD_GENERATION';
                    }
                }
//                if ($goal == 'LEAD_GENERATION') {
//                    $lead = $getAPIData->getDataActionsDates($account_Id, ['actions'], $start, $end)['lead']; // lead
//                    $cost_lead = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $start, $end)['lead']; // cost per lead
//                } else {
//                    $lead = -1;
//                    $cost_lead = -1;
//                }


                $historyLead = [];
                $historyCostperLead = [];
                foreach ($diff as $currentDate) {
                    $bounds = $getMonths->DateBounds($currentDate);
                    $compare = $getMonths->isSooner($bounds[1], $end);
                    if ($goal == 'LEAD_GENERATION') {
                        if ($compare < 0) {
                            $historyLead[$bounds[0]] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $bounds[0], $bounds[1])['lead'];
                            $historyCostperLead[$bounds[0]] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $start, $end)['lead']; // cost per lead
                        } else {
                            $historyLead[$bounds[0]] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $bounds[0], $end)['lead'];
                            $historyCostperLead[$bounds[0]] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $start, $end)['lead']; // cost per lead
                        }
                    } else {
                        $historyLead[$bounds[0]] = -1;
                        $historyCostperLead[$bounds[0]] = -1;
                    }

                }
//                var_dump('MAJ des leads');
                $historyLead = json_encode($historyLead);
                $historyCostperLead = json_encode($historyCostperLead);
                $synData->UpdateJSONlead($account_Id, [$historyLead]);
                $synData->UpdateJSONcostperlead($account_Id, [$historyCostperLead]);
//                var_dump('historylead', $historyLead);
//                echo '<br />';
//                echo '<br />';
//                echo '<br />';
//                var_dump('historycostperlead', $historyCostperLead);
            }


//
//                $name = $getAPIData->getName($account_Id);
//                $synData->isregisteredAccount($account_Id, $getAccountsId);
//
//                $synData->syncAccount($account_Id, [
//                    $name,
//                    $accountData['spend'], //SPEND
//                    $lead,
//                    $cost_lead
//                ]);

//            }
            //Get data from BD MYSQL
            $DBaccounts = $getDBaccounts->getAccounts();
        } else {
        }
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
                // DEBUT DU TEST
//                $test = $getAPIData->getFromFieldsDate($iterAccount, ['spend'], '2019-06-01', '2019-10-01');
//
//                var_dump($test);
//
//                die();
                // FIN DU TEST

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