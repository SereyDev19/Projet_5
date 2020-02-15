<?php

namespace App\Controller;

// Model Namespaces
use App\Config\Config;
use App\Config\PaginatedQuery;
use App\Model\UserManager;
use App\Model\ManageAccess;
use App\Model\GetDBData;
use App\Model\GetAPIData;

// Services Namespaces
use App\Services\DataValidation;
use App\Services\Date;
use App\Services\GetDays;
use App\Services\Session;
use App\Services\UserSession;
use App\Services\SendMailer;
use App\Services\UploadFile;
use App\Services\FlashBag;
use App\Services\GetMonths;

use App\Helper;
use Mpdf\Mpdf;
// Twig Namespaces

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_Extensions_Extension_Text;


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
        $this->twig->addGlobal('SERVER_NAME', $_SERVER['SERVER_NAME']);
        $this->twig->addExtension(new Twig_Extensions_Extension_Text());
    }

    public function definition($word)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];
            $getDBData = new GetDBData($_ENV);
            $result = $getDBData->searchWord($word)[0];

            echo $this->twig->render('definition.html.twig', ['userSession' => $userSession,
                'user_name' => $user_name,
                'result' => $result]);
        }
    }

    public function searchWord($word)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];
            $getDBData = new GetDBData($_ENV);
            $results = $getDBData->searchWord($word);

            echo $this->twig->render('searchWord.html.twig', ['userSession' => $userSession,
                'user_name' => $user_name,
                'results' => $results]);

        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     *  Paginates the results by letter and by page (3 results per page)
     */
    public function letterPagination()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];
            $getDBData = new GetDBData($_ENV);

            $limit = 3; // 5 results per page
            $allLetters = $getDBData->getLetters();
            $alphabet = [];
            foreach (range('A', 'Z') as $i) {
                array_push($alphabet, $i);
            }

            foreach ($allLetters as $letter) {
                $total_results[$letter] = $getDBData->getNumber($letter);
                $total_pages[$letter] = ceil($total_results[$letter] / $limit);
            }

            if (!isset($_GET['letter'])) {
                $letter = 'A';
            } else {
                $letter = $_GET['letter'];
            }
            if (!isset($_GET['page'])) {
                $page = '1';
            } else {
                $page = $_GET['page'];
            }
            $starting_limit = ($page - 1) * $limit;
            $limiteddata = $getDBData->getLimitAccounts($letter, $starting_limit, $limit);
            echo $this->twig->render('glossary.html.twig', ['userSession' => $userSession,
                'user_name' => $user_name,
                'page' => $page,
                'DBData' => $limiteddata,
                'totalpage' => $total_pages[$letter],
                'alphabet' => $alphabet,
                'allLetters' => $allLetters,
                'currentLetter' => $letter]);
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
            // Else : just display the profile page
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
            $file = scandir(__DIR__ . '/../../public/uploads/' . $user_id)[2];

            echo $this->twig->render('profile.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'user_id' => $user_id, 'file' => $file]);
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

//            echo $this->twig->render('detailedReport.html.twig',
//                ['userSession' => $userSession,
//                    'accountId' => $accountId,
//                    'user_name' => $user_name,
//                    'account' => $account,
//                    'adSets' => $adSets,
//                    'allAds' => $allAds]);
            return ['userSession' => $userSession,
                'accountId' => $accountId,
                'user_name' => $user_name,
                'account' => $account,
                'adSets' => $adSets,
                'allAds' => $allAds];
        }
    }

    public function fullDashboard($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];
            $globalData = $this->ReportAccount($accountId);
            $detailedData = $this->DetailedReport($accountId);
            echo $this->twig->render('fullDashboard.html.twig',
                // Global DATA
                ['userSession' => $userSession,
                    'user_name' => $user_name,
                    'DBaccount' => $globalData['DBaccount'],
                    'accountId' => $globalData['accountId'],
                    'valuesSpend' => $globalData['valuesSpend'],
                    'datesSpend' => $globalData['datesSpend'],
                    // Detailed DATA
                    'account' => $detailedData['account'],
                    'adSets' => $detailedData['adSets'],
                    'allAds' => $detailedData['allAds']]);

            //echo $this->twig->render('reportAccount.html.twig', ['userSession' => $userSession,
            // 'user_name' => $user_name,
            // 'DBaccount' => $DBaccount,
            // 'accountId' => $accountId,
            // 'valuesSpend' => $valuesSpend,
            // 'datesSpend' => $datesSpend]);
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

            $valuesSpend = [];
            $valuesLead = [];
            $valuesCostperlead = [];
            $datesSpend = [];
            $datescostperlead = [];
            $dateslead = [];

            if (!$historySpend == null and !$historylead == null and !$historycostperlead == null) {
                $datesSpend = array_keys($historySpend);
                $dateslead = array_keys($historylead);
                $datescostperlead = array_keys($historycostperlead);

                foreach ($historySpend as $data) {
                    array_push($valuesSpend, $data['spend']);
                }
                foreach ($historylead as $data) {
                    array_push($valuesLead, $data);
                }
                foreach ($historycostperlead as $data) {
                    array_push($valuesCostperlead, $data);
                }
            }
            return ['userSession' => $userSession,
                'user_name' => $user_name,
                'DBaccount' => $DBaccount,
                'accountId' => $accountId,
                'valuesSpend' => $valuesSpend,
                'datesSpend' => $datesSpend];
