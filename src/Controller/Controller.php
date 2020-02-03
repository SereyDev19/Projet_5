<?php

namespace App\Controller;

// Model Namespaces
use App\Config\Config;
use App\Config\PaginatedQuery;
use App\Model\UserManager;
use App\Model\ManageAccess;
use App\Model\GetDBData;

// Services Namespaces
use App\Services\DataValidation;
use App\Services\Date;
use App\Services\Session;
use App\Services\UserSession;
use App\Services\SendMailer;
use App\Services\UploadFile;
use App\Services\FlashBag;
use App\Services\GetMonths;
use App\Services\PagerFantaExtension;

use App\Helper;

// Twig Namespaces

use Twig_Loader_Filesystem;
use Twig_Environment;

// Pagerfanta namespaces
use Pagerfanta\View\TwitterBootstrapView;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\View\DefaultView;

class Controller
{
    public $level_Access = 0;
    public $access_id = '';

    /**
     * Controller constructor.
     */
    public function __construct()
    {

        $userSession = new UserSession();
        $userSession->isLogged();

        $this->level_Access = $userSession->levelAccess;
        $this->access_id = $userSession->userId;

        $this->loader = new Twig_Loader_Filesystem(__DIR__ . '/../../public/templates');
        $this->twig = new Twig_Environment($this->loader, [
            'cache' => false
        ]);
        $this->twig->addExtension(new PagerFantaExtension());
        $this->twig->addGlobal('SERVER_NAME', $_SERVER['SERVER_NAME']);
    }

    /**
     * Paginate the results
     */
    public function displayPages()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
//            $view = new DefaultView();
            $config = new Config($_ENV);
            $pagerfanta = $config->findPaginated(12);

//            $view = new TwitterBootstrapView();
//            echo $this->twig->render('testFanta.html.twig',  ['accounts' => $pagerfanta]);

