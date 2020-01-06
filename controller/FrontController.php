<?php

namespace SC19DEV\App\Controller;

use SC19DEV\App\Model\Session;
use SC19DEV\App\Model\UserSession;
use SC19DEV\App\Model\UserManager;

class FrontController
{
    public function GlobalReport($access_id)
    {
        $userSession = new UserSession();
        if ($userSession->isLogged()) {
            $getDBData = new \SC19DEV\App\Model\GetDBData();
            $toto = $getDBData->getAccessAccountsId($access_id);
            $DBaccounts = $getDBData->getAccountsFromList($toto);

            require('view/frontend/dashboard.php');
        } else {
            require('view/backend/loginEmail.php');
        }
    }

}