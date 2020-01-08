<?php

namespace SC19DEV\App\Controller;

// Chargement des classes
require_once('model/GetAPIData.php');
require_once('model/AdSetManager.php');
require_once('model/AdManager.php');
require_once('model/SyncData.php');
require_once('model/GetDBData.php');
require_once('model/ManageAccess.php');

require_once('model/backend/UserSession.php');
require_once('model/backend/UserManager.php');
require_once('model/backend/FlashBag.php');

use SC19DEV\App\Model\Session;
use SC19DEV\App\Model\UserSession;
use SC19DEV\App\Model\UserManager;


class BackController extends Controller
{
//    public function __construct()
//    {
//        var_dump('Instanciation BackController');
//    }

    public function adminVerification()
    {
        $userManager = new UserManager();
        $userExists = $userManager->verifyUser($_POST['email'], $_POST['password']);

        $flashbag = new SC19DEV\App\Model\FlashBag();

        if (!$userManager->isCorrect) {
            $this->Login();
//            adminLogin();
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

        if ($userManager->access_level == 0) {
            $this->GlobalReport($userManager->user_id);
        }
        $this->adminGlobalReport();
    }

    public function adminGlobalReport()
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \SC19DEV\App\Model\GetDBData();
            $DBaccounts = $getDBData->getAccounts();

            require('view/backend/dashboard.php');
        } else {
            require('view/backend/loginEmail.php');
        }
    }

    public function adminManageAccess()
    {
        $userSession = new UserSession();
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

    public function adminAddAccess($account_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \SC19DEV\App\Model\GetDBData();
            $DBaccounts = $getDBData->getAccounts();
            $AccessManager = new \SC19DEV\App\Model\ManageAccess();
            $var = random_int(1e6, 1e9 - 1);
            while ($AccessManager->IdAlreadyUsed($var)) {
                $var = random_int(1e6, 1e9 - 1);
            }
            $AccessManager->addAccess($account_id, $var);

            $this->adminManageAccess();

        } else {
            require('view/backend/login.php');
        }
    }

    public function adminDeleteAccess($access_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \SC19DEV\App\Model\GetDBData();
            $AccessManager = new \SC19DEV\App\Model\ManageAccess();
            $AccessManager->deleteAccess($access_id);

//            $this->adminManageAccess();

        }
    }
}