            $view = new DefaultView();
            $options = array('proximity' => 3);
            echo $view->render($pagerfanta, __DIR__ . '/toto', $options);

        }
    }

    /**
     * @param null $page
     * Another test to paginate the results
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function indexAction($page = null)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new GetDBData($_ENV);
            $allAccounts = $getDBData->getAccessAccountsId(12345678);
            $DBaccounts = $getDBData->getAccountsFromList($allAccounts);

//            $get = request()->getQueryParams();
            $view = new TwitterBootstrap4View();
            $adapter = new ArrayAdapter($DBaccounts);
            $currentPage = isset($get['page']) ? $get['page'] : 1;
            $pagerfanta = new Pagerfanta($adapter);
            $itemsPerPage = 2;
            $pagerfanta->setMaxPerPage($itemsPerPage);
            $pagerfanta->setCurrentPage($currentPage);
            $route = function ($page) {
                $path = request()->getUri()->getPath();
                return $path . '?page=' . $page;
            };
//            return [$pagerfanta, $view->render($pagerfanta, $route)];
            $route = 'http://projet_5_test.test/public/admin.php?page=1';
            var_dump($pagerfanta);
            echo $this->twig->render('testFanta.html.twig', ['accounts' => $pagerfanta]);
        }
    }

    /**
     * Validates the login credentials
     */
    public function Verification()
    {
        $userManager = new UserManager($_ENV);
        $datavalidation = new DataValidation();
        $email = $datavalidation->Validation($_POST['email']);
        $password = $datavalidation->Validation($_POST['password']);
        $userExists = $userManager->verifyUser($email, $password);

        $manageAccess = new ManageAccess($_ENV);
        $manageAccess->isActivated($email);


        $flashbag = new FlashBag();

        if (!$userManager->isCorrect) {
            $this->Login([]);
            $flashbag->add($userManager->message, 'error');
            $flashbag->flash();
            $flashbag->fetchMessages();
            exit();
        }

        if (!$manageAccess->activated) {
            $this->Login([]);
            $userManager->message = 'Ce compte n\' a pas encore été activé';
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
    }

    /**
     * Sign in action
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function SignIn()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $this->GlobalReport();
        } else {
            echo $this->twig->render('createAccount.html.twig');

        }
    }

    /**
     * @param array $param
     * Login action
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function Login(array $param)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $this->GlobalReport();
        } else {
            if ($param != null) {
                echo $this->twig->render('loginEmail.html.twig', ['email' => $param[0]]);
            } else {
                echo $this->twig->render('loginEmail.html.twig');
            }
        }
    }

    /**
     * Logout action
     */
    public function Logout()
    {
        $session = new Session();
        $session->stopSession();
        header("Location: index.php");
        exit;
    }

    /**
     * Get the user profile
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function GetProfile()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {

            //If GET['userid'] => uploading profile picture
            if (isset($_GET['userid'])) {
                $Upload = new UploadFile($_GET['userid']);
                $flashbag = new FlashBag();

                $Upload->upload();
                if ($Upload->msgtype == 'error') {
                    $Upload->fileRename();
                }
                $flashbag->add($Upload->message, $Upload->msgtype);
                $flashbag->flash();
                $flashbag->fetchMessages();
            }

            $user_name = $_SESSION['username'];
            $user_id = $_SESSION['user_id'];
            $file = scandir('uploads/' . $user_id)[2];

            echo $this->twig->render('profile.html.twig', ['user_name' => $user_name, 'user_id' => $user_id, 'file' => $file]);
        }
    }

    /**
     * Global report
     */
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

    /**
     * @param $accountId
     * Detailed report with all the statistical data
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    function DetailedReport($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData($_ENV);
            $adSets = $getDBData->getAccountAdSets($accountId);
            $account = $getDBData->getAccounts($accountId);

            $allAds = [];
            foreach ($adSets as $iterAdSet) {
                $ads = $getDBData->getAdSetsAds($iterAdSet['adset_id']);
                $allAds[$iterAdSet['adset_id']] = $ads;
            }
            echo $this->twig->render('detailedReport.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'account' => $account, 'adSets' => $adSets, 'allAds' => $allAds]);

        }
    }

    /**
     * @param $accountId
     * Global reporting for the account $accountId
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function ReportAccount($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData($_ENV);
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

            echo $this->twig->render('reportAccount.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'DBaccount' => $DBaccount, 'accountId' => $accountId, 'valuesSpend' => $valuesSpend, 'datesSpend' => $datesSpend]);

        }

    }

    /**
     * @param $accountId
     * Launches an Ajax procedure to get the data from database
     */
    public function testAJAX($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData($_ENV);
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

    /**
     * Manage the different accesses
     */
    public function ManageAccess()
    {
        if ($this->level_Access == 0) {
// Does not happen
        } else {
            $BackController = new BackController();
            $BackController->adminManageAccess();
        }
    }

    /**
     * @param $account_Id
     * Export CSV data from an $account_Id
     */
    public function newExportData($account_Id)
    {
        $userSession = new UserSession();

        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData($_ENV);
            $DBaccounts = $getDBData->getAccount($account_Id);
            $list = array(array('Nom', 'Depenses 30 derniers jours', 'Leads 30 derniers jours', 'Cout par lead 30 derniers jours'),
                array($DBaccounts['account_name'], $DBaccounts['spend30d'], $DBaccounts['leads30d'], $DBaccounts['cost_per_lead30d']));

            $filename = "export.csv";
            $delimiter = ";";

            header('Content-Description: File Transfer');
            header('Content-Type: text/csv; charset=UTF-16LE');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

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

    /**
     * @param $params
     * Validates (or not) the signing up action for a new user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function RegisterNewAccess($params)
    {
        $userManager = new UserManager($_ENV);
        $flashbag = new FlashBag();
        $dataValidation = new DataValidation();

        $getDBData = new \App\Model\GetDBData($_ENV);
        $DBaccounts = $getDBData->getAccounts();
        $AccessManager = new \App\Model\ManageAccess($_ENV);
        $AccessManager->getAccess();

        $access_id = $dataValidation->Validation($params['access_id']);
        $access_email = $dataValidation->Validation($params['access_email']);
        $access_name = $dataValidation->Validation($params['access_name']);
        $access_firstname = $dataValidation->Validation($params['access_firstname']);
        $access_password = $dataValidation->Validation($params['access_password']);
        $confirm_password = $dataValidation->Validation($params['confirm_password']);

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
        $sendMailer = new SendMailer($_ENV);
        $sendMailer->sendMailer($access_email, $access_token, $access_name, $access_firstname);

        echo $this->twig->render('confirmSignInProcess.html.twig', ['access_email' => $access_email]);

    }

    /**
     * @param $token
     * Validates the activation token sent by email to the new user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function click2validate($token)
    {
        $accessManager = new ManageAccess($_ENV);
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

        echo $this->twig->render('click2validate.html.twig', ['firstname' => $access['access_firstname'], 'email' => $access['access_email']]);
    }

    /**
     * @param $account_Id
     * @param $start
     * @param $end
     * Get the main statistical data from the Facebook API between two dates
     */
    public function APIGlobalReportDates($account_Id, $start, $end)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getAPIData = new \App\Model\GetAPIData($_ENV);
            $synData = new \App\Model\SyncData($_ENV);
            $getDBaccounts = new \App\Model\GetDBData($_ENV);

            $getMonths = new GetMonths();
            $modDates = new Date();

            $diff = $getMonths->intervalDate($start, $end);
            $historyData = [];
            foreach ($diff as $currentDate) {
                $bounds = $getMonths->DateBounds($currentDate);
                $compare = $getMonths->isSooner($bounds[1], $end);

                if ($compare < 0) {
                    $historyData[$modDates->MonthYear($bounds[0])] = $getAPIData->getFromFieldsDate($account_Id, ['spend'], $bounds[0], $bounds[1]);
                } else {
                    $historyData[$modDates->MonthYear($bounds[0])] = $getAPIData->getFromFieldsDate($account_Id, ['spend'], $bounds[0], $end);
                }
            }
            $historyData = json_encode($historyData);

            $synData->UpdateJSONspend($account_Id, [$historyData]);


//            foreach ($getAccountsId as $iterAccount) {
            $getAPIData = new \App\Model\GetAPIData($_ENV);
//                $accountData = $getAPIData->getFromFields($iterAccount, ['spend']);
            $getAPIData->getFromFields($account_Id, ['spend']);
            if ($getAPIData->hasData) {
                // Make a TRY
                $adSet = new \App\Model\AdSetManager($_ENV);
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
//                            $historyLead[$bounds[0]] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $bounds[0], $bounds[1])['lead'];
                            $historyLead[$modDates->MonthYear($bounds[0])] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $bounds[0], $bounds[1])['lead'];
//                            $historyCostperLead[$bounds[0]] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $bounds[0], $bounds[1])['lead']; // cost per lead
                            $historyCostperLead[$modDates->MonthYear($bounds[0])] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $bounds[0], $bounds[1])['lead']; // cost per lead
                        } else {
//                            $historyLead[$bounds[0]] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $bounds[0], $end)['lead'];
                            $historyLead[$modDates->MonthYear($bounds[0])] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $bounds[0], $end)['lead'];
//                            $historyCostperLead[$bounds[0]] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $bounds[0], $end)['lead']; // cost per lead
                            $historyCostperLead[$modDates->MonthYear($bounds[0])] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $bounds[0], $end)['lead']; // cost per lead
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

    /**
     * Get the main statistical data from the Facebook API during the past 30 days
     */
    public function APIGlobalReport()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getAPIData = new \App\Model\GetAPIData($_ENV);
            $synData = new \App\Model\SyncData($_ENV);
            $getDBaccounts = new \App\Model\GetDBData($_ENV);
            //Get data from FB API
            $getAccounts = $getAPIData->getAccounts(10158484356634381); //my DEV ID
            $getAccountsId = $getAPIData->getAccountsId(10158484356634381);

            foreach ($getAccountsId as $iterAccount) {
                $getAPIData = new \App\Model\GetAPIData($_ENV);
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
                    $adSet = new \App\Model\AdSetManager($_ENV);
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

    /**
     * @param $accountId
     * Remove?
     */
    public function APIReportAccount($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getAPIData = new \App\Model\GetAPIData($_ENV);

            $res = $getAPIData->getFromFields($accountId, ['spend']);
            $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
            $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
        }
    }

    /**
     * @param $accountId
     * Get the detailed statistical data from the Facebook API during the past 30 days
     */
    public function APIdetailedReport($accountId)
    {

        $userSession = new UserSession();
        if ($userSession->isLogged()) {

            $getAPIData = new \App\Model\GetAPIData($_ENV);
            $adSet = new \App\Model\AdSetManager($_ENV);
            $ad = new \App\Model\AdManager($_ENV);
            $bddAdSet = new \App\Model\SyncData($_ENV);
            $bddAd = new \App\Model\SyncData($_ENV);

            $res = $getAPIData->getFromFields($accountId, ['spend']);
            $lead = $getAPIData->getDataActions($accountId, ['actions']); // lead
            $cost_lead = $getAPIData->getCost($accountId, ['cost_per_action_type']); // cost per lead
            $adSetList = $adSet->getAdSets($accountId);

            $registerAd = $bddAd->getBddAds($accountId);


            $registerAdSet = $bddAdSet->getBddAdSets($accountId);
            foreach ($adSetList as $iterAdSet) {

                $adSet = new \App\Model\AdSetManager($_ENV);
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
                        $ad = new \App\Model\AdManager($_ENV);
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