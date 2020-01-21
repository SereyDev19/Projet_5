<?php

namespace App\Controller;

use App\Model\backend\Session;
use App\Model\backend\UserSession;
use App\Model\backend\UserManager;

use Twig_Loader_Filesystem;
use Twig_Environment;


class FrontController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function FrontGlobalReport($access_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $allAccounts = $getDBData->getAccessAccountsId($access_id);
            $DBaccounts = $getDBData->getAccountsFromList($allAccounts);

            require('view/frontend/dashboard.php');
        } else {
            echo $this->twig->render('loginEmail.twig');
        }
    }

    public function home()
    {
        if (isset($_SESSION['user_id']) AND isset($_SESSION['username'])) {
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['username'];
        } else {
            $user_id = '';
            $user_name = '';
        }
        echo $this->twig->render('homeView.twig', ['user_id' => $user_id, 'user_name' => $user_name]);
    }
}