//            echo $this->twig->render('reportAccount.html.twig', ['userSession' => $userSession, 'user_name' => $user_name, 'DBaccount' => $DBaccount, 'accountId' => $accountId, 'valuesSpend' => $valuesSpend, 'datesSpend' => $datesSpend]);
        }
    }

    /**
     * @param $accountId
     * Launches an Ajax procedure to get the data from database
     */
    public function JSONHistoryReport($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData($_ENV);
            $DBaccount = $getDBData->getAccount($accountId);

            $historySpend = json_decode($DBaccount['history_spend'], true);
            $historylead = json_decode($DBaccount['history_lead'], true);
            $historycostperlead = json_decode($DBaccount['history_costperlead'], true);

            $historySpend7d = json_decode($DBaccount['history_spend_d'], true);
            $historylead7d = json_decode($DBaccount['history_lead_d'], true);
            $historycostperlead7d = json_decode($DBaccount['history_costperlead_d'], true);

            $historySpend14d = json_decode($DBaccount['history_spend_14d'], true);
            $historylead14d = json_decode($DBaccount['history_lead_14d'], true);
            $historycostperlead14d = json_decode($DBaccount['history_costperlead_14d'], true);

            $allData['history_spend'] = $historySpend;
            $allData['history_lead'] = $historylead;
            $allData['history_costperlead'] = $historycostperlead;
            $allData['historySpend7d'] = $historySpend7d;
            $allData['historylead7d'] = $historylead7d;
            $allData['historycostperlead7d'] = $historycostperlead7d;
            $allData['historySpend14d'] = $historySpend14d;
            $allData['historylead14d'] = $historylead14d;
            $allData['historycostperlead14d'] = $historycostperlead14d;
            echo json_encode($allData);
        }
    }

    /**
     * @param $accountId
     * Return all data for adsets and ads for an account as a JSON format
     */
    function JSONDetailedReport($accountId)
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

            $res = ['userSession' => $userSession,
                'accountId' => $accountId,
                'user_name' => $user_name,
                'account' => $account,
                'adSets' => $adSets,
                'allAds' => $allAds];

            echo json_encode($res);
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

    public function newExportPDF()
    {
        $mpdf = new Mpdf();
        $code_html = file_get_contents('https://www.google.com/');
//        var_dump($code_html);
        $mpdf->WriteHTML($code_html);
        $mpdf->Output();
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
     * @param $account_Id
     * Export CSV all the detailed data from an $account_Id
     */
    public function newExportDetailedData($account_Id)
    {
        $userSession = new UserSession();

        if ($userSession->isLogged()) {
            $user_name = $_SESSION['username'];

            $getDBData = new \App\Model\GetDBData($_ENV);
            $adSets = $getDBData->getAccountAdSets($account_Id);
            $account = $getDBData->getAccounts($account_Id);

            $allAds = [];
            $listads = [];
            $listadsets = [];
            $titles = array('Nom de l\'ensemble de publicités', 'Dépenses pub', 'CPM', 'Nombre de clics', 'Coût par clic', 'Résultats', ' Coût par résultat', ' Taux d\'achat');
            array_push($listadsets, $titles);
            array_push($listads, $titles);
            $i = 0;
            $j = 0;
            foreach ($adSets as $iterAdSet) {
                $line[$i] = array($iterAdSet['adset_name'], $iterAdSet['spend30d'], $iterAdSet['cpm30d'], $iterAdSet['clicks30d'], $iterAdSet['cost_per_click30d'], $iterAdSet['leads30d'], $iterAdSet['cost_per_lead30d'], $iterAdSet['sell_rate30d']);
                array_push($listadsets, $line[$j]);
                $i += 1;
                //all ads for each adset
                $ads = $getDBData->getAdSetsAds($iterAdSet['adset_id']);
                $allAds[$iterAdSet['adset_id']] = $ads;
            }

            foreach ($allAds as $ads) {
                foreach ($ads as $ad) {
                    $line[$j] = array($ad['ad_name'], $ad['spend30d'], $ad['cpm30d'], $ad['clicks30d'], $ad['cost_per_click30d'], $ad['leads30d'], $ad['cost_per_lead30d'], $ad['sell_rate30d']);
                    array_push($listads, $line[$j]);
                    $j += 1;
                }
            }


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
            foreach ($listadsets as $line) {
                fputcsv($f, $line, $delimiter);
            }
            fputcsv($f, array(), $delimiter);

            foreach ($listads as $line) {
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


            $getAPIData = new \App\Model\GetAPIData($_ENV);
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

                $historyLead = [];
                $historyCostperLead = [];
                foreach ($diff as $currentDate) {
                    $bounds = $getMonths->DateBounds($currentDate);
                    $compare = $getMonths->isSooner($bounds[1], $end);
                    if ($goal == 'LEAD_GENERATION') {
                        if ($compare < 0) {
                            $boundInf = $bounds[0];
                            $boundSup = $bounds[1];
                        } else {
                            $boundInf = $bounds[0];
                            $boundSup = $end;
                        }
                        $historyLead[$modDates->MonthYear($bounds[0])] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $boundInf, $boundSup)['lead'];
                        $historyCostperLead[$modDates->MonthYear($bounds[0])] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $boundInf, $boundSup)['lead']; // cost per lead

                    } else {
                        $historyLead[$bounds[0]] = -1;
                        $historyCostperLead[$bounds[0]] = -1;
                    }
                }
                $historyLead = json_encode($historyLead);
                $historyCostperLead = json_encode($historyCostperLead);
                $synData->UpdateJSONlead($account_Id, [$historyLead]);
                $synData->UpdateJSONcostperlead($account_Id, [$historyCostperLead]);
            }
            //Get data from BD MYSQL
            $DBaccounts = $getDBaccounts->getAccounts();
        } else {
            echo $this->twig->render('loginEmail.html.twig');
        }
    }

    /**
     * @param $account_Id
     * @param $start
     * @param $end
     * Give data from the facebook API day by day between two dates
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function APIGlobalReportDatesDay($account_Id, $start, $end, $days)
    {
//        $userSession = new UserSession();
//        if ($userSession->isLogged()) {
        $getAPIData = new \App\Model\GetAPIData($_ENV);
        $synData = new \App\Model\SyncData($_ENV);
        $getDBaccounts = new \App\Model\GetDBData($_ENV);

        $getDays = new GetDays();
        $modDates = new Date();

        $dates = $getDays->getDatesBetween($start, $end);
        $historyData = [];
        foreach ($dates as $currentDate) {
            $boundInf = $currentDate;
            $boundSup = $currentDate;

            $historyData[$currentDate] = $getAPIData->getFromFieldsDate($account_Id, ['spend'], $boundInf, $boundSup);
        }

        $historyData = json_encode($historyData);
        if ($days == '7') {
            $synData->UpdateJSONspendDay($account_Id, [$historyData]);
        } elseif ($days == '14') {
            $synData->UpdateJSONspendDay14($account_Id, [$historyData]);
        } else {
            $synData->UpdateJSONspendDay($account_Id, [$historyData]);
        }

        $getAPIData = new \App\Model\GetAPIData($_ENV);
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

            $historyLead = [];
            $historyCostperLead = [];
            foreach ($dates as $currentDate) {
                $boundInf = $currentDate;
                $boundSup = $currentDate;
                if ($goal == 'LEAD_GENERATION') {
                    $historyLead[$currentDate] = $getAPIData->getDataActionsDates($account_Id, ['actions'], $boundInf, $boundSup)['lead'];
                    $historyCostperLead[$currentDate] = $getAPIData->getCostDates($account_Id, ['cost_per_action_type'], $boundInf, $boundSup)['lead']; // cost per lead

                } else {
                    $historyLead[$boundInf] = -1;
                    $historyCostperLead[$boundInf] = -1;
                }

            }
            $historyLead = json_encode($historyLead);
            $historyCostperLead = json_encode($historyCostperLead);
            if ($days == '7') {
                $synData->UpdateJSONleadDay($account_Id, [$historyLead]);
                $synData->UpdateJSONcostperleadDay($account_Id, [$historyCostperLead]);
            } elseif ($days == '14') {
                $synData->UpdateJSONleadDay14($account_Id, [$historyLead]);
                $synData->UpdateJSONcostperleadDay14($account_Id, [$historyCostperLead]);
            } else {
                $synData->UpdateJSONleadDay($account_Id, [$historyLead]);
                $synData->UpdateJSONcostperleadDay($account_Id, [$historyCostperLead]);
            }

        }
//            //Get data from BD MYSQL
//            $DBaccounts = $getDBaccounts->getAccounts();
//        }
    }

    /**
     * Get the main statistical data from the Facebook API during the past 30 days
     */
    public function APIGlobalReport()
    {
//        $userSession = new UserSession();
//        if ($userSession->isLogged()) {
        $getAPIData = new \App\Model\GetAPIData($_ENV);
        $synData = new \App\Model\SyncData($_ENV);
        $getDBaccounts = new \App\Model\GetDBData($_ENV);
        //Get data from FB API
        $getAccounts = $getAPIData->getAccounts(10158484356634381); //my DEV ID
        $getAccountsId = $getAPIData->getAccountsId(10158484356634381);

        foreach ($getAccountsId as $iterAccount) {
            $getAPIData = new \App\Model\GetAPIData($_ENV);
            $accountData = $getAPIData->getFromFields($iterAccount, ['spend']);

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
        var_dump('APIGlobalReport OK');
//            //Get data from BD MYSQL
//            $DBaccounts = $getDBaccounts->getAccounts();
//        } else {
//        }
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

//        $userSession = new UserSession();
//        if ($userSession->isLogged()) {

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
//        }
    }

    /**
     * Cron Job
     * update all data for all accounts
     */
    public function updateAllData()
    {
        $getAPIData = new GetAPIData($_ENV);
        //Get data from FB API
        $getAccountsId = $getAPIData->getAccountsId($getAPIData->env['devId']);

        // Get Data from the 30 previous days (default)
//        $this->APIGlobalReport();

        //Get Data from the 7 previous days -- Test works fine
//        foreach ($getAccountsId as $iterAccount) {
//            if ($iterAccount == '331859797400599') {
//                $end = date("Y-m-d");
//                $start = date('Y-m-d', strtotime("$end -7 day"));
//                $this->APIGlobalReportDatesDay($iterAccount, $start, $end,'7');
//            }
//        }

        //Get Data from the 14 previous days
        foreach ($getAccountsId as $iterAccount) {
            if ($iterAccount == '331859797400599') {
                $end = date("Y-m-d");
                $start = date('Y-m-d', strtotime("$end -14 day"));
                $this->APIGlobalReportDatesDay($iterAccount, $start, $end, '14');
            }
        }

        // Get Data between two dates  -- Test works fine
//        foreach ($getAccountsId as $iterAccount) {
//            if ($iterAccount == '331859797400599') {
//                $start = '2019-01-1';
//                $end = '2020-01-12';
//                $this->APIGlobalReportDates($iterAccount, $start, $end);
//            }
//        }

        // Get detailed data  -- Test works fine
//        foreach ($getAccountsId as $iterAccount) {
//            if ($iterAccount == '331859797400599') {
//                $this->APIdetailedReport($iterAccount);
//            }
//        }


    }

}