<?php

namespace App\Controller;

use App\Model\backend\Session;
use App\Model\backend\UserSession;
use App\Model\backend\UserManager;

class FrontController extends Controller
{
//    public function __construct()
//    {
//        var_dump('Instanciation FrontController');
//    }

    public function FrontGlobalReport($access_id)
    {
//        var_dump('access_id : ', $access_id);
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \App\Model\GetDBData();
            $allAccounts = $getDBData->getAccessAccountsId($access_id);
//            var_dump('tous les comptes : ', $allAccounts);
            $DBaccounts = $getDBData->getAccountsFromList($allAccounts);

            require('view/frontend/dashboard.php');
        } else {
            require('view/backend/loginEmail.php');
        }
    }

    public function home()
    {
        require('view/frontend/homeView.php');
    }

}