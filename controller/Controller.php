<?php

namespace SC19DEV\App\Controller;

use SC19DEV\App\Model\Session;
use SC19DEV\App\Model\UserSession;
use SC19DEV\App\Model\UserManager;
use SC19DEV\App\Model\FlashBag;

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
            var_dump('frontend');
            $FrontController = new FrontController();
            $FrontController->GlobalReport($this->access_id);
        } else {
            var_dump('backend');
            $BackController = new BackController();
            $BackController->adminGlobalReport();
        }
    }

    function ReportAccount($accountId)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \SC19DEV\App\Model\GetDBData();
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
}